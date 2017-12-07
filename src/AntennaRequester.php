<?php

namespace Bondacom\antenna;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AntennaRequester
{
    /**
     * One Signal Base URL
     * @var string
     */
    const BASE_URL = 'https://onesignal.com/api/';

    /**
     * One Signal Api version
     *
     * @var string
     */
    const API_VERSION = 'v1';

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var array
     */
    private $headers;

    /**
     * AntennaRequester constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     *
     * @return $this
     */
    public function setUserKey($key)
    {
        $this->headers['headers']['Authorization'] = 'Basic ' . $key;

        return $this;
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
    private function processResponse($request)
    {
        $this->headers = [];
        return json_decode($request->getBody()->getContents());
    }
}