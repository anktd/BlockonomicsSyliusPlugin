<?php

namespace Blockonomics\SyliusPlugin;

use Blockonomics\SyliusPlugin\DependencyInjection\BlockonomicsSyliusPluginExtension;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class BlockonomicsSyliusPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new BlockonomicsSyliusPluginExtension();
        }
        return $this->extension;
    }
}