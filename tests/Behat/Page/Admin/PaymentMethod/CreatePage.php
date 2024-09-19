<?php

declare(strict_types=1);

namespace Tests\Blockonomics\SyliusBlockonomicsPlugin\Behat\Page\Admin\PaymentMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    // public function setMerchantId(string $merchantId): void
    // {
    //     $this->getDocument()->fillField('Merchant ID', $merchantId);
    // }

    // public function setPublicKey(string $publicKey): void
    // {
    //     $this->getDocument()->fillField('Public Key', $publicKey);
    // }

    // public function setPrivateKey(string $privateKey): void
    // {
    //     $this->getDocument()->fillField('Private Key', $privateKey);
    // }

    // public function checkSandbox(): void
    // {
    //     $this->getDocument()->checkField('Sandbox');
    // }

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