<?php

declare(strict_types=1);

namespace Blockonomics\SyliusPlugin\Payum;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class BlockonomicsGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'blockonomics',
            'payum.factory_title' => 'Blockonomics',
        ]);
    }
}