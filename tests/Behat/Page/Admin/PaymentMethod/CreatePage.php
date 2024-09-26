<?php

declare(strict_types=1);

namespace Tests\Blockonomics\SyliusBlockonomicsPlugin\Behat\Page\Admin\PaymentMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    public function setApiKey(string $apiKey): void
    {
        $this->getDocument()->fillField('Api Key', $apiKey);
    }

    public function setCallbackUrl(string $callbackUrl): void
    {
        $this->getDocument()->fillField('Callback URL', $callbackUrl);
    }

    public function setCallbackSecret(string $callbackSecret): void
    {
        $this->getDocument()->fillField('Callback Secret', $callbackSecret);
    }

    public function containsErrorWithMessage(string $message, bool $strict = true): bool
    {
        $validationMessageElements = $this->getDocument()->findAll('css', '.sylius-validation-error');
        $result = false;

        /** @var NodeElement $validationMessageElement */
        foreach ($validationMessageElements as $validationMessageElement) {
            if (true === $strict && $message === $validationMessageElement->getText()) {
                return true;
            }

            if (false === $strict && strstr($validationMessageElement->getText(), $message)) {
                return true;
            }
        }

        return $result;
    }
}