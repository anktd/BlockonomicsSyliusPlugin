<?php

declare(strict_types=1);

namespace Blockonomics\SyliusPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class BlockonomicsSyliusPluginExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        file_put_contents('/tmp/blockonomics_debug.log', 'Extension load method called ______########________ ' . PHP_EOL, FILE_APPEND);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('blockonomics_sylius_plugin.api_key', $config['api_key']);
    }

    public function getAlias(): string
    {
        file_put_contents('/tmp/blockonomics_debug.log', 'getAlias method called _____$$$$$$_____' . PHP_EOL, FILE_APPEND);
        return 'blockonomics_sylius_plugin';
    }
}