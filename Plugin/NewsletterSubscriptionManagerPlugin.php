<?php

declare(strict_types=1);

namespace MaxStan\DisposableEmailValidator\Plugin;

use Magento\Framework\Exception\LocalizedException;
use Magento\Newsletter\Model\SubscriptionManagerInterface;
use MaxStan\DisposableEmailValidator\Api\DisposableEmailValidatorInterface;
use MaxStan\DisposableEmailValidator\Model\Config;

/**
 * Plugin to validate email during newsletter subscription.
 */
class NewsletterSubscriptionManagerPlugin
{
    public function __construct(
        private readonly DisposableEmailValidatorInterface $validator,
        private readonly Config $config
    ) {
    }

    /**
     * @throws LocalizedException
     */
    public function beforeSubscribe(
        SubscriptionManagerInterface $subject,
        string $email,
        int $storeId
    ): array {
        $result = [$email, $storeId];
        if (!$this->config->isNewsletterValidationEnabled($storeId)) {
            return $result;
        }

        if ($this->validator->isDisposable($email)) {
            throw new LocalizedException(
                __('Newsletter subscription with disposable email addresses is not allowed. Please use a valid email address.')
            );
        }

        return $result;
    }
}
