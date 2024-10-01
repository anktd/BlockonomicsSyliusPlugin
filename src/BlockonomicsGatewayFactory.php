<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin;

use Blockonomics\SyliusBlockonomicsPlugin\Action\BlockonomicsCaptureAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\BlockonomicsStatusAction;
use Blockonomics\SyliusBlockonomicsPlugin\Action\BlockonomicsConvertAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

final class BlockonomicsGatewayFactory extends GatewayFactory
{
    public const FACTORY_NAME = 'blockonomics';

    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => self::FACTORY_NAME,
            'payum.factory_title' => 'Blockonomics',
            'payum.http_client' => '@blockonomics_sylius_blockonomics_plugin.api_client.blockonomics',
            'payum.template.blockonomics_payment_screen' => '@BlockonomicsSyliusBlockonomicsPlugin/Action/blockonomics_payment_screen.html.twig',
            'payum.action.capture' => function (ArrayObject $config) {
                return new BlockonomicsCaptureAction($config['payum.template.blockonomics_payment_screen'], $config);
            },
            'payum.action.status' => function (ArrayObject $config) {
                return new BlockonomicsStatusAction();
            },
            'payum.action.convert' => function (ArrayObject $config) {
                return new BlockonomicsConvertAction();
            },
        ]);

        // TODO: Implement the following
        if (false == $config['payum.api']) {
            $config['payum.default_options'] = [
                'apiKey' => '',
            ];
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['apiKey'];

            $config['payum.api'] = function (ArrayObject $config) {
                $apiClient = $config['payum.http_client'];

                $apiClient->initialise((array) $config);

                return $apiClient;
            };
        }

        $config['payum.paths'] = array_replace([
            'PayumBlockonomics' => __DIR__ . '/Resources/views',
        ], $config['payum.paths'] ?: []);
    }
}