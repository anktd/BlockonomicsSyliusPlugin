<?php

namespace Blockonomics\SyliusBlockonomicsPlugin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BlockonomicsController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("/api/blockonomics/price", name="blockonomics_price")
     */
    public function getPrice(Request $request): JsonResponse
    {
        $currencyCode = $request->query->get('currency', 'USD');
        $url = 'https://www.blockonomics.co/api/price?currency=' . $currencyCode;

        $response = $this->httpClient->request('GET', $url);

        try {
            $response = $this->httpClient->request('GET', $url);

            if ($response->getStatusCode() === 200) {
                $data = $response->toArray();
                if (isset($data['price'])) {
                    return new JsonResponse($data['price']);
                } else {
                    return new JsonResponse(['error' => 'Price not found in response'], 500);
                }
            } else {
                return new JsonResponse(['error' => 'Something went wrong'], $response->getStatusCode());
            }
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return new JsonResponse(['error' => 'HTTP request failed: ' . $e->getMessage()], 500);
        }
    }
}