<?php

declare(strict_types=1);

namespace MaxStan\DisposableEmailValidator\Api;

use MaxStan\DisposableEmailValidator\Exception\DisposableEmailException;

/**
 * Interface for validating email addresses against disposable email providers.
 *
 * @api
 */
interface DisposableEmailValidatorInterface
{
    /**
     * Validate email address against disposable email blocklist.
     *
     * @throws DisposableEmailException
     */
    public function validate(string $email): void;

    /**
     * Check if email address belongs to a disposable email provider.
     */
    public function isDisposable(string $email): bool;
}
