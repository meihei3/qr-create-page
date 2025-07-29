# QR Code Generator

A modern web-based QR code generator with favicon overlay functionality, built with PHP and deployed on AWS Lambda using Bref.

## Features

- **SVG QR Code Generation**: High-quality, scalable QR codes in SVG format
- **Favicon Overlay**: Automatically fetches and displays website favicons as overlay
- **Google Favicon Service**: Uses Google's favicon API for reliable favicon retrieval
- **Responsive Design**: Mobile-friendly interface with gradient background
- **Serverless Deployment**: Deployed on AWS Lambda with Bref for cost-effective scaling

## Demo

🔗 **Live Demo**: https://u7f32phomuw7xbv434d2oqfqf40jadkk.lambda-url.ap-northeast-1.on.aws/

## Tech Stack

- **Backend**: PHP 8.3 with Slim Framework
- **QR Code Library**: Endroid/QrCode
- **Templating**: Twig
- **HTTP Client**: Symfony HttpClient
- **Dependency Injection**: PHP-DI
- **Deployment**: Bref (Serverless PHP on AWS Lambda)
- **Infrastructure**: AWS Lambda, CloudFormation

## Architecture

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend        │    │   External      │
│                 │    │                  │    │                 │
│ HTML/CSS/Twig   │───▶│ QrCodeService    │    │ Google Favicon  │
│ Responsive UI   │    │ FaviconService   │◀───│ API             │
│                 │    │ QrCodeController │    │                 │
└─────────────────┘    └──────────────────┘    └─────────────────┘
                              │
                              ▼
                       ┌──────────────────┐
                       │   AWS Lambda     │
                       │   (Bref)         │
                       └──────────────────┘
```

## Project Structure

```
├── src/
│   ├── Controllers/
│   │   └── QrCodeController.php      # Main controller handling requests
│   ├── Services/
│   │   ├── QrCodeService.php         # QR code generation logic
│   │   ├── QrCodeServiceInterface.php
│   │   ├── FaviconService.php        # Favicon fetching logic
│   │   └── FaviconServiceInterface.php
│   └── Views/
│       ├── ViewManager.php           # Twig setup
│       └── templates/
│           └── index.html.twig       # Main template
├── index.php                         # Application entry point & DI setup
├── serverless.yml                    # Serverless configuration
└── composer.json                     # PHP dependencies
```

## Installation & Development

### Prerequisites

- PHP 8.3+
- Composer
- Node.js & npm (for Serverless Framework)

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/meihei3/qr-create-page.git
   cd qr-create-page
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Serverless Framework**
   ```bash
   npm install -g serverless
   npm install
   ```

4. **Run locally**
   ```bash
   php -S localhost:8000 index.php
   ```

### Deployment

1. **Configure AWS credentials**
   ```bash
   aws configure
   ```

2. **Deploy to AWS Lambda**
   ```bash
   serverless deploy
   ```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Main QR code generator page |
| GET | `/generate?url={url}` | Generate QR code for given URL |
| GET | `/favicon.ico` | Return QR code as favicon |

## Configuration

### Environment Variables

No environment variables are required for basic functionality.

### Serverless Configuration

The `serverless.yml` file contains:
- AWS Lambda function configuration
- Bref runtime layer setup
- HTTP API Gateway integration
