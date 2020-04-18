<?php

namespace DanialPanah\PerfectMoneyGateway\Gateway;


class Payment
{
    /**
     * @var string
     */
    private static $apiUrl = 'https://perfectmoney.com/api/step1.asp';

    /**
     * @var string
     */
    private static $formEncryption = 'multipart/form-data';

    /**
     * @var string
     */
    private $formMethod = 'POST';


}