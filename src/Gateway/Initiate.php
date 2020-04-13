<?php

namespace DanialPanah\PerfectMoneyGateway\Gateway;


final class Initiate
{
    /**
     * @var string
     */
    private static $account;

    /**
     * @var string
     */
    private static $password;

    /**
     * @var string
     */
    private static $alternatePassphrase;

    /**
     * @var string
     */
    private static $wallet;

    /**
     * @var string
     */
    private static $payeeName;

    /**
     * @var int
     */
    private $paymentId;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $suggestedMemo;

    /**
     * @var string
     */
    private $additionalInfo;

    /**
     * @var string
     */
    private $baggageFields;


    public function __construct()
    {
        $this->setDefaultParams();
    }

    private function setDefaultParams(): Initiate
    {

    }

    private function setPaymentParams(array $params): Initiate
    {
        
    }
}