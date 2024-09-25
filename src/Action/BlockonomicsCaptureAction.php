<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;
use Symfony\Component\HttpFoundation\Response;
use Payum\Core\Request\RenderTemplate;
use Payum\Core\Reply\HttpResponse;

class BlockonomicsCaptureAction implements ActionInterface, GatewayAwareInterface
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

        $model = ArrayObject::ensureArrayObject($request->getModel());

        // Render and display the payment screen
        $response = new Response(
            $this->renderTemplate($this->templateName, ['model' => $model])
        );
        $response->send();
        exit;


        // Here, implement the logic to check if the payment was successful
        // You might need to make API calls to Blockonomics to verify the payment status
        
        // If payment is confirmed, update the model
        // $model['status'] = 'paid';
    }

    public function supports($request): bool
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess;
    }

    private function renderTemplate(string $templateName, array $parameters): string
    {
        $model = $parameters['model'];
        $btcAddress = 'your_btc_address';
        $btcAmount = '0.01'; // Example amount
        $btcPrice = '1000'; // Example price
        $currency = $model['currency']; // Example currency
        $amount = $model['amount'] / 100; // Example amount     
        $orderNumber = $model['invoiceNumber']; // Example order number

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
}