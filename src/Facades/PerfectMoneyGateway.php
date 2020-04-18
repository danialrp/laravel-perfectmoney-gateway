<?php

namespace DanialPanah\PerfectMoneyGateway\Facades;

use DanialPanah\PerfectMoneyGateway\Gateway\Payment;
use Illuminate\Support\Facades\Facade;

/**
 * Class PerfectMoneyGateway
 *
 * @method static Payment initiatePaymentForm(array $paymentParams)
 */
class PerfectMoneyGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pmgateway';
    }
}