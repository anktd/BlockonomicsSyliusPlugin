<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\RenderTemplate;

final class BlockonomicsPaymentScreen implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    private string $templateName;

    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);    
        
        // Logic to generate BTC address and amount
        $btcAddress = 'your_btc_address';
        $btcAmount = '0.01'; // Example amount
        $btcPrice = '1000'; // Example price
        $currency = 'USD'; // Example currency
        $amount = '456'; // Example amount     
        $orderNumber = '123'; // Example order number

        $this->gateway->execute($template = new RenderTemplate($this->templateName, [
            'btc_address' => $btcAddress,
            'btc_amount' => $btcAmount,
            'btc_price' => $btcPrice,
            'currency' => $currency,
            'formAction' => '',
            'amount' => $amount,
            'order_number' => $orderNumber,
        ]));

        throw new HttpResponse($template->getResult());
    }

    public function supports($request): bool
    {
        return true;
    }
}