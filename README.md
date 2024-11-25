# Telegram URL Shortener Bot

A PHP-based Telegram bot that creates short URLs using the Short.io API. Users can send a long URL followed by a custom path to receive a shortened version.

## Features

* Create custom short URLs through Telegram
* User-friendly conversation flow
* Custom path support for shortened URLs
* Secure API handling
* Webhook-based updates
* State management for multi-step operations

## Prerequisites

* PHP 7.4 or higher
* SSL certificate (required for Telegram webhooks)
* Web hosting with PHP support
* Composer for dependency management
* Telegram Bot Token (from [@BotFather](https://t.me/BotFather))
* Short.io API Key

## Installation

1. Clone the repository or download the source code:
```bash
git clone https://github.com/GitShikari/php-shortio-tg-bot
cd telegram-url-shortener
```

2. Install dependencies using Composer:
```bash
composer install
```

3. Copy the example configuration file:
```bash
cp config.example.php config.php
```

4. Update the configuration in `config.php` with your credentials:
```php
return [
    'telegram_token' => 'YOUR_TELEGRAM_BOT_TOKEN',
    'shortio_token' => 'YOUR_SHORTIO_API_TOKEN',
    'shortio_domain' => 'YOUR_SHORTIO_DOMAIN'
];
```

## Configuration

### Telegram Bot Setup

1. Create a new bot through [@BotFather](https://t.me/BotFather):
   * Send `/newbot` to BotFather
   * Choose a name for your bot
   * Choose a username for your bot
   * Save the provided token

2. Set up the webhook:
   ```
   curl -F "url=https://your-server.com/your-bot.php" https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook
   ```

### Short.io Setup

1. Sign up for a [Short.io](https://short.io) account
2. Get your API key from the dashboard
3. Note your custom domain (or use the provided one)

## Usage

### Bot Commands

1. Start the bot:
   * Send `/start` to get the welcome message

2. Create a short URL:
   * Send the original URL (must start with http:// or https://)
   * Send the desired custom path for the short URL

Example conversation:
```
User: /start
Bot: Hello! Send me a link, and I'll shorten it for you.

User: https://www.example.com/very/long/url/that/needs/shortening
Bot: Short URL: https://h04d.short.gy/custom-path
```

## Directory Structure

```
telegram-url-shortener/
├── bot.php              # Main bot file
└── README.md           # This file
```

## Security Considerations

* Keep your bot token and API keys secure
* Use HTTPS for your webhook endpoint
* Validate all user inputs
* Store sensitive information in environment variables
* Regularly update dependencies

## Error Handling

The bot includes error handling for:
* Invalid URLs
* Failed API requests
* Network issues
* Invalid user inputs

## Deployment

1. Upload the files to your web server
2. Ensure the domain has a valid SSL certificate
3. Configure your web server (Apache/Nginx) to handle PHP files
4. Set up the webhook using the setup URL
5. Test the bot by sending messages

### Apache Configuration Example

```apache
<VirtualHost *:443>
    ServerName your-domain.com
    DocumentRoot /path/to/bot/directory
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    
    <Directory /path/to/bot/directory>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Troubleshooting

Common issues and solutions:

1. Webhook not working:
   * Verify SSL certificate is valid
   * Check webhook URL is correct
   * Ensure proper permissions on files

2. Bot not responding:
   * Check error logs
   * Verify bot token is correct
   * Ensure webhook is properly set up

3. Short URL creation fails:
   * Verify Short.io API key
   * Check API response for error messages
   * Validate input URL format

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please:
1. Check the troubleshooting section
2. Review the error logs
3. Open an issue in the repository
4. Contact the maintainer

## Acknowledgments

* Telegram Bot API
* Short.io API
* PHP community
* Contributors and testers

## Version History

* 1.0.0
  * Initial release
  * Basic URL shortening functionality
  * Webhook support
