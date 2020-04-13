<?php

namespace DanialPanah\PerfectMoneyGateway\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    /**
     * @param $url
     * @param $method
     * @param array $query
     * @return ResponseInterface
     */
    private static function createHttpRequest($url, $method, array $query = []): ResponseInterface
    {
        try {
            return (new Client())->request($method, $url, $query);
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * @param $url
     * @param $method
     * @param array $query
     * @return iterable
     */
    public static function sendHttpRequest($url, $method, array $query = []): iterable
    {
        return json_decode(static::createHttpRequest($url, $method, $query)->getBody());
    }
}