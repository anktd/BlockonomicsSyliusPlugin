<?php

declare(strict_types=1);

namespace Blockonomics\SyliusBlockonomicsPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\Convert;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\PaymentInterface;

class BlockonomicsConvertAction implements ActionInterface
{
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();

        $details = array();
        $details['amount'] = $payment->getTotalAmount();
        $details['currency'] = $payment->getCurrencyCode();
        $details['description'] = $payment->getDescription();
        $details['invoiceNumber'] = $payment->getNumber();

        $request->setResult($details);
    }

    public function supports($request)
    {
        return $request instanceof Convert &&
               $request->getSource() instanceof PaymentInterface;
    }
}