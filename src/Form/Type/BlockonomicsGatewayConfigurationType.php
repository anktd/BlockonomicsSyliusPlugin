<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\RequestStack;

final class BlockonomicsGatewayConfigurationType extends AbstractType
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $baseUrl = $request->getSchemeAndHttpHost();
        $randomBytes = random_bytes(20);
        $callbackSecret = sha1($randomBytes);

        $builder
            ->add('apiKey', TextType::class, [
                'label' => 'blockonomics_sylius_blockonomics_plugin.ui.api_key',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'blockonomics_sylius_blockonomics_plugin.api_key.not_blank',
                        'groups' => 'sylius',
                    ]),
                ],
            ])
            ->add('callbackUrl', HiddenType::class, [
                'required' => true,
                'data' => $callbackSecret,
                'constraints' => [
                    new NotBlank([
                        'message' => 'blockonomics_sylius_blockonomics_plugin.api_key.not_blank',
                        'groups' => 'sylius',
                    ]),
                ],
            ])
            ->add('callbackUrl', TextType::class, [
                'label' => 'blockonomics_sylius_blockonomics_plugin.ui.callback_url',
                'required' => true,
                'disabled' => true,
                'data' => $baseUrl . "/api/blockonomics/update-order-status?secret=" . $callbackSecret,
                'constraints' => [
                    new NotBlank([
                        'message' => 'blockonomics_sylius_blockonomics_plugin.callback_url.not_blank',
                        'groups' => 'sylius',
                    ]),
                ],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();

                $data['payum.http_client'] = '@blockonomics_sylius_blockonomics_plugin.api_client.blockonomics';

                $event->setData($data);
            })
        ;
    }
}