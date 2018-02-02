<?php

namespace Bondacom\Antenna\Drivers;

use Bondacom\Antenna\Exceptions\AntennaBadRequestException;
use Bondacom\Antenna\Exceptions\AntennaNotFoundException;
use Bondacom\Antenna\Exceptions\AntennaServerException;
use Bondacom\Antenna\Exceptions\AuthorizationKeyIsEmptyException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;

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
     * @param array $data
     * @return $this
     */
    public function delete(string $endpoint, $data)
    {
        $this->options = [];
        $this->options['Content-Type'] = 'application/json';
        $this->options['json'] = $data;

        return $this->makeRequest($endpoint,'delete');
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
     * @return \GuzzleHttp\Psr7\Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function responseContent()
    {
        return json_decode($this->response->getBody()->getContents(), true);
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @return $this
     * @throws AntennaBadRequestException
     * @throws AntennaNotFoundException
     * @throws AntennaServerException
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

        if ($this->response->getStatusCode() == Response::HTTP_OK) {
            return $this;
        }

        $errors = $this->responseContent()['errors'] ?? [];
        $message = json_encode($errors);
        if($this->response->getStatusCode() == Response::HTTP_NOT_FOUND) {
            throw new AntennaNotFoundException($message);
        }
        if($this->response->getStatusCode() == Response::HTTP_BAD_REQUEST) {
            throw new AntennaBadRequestException($message);
        }

        throw new AntennaServerException($message, $this->response->getStatusCode());
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