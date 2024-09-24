<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin;

use Blockonomics\SyliusBlockonomicsPlugin\Action\Api\DoSaleAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\Api\FindPaymentMethodNonceAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\Api\GenerateClientTokenAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\CaptureAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\ConvertPaymentAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\BlockonomicsPaymentScreen;
use Blockonomics\SyliusBlockonomicsPlugin\Action\ObtainPaymentMethodNonceAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\PurchaseAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\StatusAction;
use Blockonomics\SyliusBlockonomicsPlugin\ApiClient\BlockonomicsApiClientInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

final class BlockonomicsGatewayFactory extends GatewayFactory
{
    public const FACTORY_NAME = 'blockonomics';

    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => self::FACTORY_NAME,
            'payum.factory_title' => 'blockonomics',
            'payum.http_client' => '@blockonomics_sylius_blockonomics_plugin.api_client.blockonomics',
            'payum.template.blockonomics_payment_screen' => '@BlockonomicsSyliusBlockonomicsPlugin/Action/blockonomics_payment_screen.html.twig',
            'payum.action.authorize' => function (ArrayObject $config) {
                return new BlockonomicsPaymentScreen($config['payum.template.blockonomics_payment_screen']);
            },
            // 'payum.action.purchase' => function (ArrayObject $config) {
            //     return new ObtainCardholderAuthenticationAction($config['payum.template.obtain_cardholder_authentication']);
            // },
            // 'payum.action.obtain_cardholder_authentication' => function (ArrayObject $config) {
            //     return new ObtainCardholderAuthenticationAction($config['payum.template.obtain_cardholder_authentication']);
            // },
            // 'payum.action.status' => function (ArrayObject $config) {
            //     return new ObtainCardholderAuthenticationAction($config['payum.template.obtain_cardholder_authentication']);
            // },
            'cardholderAuthenticationRequired' => true,
        ]);

        $config['payum.paths'] = [
            'PayumBlockonomics' => __DIR__ . '/Resources/views',
        ];
    }
}