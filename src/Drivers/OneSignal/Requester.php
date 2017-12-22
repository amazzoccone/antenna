<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Exceptions\MissingUserKeyRequired;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Requester
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
     * @param string $key
     * @return $this
     * @throws MissingUserKeyRequired
     */
    public function setUserKey($key)
    {
        if (empty($key)) {
            throw new MissingUserKeyRequired();
        }

        $this->headers['headers']['Authorization'] = 'Basic ' . $key;

        return $this;
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return array
     */
    public function post(string $endpoint, $data)
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['json'] = $data;

        return $this->makeRequest($endpoint,'post');
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return array
     */
    public function put(string $endpoint, $data)
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['json'] = $data;

        return $this->makeRequest($endpoint,'put');
    }

    /**
     * @param string $endpoint
     * @return array
     */
    public function get(string $endpoint)
    {
        return $this->makeRequest($endpoint,'get');
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @return array
     */
    private function makeRequest(string $endpoint, string $method)
    {
        try {
            $uri = self::BASE_URL . "/" . self::API_VERSION . '/' . $endpoint;
            $request = $this->guzzleClient->{$method}($uri, $this->headers);
            return $this->processResponse($request);
        } catch (RequestException $e) {
            return $this->processResponse($e->getResponse());
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function processResponse($request)
    {
        $this->headers = [];
        return json_decode($request->getBody()->getContents(), true);
    }
}