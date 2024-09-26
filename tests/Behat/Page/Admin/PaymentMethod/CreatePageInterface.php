<?php

declare(strict_types=1);

namespace Tests\Blockonomics\SyliusBlockonomicsPlugin\Behat\Page\Admin\PaymentMethod;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function setApiKey(string $apiKey): void;

    public function setCallbackUrl(string $callbackUrl): void;

    public function setCallbackSecret(string $callbackSecret): void;
}