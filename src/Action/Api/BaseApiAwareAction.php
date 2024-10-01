<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Action\Api;

use Blockonomics\SyliusBlockonomicsPlugin\ApiClient\BlockonomicsApiClientInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\ApiAwareTrait;

abstract class BaseApiAwareAction implements ActionInterface, ApiAwareInterface
{
    use ApiAwareTrait;

    public function __construct()
    {
        $this->apiClass = BlockonomicsApiClientInterface::class;
    }
}