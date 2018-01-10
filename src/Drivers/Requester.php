<?php

namespace Bondacom\Antenna\Drivers;

use Bondacom\Antenna\Exceptions\MissingUserKeyRequired;
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
    protected $client;

    /**
     * @var array (json data, query params, headers, etc)
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $key;

    /**
     * AntennaRequester constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $key
     * @return $this
     * @throws MissingUserKeyRequired
     */
    public function setKey($key)
    {
        if (empty($key)) {
            throw new MissingUserKeyRequired();
        }

        $this->key = $key;

        return $this;
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return array
     */
    public function post(string $endpoint, $data)
    {
        $this->options['headers']['Content-Type'] = 'application/json';
        $this->options['json'] = $data;

        return $this->makeRequest($endpoint,'post');
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return array
     */
    public function put(string $endpoint, $data)
    {
        $this->options['Content-Type'] = 'application/json';
        $this->options['json'] = $data;

        return $this->makeRequest($endpoint,'put');
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @return array
     */
    public function get(string $endpoint, array $parameters = [])
    {
        $this->options['query'] = $parameters;
        return $this->makeRequest($endpoint,'get');
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @return array
     */
    private function makeRequest(string $endpoint, string $method)
    {
        $this->setAuthorizationHeader();
        $uri = $this->url() . '/' . $endpoint;

        try {
            $request = $this->client->request(strtoupper($method), $uri, $this->options);
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
        $this->options = [];
        return json_decode($request->getBody()->getContents(), true);
    }

    private function setAuthorizationHeader()
    {
        $this->options['headers']['Authorization'] = 'Basic ' . $this->key;
    }
}