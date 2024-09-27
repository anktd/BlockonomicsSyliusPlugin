<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;
use Symfony\Component\HttpFoundation\Response;
use Payum\Core\Request\RenderTemplate;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Reply\HttpResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


class BlockonomicsCaptureAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    private string $templateName;
    private $config;

    public function __construct(string $templateName, ArrayObject $config)
    {
        $this->templateName = $templateName;
        // Retrieve the API key
        $this->apiKey = $config['apiKey'] ?? null;
        if (!$this->apiKey) {
            throw new \LogicException('The api key parameter is required');
        }
    }

    private function makeApiRequest(string $url, array $headers = [], string $method = 'GET'): array
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'message' => "cURL Error: $error",
            ];
        }

        curl_close($ch);

        $data = json_decode($response, true);

        return [
            'success' => $httpCode == 200,
            'data' => $data,
            'httpCode' => $httpCode,
            'message' => $data['message'] ?? 'Unexpected response',
        ];
    }

    public function getBTCPrice(string $currencyCode): string
    {
        $url = "https://www.blockonomics.co/api/price?currency=$currencyCode";
        $response = $this->makeApiRequest($url);

        if ($response['success'] && isset($response['data']['price'])) {
            return (string)$response['data']['price'];
        }

        return $response['message'] ?? 'Failed to get BTC price';
    }

    public function getBTCAddress(): string
    {
        $url = 'https://www.blockonomics.co/api/new_address?reset=1';
        $headers = ["Authorization: Bearer {$this->apiKey}"];
        $response = $this->makeApiRequest($url, $headers, 'POST');

        if ($response['success'] && isset($response['data']['address'])) {
            return $response['data']['address'];
        }

        throw new \RuntimeException($response['message'] ?? 'Failed to get BTC address');
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $btcAddress = $this->getBTCAddress();
        $currency = $model['currency'];
        $btcPrice = $this->getBTCPrice($currency);
        $amount = $model['amount'] / 100; // Example amount
        $btcAmount = round($amount / $btcPrice, 10);
        $orderNumber = $model['invoiceNumber']; // Example order number

        $this->gateway->execute($clientHttpRequest = new GetHttpRequest());

        $status = new GetStatus($request->getModel());
        $this->gateway->execute($status);
        $status->markCaptured();

        // if (array_key_exists('txid', $clientHttpRequest->request)) {
        //     $txid = $clientHttpRequest->request['txid'];

            
        //     $token = $request->getToken();
        //     echo $model['status'];
        //     echo $token->getAfterUrl();
        //     $response = new RedirectResponse($token->getAfterUrl());
            
        //     $response->send();
        // }
        $model['status'] = 'pending';
        $after_url = $request->getToken()->getAfterUrl();
        $this->gateway->execute($template = new RenderTemplate($this->templateName, [
            'btc_address' => $btcAddress,
            'btc_amount' => $btcAmount,
            'btc_price' => $btcPrice,
            'currency' => $currency,
            'formAction' => $after_url,
            'after_url' => $after_url,
            'amount' => $amount,
            'order_number' => $orderNumber,
            'payment_id' => $model['payment_id'],
        ]));
        throw new HttpResponse($template->getResult());
        $response->send();
        exit;

    }

    public function supports($request): bool
    {
        return $request instanceof Capture && $request->getModel() instanceof \ArrayAccess;
    }

}