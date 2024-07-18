<?php

declare(strict_types=1);

namespace Blockonomics\SyliusPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BlockonomicsSyliusPlugin extends Bundle
{
    use SyliusPluginTrait;
}