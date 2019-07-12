<?php namespace NorbyBaru\ExchangeRate\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class RequestService
 * @package NorbyBaru\ExchangeRate\Services
 */
abstract class RequestService
{
    /** @var \GuzzleHttp\Client  */
    private $client;

    public function __construct($baseUrl)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $params
     *
     * @return mixed
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $uri, $params = [])
    {
        try {

            if ($method == 'get') {
                $params = ['query' => $params];
            }

            $responseJson = $this->client->request($method, $uri, $params);
            $responseObject = json_decode($responseJson->getBody());

            return $responseObject;
        } catch (BadResponseException $e) {
            $responseJson = $e->getResponse();
            $responseObject = json_decode($responseJson->getBody()->getContents());

            throw new Exception($responseObject->getMessage, $e->getCode());
        }
    }
}
