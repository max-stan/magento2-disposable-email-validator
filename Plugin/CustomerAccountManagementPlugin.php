<?php

declare(strict_types=1);

namespace MaxStan\DisposableEmailValidator\Plugin;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use MaxStan\DisposableEmailValidator\Api\DisposableEmailValidatorInterface;
use MaxStan\DisposableEmailValidator\Model\Config;

/**
 * Plugin to validate email during customer account creation.
 */
class CustomerAccountManagementPlugin
{
    public function __construct(
        private readonly DisposableEmailValidatorInterface $validator,
        private readonly Config $config
    ) {
    }

    /**
     * @throws LocalizedException
     */
    public function beforeCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $customer,
        ?string $password = null,
        string $redirectUrl = ''
    ): array {
        $result = [$customer, $password, $redirectUrl];
        $email = $customer->getEmail();
        if (
            !$this->config->isCustomerRegistrationValidationEnabled()
            || !$email
        ) {
            return $result;
        }

        if ($this->validator->isDisposable($email)) {
            throw new LocalizedException(
                __('Registration with disposable email addresses is not allowed. Please use a valid email address.')
            );
        }

        return $result;
    }
}
