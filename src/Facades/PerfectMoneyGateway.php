<?php

namespace DanialPanah\PerfectMoneyGateway\Facades;

use Illuminate\Support\Facades\Facade;

class PerfectMoneyGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pmgateway';
    }
}