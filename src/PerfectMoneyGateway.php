<?php

namespace DanialPanah\PerfectMoneyGateway;

use DanialPanah\PerfectMoneyGateway\Gateway\Payment;

class PerfectMoneyGateway
{
    /**
     * @param array $paymentParams
     * @return Payment
     * @throws Exceptions\PerfectMoneyException
     */
    public function initiatePaymentForm(array $paymentParams): Payment
    {
        return Payment::createPaymentForm($paymentParams);
    }
}