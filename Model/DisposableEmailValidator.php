<?php

declare(strict_types=1);

namespace MaxStan\DisposableEmailValidator\Model;

use Beeyev\DisposableEmailFilter\DisposableEmailFilter;
use Beeyev\DisposableEmailFilter\Exceptions\InvalidEmailAddressException;
use MaxStan\DisposableEmailValidator\Api\DisposableEmailValidatorInterface;
use MaxStan\DisposableEmailValidator\Exception\DisposableEmailException;

/**
 * Validates email addresses against known disposable email providers.
 */
class DisposableEmailValidator implements DisposableEmailValidatorInterface
{
    private ?DisposableEmailFilter $disposableEmailFilter = null;

    public function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(string $email): void
    {
        if ($this->isDisposable($email)) {
            throw new DisposableEmailException(
                __('Disposable email address detected.')
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function isDisposable(string $email): bool
    {
        $filter = $this->getEmailFilter();
        if (!$filter->isEmailAddressValid($email)) {
            return false;
        }

        try {
            return $filter->isDisposableEmailAddress($email);
        } catch (InvalidEmailAddressException) {
            return false;
        }
    }

    /**
     * Create and configure the disposable email filter.
     */
    private function getEmailFilter(): DisposableEmailFilter
    {
        if ($this->disposableEmailFilter) {
            return $this->disposableEmailFilter;
        }

        $this->disposableEmailFilter = new DisposableEmailFilter();
        // Add custom blocked domains from admin config
        $blockedDomains = $this->config->getBlockedDomains();
        if ($blockedDomains !== []) {
            $this->disposableEmailFilter->blacklistedDomains()->addMultiple($blockedDomains);
        }

        // Add whitelisted domains from admin config
        $allowedDomains = $this->config->getAllowedDomains();
        if ($allowedDomains !== []) {
            $this->disposableEmailFilter->whitelistedDomains()->addMultiple($allowedDomains);
        }

        return $this->disposableEmailFilter;
    }
}
