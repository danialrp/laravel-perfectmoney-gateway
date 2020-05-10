<?php

namespace DanialPanah\PerfectMoneyGateway\Verify;


use DanialPanah\PerfectMoneyGateway\Exceptions\PerfectMoneyVerifyException;

class Verify
{
    /*
     * @var array
     */
    private $transaction;

    public function __construct($transaction = [])
    {
        $this->transaction = $transaction;
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->transaction)) {
            return;
        }
        $this->transaction[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     * @throws PerfectMoneyVerifyException
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->transaction)) {
            throw new PerfectMoneyVerifyException('PerfectMoney ' . $name . ' is not defined.');
        }
        return $this->transaction[$name];
    }

    /**
     * @throws PerfectMoneyVerifyException
     */
    private function validateTransactionItems(): Verify
    {
        foreach ($this->transactionItems() as $item) {
            if (!array_key_exists($item, $this->transaction)) {
                throw new PerfectMoneyVerifyException('PerfectMoney ' . $item . 'is not set for verify transaction.');
            }
        }

        return $this;
    }

    private function transactionItems(): array
    {
        return ['transaction_id', 'transaction_amount', 'transaction_batch_number', 'payer_account', 'timestamp'];
    }

    public static function verifyTransaction(array $transaction = []): Verify
    {
        return new static($transaction);
    }
}