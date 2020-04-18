<?php

namespace DanialPanah\PerfectMoneyGateway\Gateway;

use DanialPanah\PerfectMoneyGateway\Exceptions\PerfectMoneyException;

class Payment
{
    /**
     * @var string
     */
    public $apiUrl = 'https://perfectmoney.com/api/step1.asp';

    /**
     * @var string
     */
    public $formEncryption = 'multipart/form-data';

    /**
     * @var string
     */
    public $formMethod = 'POST';

    /**
     * @var array
     */
    private $paymentFields;

    /**
     * @param array $paymentFields
     * @return Payment
     * @throws PerfectMoneyException
     */
    public function setPaymentFields(array $paymentFields): Payment
    {
        $this->paymentFields = Initiate::payload($paymentFields)
            ->validateParams()
            ->createPaymentQuery();

        return $this;
    }

    public static function createPaymentForm(): Payment
    {
        return new static();
    }
}