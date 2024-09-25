<?php

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Exception\RequestNotSupportedException;

class BlockonomicsStatusAction implements ActionInterface
{
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        if ($request->getModel()['status'] === 'paid') {
            $request->markCaptured();
        } else {
            $request->markNew();
        }
    }

    public function supports($request)
    {
        return $request instanceof GetStatusInterface;
    }
}
