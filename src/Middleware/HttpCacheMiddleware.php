<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpCacheMiddleware implements MiddlewareInterface
{
    private array $cacheConfig;

    public function __construct(array $cacheConfig = [])
    {
        $this->cacheConfig = array_merge([
            'default_ttl' => 3600,
            'routes' => [
                '/generate' => ['ttl' => 3600, 'key_params' => ['url']],
                '/favicon.ico' => ['ttl' => 86400, 'key_params' => []],
            ]
        ], $cacheConfig);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        $cacheRule = $this->getCacheRule($path);
        if (!$cacheRule) {
            return $handler->handle($request);
        }

        $cacheKey = $this->generateCacheKey($request, $cacheRule);
        $etag = '"' . md5($cacheKey) . '"';

        $clientETag = $request->getHeaderLine('If-None-Match');
        if ($clientETag === $etag) {
            return $this->createNotModifiedResponse();
        }

        $response = $handler->handle($request);

        return $this->addCacheHeaders($response, $cacheRule['ttl'], $etag);
    }

    private function getCacheRule(string $path): ?array
    {
        return $this->cacheConfig['routes'][$path] ?? null;
    }

    private function generateCacheKey(ServerRequestInterface $request, array $cacheRule): string
    {
        $keyParts = [$request->getUri()->getPath()];
        
        foreach ($cacheRule['key_params'] as $param) {
            $value = $request->getQueryParams()[$param] ?? '';
            $keyParts[] = $param . '=' . $value;
        }
        
        return implode('|', $keyParts);
    }

    private function addCacheHeaders(ResponseInterface $response, int $ttl, string $etag): ResponseInterface
    {
        return $response
            ->withHeader('Cache-Control', 'public, max-age=' . $ttl)
            ->withHeader('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + $ttl))
            ->withHeader('ETag', $etag);
    }

    private function createNotModifiedResponse(): ResponseInterface
    {
        $response = new \Slim\Psr7\Response();
        return $response->withStatus(304);
    }
}