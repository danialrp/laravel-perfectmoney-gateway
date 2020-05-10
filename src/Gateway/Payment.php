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
     * Payment constructor.
     * @param array $paymentDetails
     * @throws PerfectMoneyException
     */
    public function __construct(array $paymentDetails)
    {
        $this->setPaymentFields($paymentDetails);
    }

    /**
     * @param $name
     * @return mixed
     * @throws PerfectMoneyException
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->paymentFields)) {
            throw new PerfectMoneyException('PerfectMoney ' . $name . ' is not defined.');
        }
        return $this->paymentFields[$name];
    }

    /**
     * @param array $paymentFields
     * @return Payment
     * @throws PerfectMoneyException
     */
    private function setPaymentFields(array $paymentFields): Payment
    {
        $this->paymentFields = Initiate::payload($paymentFields)
            ->validateParams()
            ->createPaymentQuery();

        return $this;
    }

    /**
     * @param array $paymentDetails
     * @return Payment
     * @throws PerfectMoneyException
     */
    public static function createPaymentForm(array $paymentDetails): Payment
    {
        return new static($paymentDetails);
    }
}