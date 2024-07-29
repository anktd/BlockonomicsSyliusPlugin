<?php

declare(strict_types=1);

namespace Blockonomics\SyliusPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BlockonomicsGatewayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('api_key', TextType::class, [
            'label' => 'blockonomics_sylius_plugin.form.api_key',
            'required' => true,
        ]);
    }
}