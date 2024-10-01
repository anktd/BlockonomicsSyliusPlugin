<?php

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Payum\Core\Exception\RequestNotSupportedException;
use Doctrine\ORM\EntityManagerInterface;
use Blockonomics\SyliusBlockonomicsPlugin\Action\Api\BaseApiAwareAction;

class BlockonomicsStatusAction extends BaseApiAwareAction implements ActionInterface
{

    use ContainerAwareTrait;

    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());
        $status = $details['status'];

        if ($status === 'pending') {
            $request->markPending();
        } else {
            $request->markNew();
        }
    }

    public function supports($request)
    {
        return $request instanceof GetStatusInterface;
    }
}
