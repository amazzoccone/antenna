<?php

namespace Bondacom\Antenna\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class Requester
{
    /**
     * @return string Ex.: https://test.com
     */
    abstract protected function url() : string;

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * AntennaRequester constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
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
            $uri = $this->url() . '/' . $endpoint;
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