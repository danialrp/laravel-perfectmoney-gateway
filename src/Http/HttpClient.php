<?php

namespace DanialPanah\PerfectMoneyGateway\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    /**
     * @param $method
     * @param $url
     * @param array $query
     * @return ResponseInterface
     */
    private static function createHttpRequest($method, $url, array $query = []): ResponseInterface
    {
        try {
            return (new Client())->request($method, $url, $query);
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * @param $method
     * @param $url
     * @param array $query
     * @return iterable
     */
    public static function sendHttpRequest($method, $url, array $query = []): iterable
    {
        return json_decode(static::createHttpRequest($url, $method, $query)->getBody());
    }
}