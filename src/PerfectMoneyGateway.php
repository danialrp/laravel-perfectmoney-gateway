<?php

namespace DanialPanah\PerfectMoneyGateway;

use DanialPanah\PerfectMoneyGateway\Gateway\Payment;

class PerfectMoneyGateway
{
    /**
     * @var array
     */
    protected $paymentDetails;


    public function __set($name, $value)
    {
        $this->paymentDetails[$name] = $value;
    }


    /**
     * @param null $paymentParams
     * @return Payment
     * @throws Exceptions\PerfectMoneyException
     */
    public function initiatePaymentForm($paymentParams = null): Payment
    {
        $paymentParams = (array)$paymentParams;

        if (count($paymentParams)) {
            $this->setPaymentDetails($paymentParams);
        }

        return $this->sendPaymentForm();
    }

    /**
     * @param array $paymentDetails
     */
    private function setPaymentDetails(array $paymentDetails): void
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * @return Payment
     * @throws Exceptions\PerfectMoneyException
     */
    private function sendPaymentForm(): Payment
    {
        return Payment::createPaymentForm($this->paymentDetails);
    }
}