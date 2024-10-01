<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\ApiClient;

class BlockonomicsApiClient implements BlockonomicsApiClientInterface
{
    private array $options = [];

    public function initialise(array $options): void
    {
        $this->options = $options;
    }

    public function getApiKey(): ?string
    {
        return $this->options['apiKey'] ?? null;
    }

    public function getCallbackSecret(): ?string
    {
        return $this->options['callbackSecret'] ?? null;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->options['callbackUrl'] ?? null;
    }
}