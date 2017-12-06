<?php

namespace Bondacom\antenna;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AntennaRequester
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * AntennaRequester constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Make a POST request.
     *
     * @param $endpoint
     * @param $data
     *
     * @return object
     */
    public function post($endpoint, $data)
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['json'] = $data;

        return $this->makeRequest($endpoint,'post');
    }

    /**
     * Make a PUT request.
     *
     * @param $endpoint
     * @param $data
     *
     * @return object
     */
    public function put($endpoint, $data)
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['json'] = $data;

        return $this->makeRequest($endpoint,'put');
    }

    /**
     * Make a get request
     *
     * @param $endpoint
     *
     * @return object
     */
    public function get($endpoint)
    {
        return $this->makeRequest($endpoint,'get');
    }

    /**
     * Make a HTTP request and parse response
     *
     * @param $endpoint
     * @param $method
     *
     * @return object
     */
    private function makeRequest($endpoint,$method)
    {
        try {
            $request = $this->guzzleClient->{$method}(self::BASE_URL . "/" . self::API_VERSION . '/' . $endpoint,
                $this->headers);
            return $this->processResponse($request);
        } catch (RequestException $e) {
            return $this->processResponse($e->getResponse());
        }
    }

    /**
     * Process response
     *
     * @param $request
     *
     * @return object
     */
    public function processResponse($request)
    {
        $response = json_decode($request->getBody()->getContents());
        $this->headers = [];
        return $response;
    }
}