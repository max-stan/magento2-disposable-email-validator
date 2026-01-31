# Magento 2 Disposable Email Validator

> Adds ability to block against 90,000+ known disposable/temporary email domains during customer registration.

[![Packagist](https://img.shields.io/packagist/v/max-stan/magento2-disposable-email-validator?style=for-the-badge)](https://packagist.org/packages/max-stan/magento2-disposable-email-validator)
[![Packagist](https://img.shields.io/packagist/dt/max-stan/magento2-disposable-email-validator?style=for-the-badge)](https://packagist.org/packages/max-stan/magento2-disposable-email-validator)
[![Packagist](https://img.shields.io/packagist/dm/max-stan/magento2-disposable-email-validator?style=for-the-badge)](https://packagist.org/packages/max-stan/magento2-disposable-email-validator)

## Description

Disposable email addresses (like tempmail.com, guerrillamail.com, etc.) are commonly used for spam registrations,
fake accounts, and abuse. This module validates emails against 90,000+ known disposable email domains and blocks
them during customer registration.

**Recommended usage:** By default, Magento does not require email confirmation during customer registration.
Without email confirmation enabled, blocking disposable emails has limited effect — users can still register with any
fake but valid-looking email address.
I recommend enabling this module alongside Magento's email confirmation feature
(**Stores → Configuration → Customers → Customer Configuration → Create New Account Options → Require Emails Confirmation**).

### Features

- Validates against 90,000+ disposable email domains (auto-updated via composer)
- Custom blocklist — add your own domains to block
- Whitelist support — allow specific domains to bypass validation

## Installation

To install module in your Magento 2 project, follow these steps:

```shell
composer require max-stan/magento2-disposable-email-validator
bin/magento mod:en MaxStan_DisposableEmailValidator
bin/magento setup:upgrade
bin/magento setup:di:compile
```

## Magento Compatibility

- Magento 2.4.x
- PHP 8.2+

## Contributing

Contributions are welcome! If you find a bug or have a feature request, feel free to open an issue or submit a pull request.
