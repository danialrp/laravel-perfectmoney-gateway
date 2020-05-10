<?php

namespace DanialPanah\PerfectMoneyGateway\Verify;


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

    private function setTransactionItems()
    {
    }

    private function transactionItems(): array
    {
        return ['id', 'amount', 'batch', 'account', 'time'];
    }

    public static function verifyTransaction(array $transaction = []): Verify
    {
        return new static($transaction);
    }
}