<?php

declare(strict_types=1);

namespace Tests\Blockonomics\SyliusBlockonomicsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\Blockonomics\SyliusBlockonomicsPlugin\Behat\Page\Admin\PaymentMethod\CreatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingPaymentMethodContext implements Context
{
    /** @var CreatePageInterface */
    private $createPage;

    public function __construct(CreatePageInterface $createPage)
    {
        $this->createPage = $createPage;
    }

    /**
     * @Given I want to create a new Blockonomics payment method
     */
    public function iWantToCreateANewBlockonomicsPaymentMethod(): void
    {
        $this->createPage->open(['factory' => 'blockonomics']);
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatCannotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->createPage->containsErrorWithMessage(sprintf(
                '%s cannot be blank.',
                trim($field)
            )));
        }
    }

    /**
     * @Then I should be notified that :message
     */
    public function iShouldBeNotifiedThat(string $message): void
    {
        Assert::true($this->createPage->containsErrorWithMessage($message));
    }

    /**
     * @When I fill the Api Key with :apiKey
     */
    public function iFillTheApiKeyWith(string $apiKey): void
    {
        $this->createPage->setApiKey($apiKey);
    }

    /**
     * @When I fill the Callback URL with :callbackUrl
     */
    public function iFillTheCallbackUrlWith(string $callbackUrl): void
    {
        $this->createPage->setCallbackUrl($callbackUrl);
    }

    /**
     * @When I fill the Callback Secret with :callbackSecret
     */
    public function iFillTheCallbackSecretWith(string $callbackSecret): void
    {
        $this->createPage->setCallbackSecret($callbackSecret);
    }
}