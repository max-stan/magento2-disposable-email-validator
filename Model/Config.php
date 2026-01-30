<?php

declare(strict_types=1);

namespace MaxStan\DisposableEmailValidator\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Configuration reader for Disposable Email Validator module.
 */
readonly class Config
{
    private const string XML_PATH_VALIDATE_CUSTOMER = 'customer/disposable_email_validator/validate_customer_registration';
    private const string XML_PATH_VALIDATE_NEWSLETTER = 'customer/disposable_email_validator/validate_newsletter';
    private const string XML_PATH_BLOCKED_DOMAINS = 'customer/disposable_email_validator/blocked_domains';
    private const string XML_PATH_ALLOWED_DOMAINS = 'customer/disposable_email_validator/allowed_domains';

    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Check if customer registration validation is enabled.
     */
    public function isCustomerRegistrationValidationEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_VALIDATE_CUSTOMER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if newsletter subscription validation is enabled.
     */
    public function isNewsletterValidationEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_VALIDATE_NEWSLETTER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get custom blocked domains from configuration.
     *
     * @return string[]
     */
    public function getBlockedDomains(?int $storeId = null): array
    {
        $domains = $this->scopeConfig->getValue(
            self::XML_PATH_BLOCKED_DOMAINS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $this->parseDomainsString($domains);
    }

    /**
     * Get allowed (whitelisted) domains from configuration.
     *
     * @return string[]
     */
    public function getAllowedDomains(?int $storeId = null): array
    {
        $domains = $this->scopeConfig->getValue(
            self::XML_PATH_ALLOWED_DOMAINS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $this->parseDomainsString($domains);
    }

    /**
     * Parse domains string (one per line) into array.
     *
     * @return string[]
     */
    private function parseDomainsString(?string $domains): array
    {
        if (!$domains) {
            return [];
        }

        $domainList = preg_split('/\r\n|\r|\n/', $domains);
        if (!$domainList) {
            return [];
        }

        return array_filter(
            array_map('trim', $domainList),
            fn (string $domain): bool => $domain !== ''
        );
    }
}
