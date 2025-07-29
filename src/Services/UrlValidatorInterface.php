<?php

namespace App\Services;

interface UrlValidatorInterface
{
    /**
     * Validate URL and return validation result
     *
     * @param string $url The URL to validate
     * @return array{valid: bool, error: string}
     */
    public function validate(string $url): array;
}