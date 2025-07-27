<?php

// QR Code Create Page - Hello World

$currentTime = date('Y年m月d日 H:i:s');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Create Page - Hello World</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            margin: 2rem;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        .info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin: 1.5rem 0;
        }
        .time {
            color: #007bff;
            font-weight: bold;
        }
        .footer {
            margin-top: 2rem;
            color: #999;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 Hello World!</h1>
        <p class="subtitle">QR Code Create Page へようこそ</p>
        
        <div class="info">
            <p><strong>🕐 現在時刻:</strong> <span class="time"><?php echo $currentTime; ?></span></p>
            <p><strong>🌏 デプロイ先:</strong> AWS Lambda (東京リージョン)</p>
            <p><strong>⚡ ランタイム:</strong> PHP 8.4 + Bref</p>
        </div>
        
        <div class="footer">
            <p>Powered by Bref & Serverless Framework</p>
        </div>
    </div>
</body>
</html>
