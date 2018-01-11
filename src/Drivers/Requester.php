<?php

namespace Bondacom\Antenna\Drivers;

use Bondacom\Antenna\Exceptions\AuthorizationKeyIsEmptyException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class Requester
{
    /**
     * @return string Ex.: https://test.com
     */
    abstract protected function url() : string;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var array (json data, query params, headers, etc)
     */
    protected $options = [];

    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

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
     * @throws AuthorizationKeyIsEmptyException
     */
    public function setAuthorizationKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return $this
     */
    public function post(string $endpoint, $data)
    {
        $this->options = [];
        $this->options['headers']['Content-Type'] = 'application/json';
        $this->options['json'] = $data;

        return $this->makeRequest($endpoint,'post');
    }

    /**
     * @param string $endpoint
     * @param $data
     * @return $this
     */
    public function put(string $endpoint, $data)
    {
        $this->options = [];
        $this->options['Content-Type'] = 'application/json';
        $this->options['json'] = $data;

        return $this->makeRequest($endpoint,'put');
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @return $this
     */
    public function get(string $endpoint, array $parameters = [])
    {
        $this->options = [];
        $this->options['query'] = $parameters;
        return $this->makeRequest($endpoint,'get');
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @return $this
     */
    private function makeRequest(string $endpoint, string $method)
    {
        $this->setAuthorizationHeader();
        $uri = $this->url() . '/' . $endpoint;

        try {
            $this->response = $this->client->request(strtoupper($method), $uri, $this->options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
        }

        return $this;
    }

    /**
     * @throws AuthorizationKeyIsEmptyException
     * @return $this
     */
    private function setAuthorizationHeader()
    {
        if (empty($this->key)) {
            throw new AuthorizationKeyIsEmptyException();
        }

        $this->options['headers']['Authorization'] = 'Basic ' . $this->key;

        return $this;
    }
}