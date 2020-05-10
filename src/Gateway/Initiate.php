<?php

namespace DanialPanah\PerfectMoneyGateway\Gateway;

use DanialPanah\PerfectMoneyGateway\Exceptions\PerfectMoneyException;

final class Initiate
{
    /**
     * @var string
     */
    private static $memberId;

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
     * @var string
     */
    private static $callbackUrl;

    /**
     * @var string
     */
    private static $callbackUrlMethod = 'GET';

    /**
     * @var string
     */
    private static $statusUrl;

    /**
     * @var int
     */
    private $paymentId;

    /**
     * @var mixed
     */
    private $amount;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $memo;

    /**
     * @var string
     */
    private $additionalInfo = '';

    /**
     * @var string
     */
    private $baggageFields = '';


    /**
     * Initiate constructor.
     * @param array $paymentParams
     * @throws PerfectMoneyException
     */
    public function __construct(array $paymentParams)
    {
        $this->setDefaultParams();
        $this->setPaymentParams($paymentParams);
    }

    private function setDefaultParams(): void
    {
        static::$memberId = config('pmgateway.pm_member_id') ?? null;
        static::$password = config('pmgateway.pm_password') ?? null;
        static::$alternatePassphrase = config('pmgateway.pm_alternate_passphrase') ?? null;
        static::$wallet = config('pmgateway.pm_wallet') ?? null;
        static::$callbackUrl = config('pmgateway.pm_callback_url') ?? null;
        static::$statusUrl = config('pmgateway.pm_email') ?? '';
        static::$payeeName = config('pmgateway.pm_payee_name') ?? '';
    }

    /**
     * @param array $params
     * @return Initiate
     * @throws PerfectMoneyException
     */
    private function setPaymentParams(array $params): Initiate
    {
        $this->paymentId = array_key_exists('payment_id', $params) ? $params['payment_id'] : null;
        $this->memo = array_key_exists('public_note', $params) ? $params['public_note'] : '';
        $this->additionalInfo = array_key_exists('private_note', $params) ? $params['private_note'] : '';

        array_key_exists('amount', $params) ? $this->setAmount($params['amount']) : null;

        array_key_exists('currency', $params) ? $this->setUnit($params['currency']) : null;

        if (!empty($this->additionalInfo)) {
            $this->setBaggageFields('additional_info_1');
        }

        return $this;
    }

    /**
     * @throws PerfectMoneyException
     */
    public function validateParams(): Initiate
    {
        $requiredParams = [
            'pm_member_id' => static::$memberId,
            'pm_password' => static::$password,
            'pm_alternate_passphrase' => static::$alternatePassphrase,
            'pm_wallet' => static::$wallet,
            'pm_callback_url' => static::$callbackUrl,
            'payment_id' => $this->paymentId,
            'amount' => $this->amount,
            'currency' => $this->unit
        ];

        foreach ($requiredParams as $key => $value) {
            if (!$value)
                throw new PerfectMoneyException('PerfectMoney ' . $key . ' is not set.');
        }

        return $this;
    }

    /**
     * @param string $unit
     * @throws PerfectMoneyException
     */
    private function setUnit(string $unit): void
    {
        if (!in_array($unit, ['USD', 'EUR', 'OAU'])) {
            throw new PerfectMoneyException('PerfectMoney ' . $unit . ' is not an accepted payment currency.');
        }

        $this->unit = (string)$unit;
    }

    /**
     * @param mixed $amount
     * @throws PerfectMoneyException
     */
    public function setAmount($amount): void
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new PerfectMoneyException('PerfectMoney invalid amount provided: ' . $amount);
        }

        $this->amount = bcdiv($amount, 1, 2);
    }

    /**
     * @param string $baggageFields
     */
    private function setBaggageFields(string $baggageFields): void
    {
        $this->baggageFields = strtoupper($baggageFields);
    }

    /**
     * @return array
     */
    public function createPaymentQuery(): array
    {
        $paymentQuery = [
            'payee_account' => static::$wallet,
            'payee_name' => static::$payeeName,
            'status_url' => null != static::$statusUrl ? 'mailto:' . static::$statusUrl : '',
            'payment_url' => url('/') . static::$callbackUrl,
            'payment_url_method' => static::$callbackUrlMethod,
            'no_payment_url' => url('/') . static::$callbackUrl,
            'no_payment_url_method' => static::$callbackUrlMethod,
            'payment_id' => $this->paymentId,
            'payment_amount' => $this->amount,
            'payment_unit' => $this->unit,
            'suggested_memo' => $this->memo,
            'additional_info_1' => $this->additionalInfo,
            'baggage_fields' => $this->baggageFields,
        ];

        return array_filter($paymentQuery);
    }

    /**
     * @param array $paymentParams
     * @return Initiate
     * @throws PerfectMoneyException
     */
    public static function payload(array $paymentParams): Initiate
    {
        return new static($paymentParams);
    }
}