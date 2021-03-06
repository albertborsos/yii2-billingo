<?php

namespace albertborsos\billingo\api;

use Billingo\API\Connector\Exceptions\JSONParseException;
use Billingo\API\Connector\Exceptions\RequestErrorException;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingoClient implements \Billingo\API\Connector\Contracts\Request
{
    /**
     * @var Client
     */
    protected $client;

    protected $config;

    /**
     * Request constructor.
     * @param $options
     */
    public function __construct($options)
    {

        $this->config = $this->resolveOptions($options);
        $this->client = new Client([
            'verify' => false,
            'base_uri' => $this->config['host'],
            'debug' => false,
        ]);
    }

    /**
     * Get required options for the Billingo API to work
     * @param $opts
     * @return mixed
     */
    protected function resolveOptions($opts)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefault('version', '2');
        $resolver->setDefault('host', 'https://www.billingo.hu/api/'); // might be overridden in the future
        $resolver->setDefault('leeway', 60);
        $resolver->setRequired(['host', 'private_key', 'public_key', 'version', 'leeway']);

        return $resolver->resolve($opts);
    }

    /**
     * Generate JWT authorization header
     * @return string
     */
    public function generateAuthHeader()
    {
        $time = time();
        $iss = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'cli';
        $signatureData = [
            'sub' => $this->config['public_key'],
            'iat' => $time - $this->config['leeway'],
            'exp' => $time + $this->config['leeway'],
            'iss' => $iss,
            'nbf' => $time - $this->config['leeway'],
            'jti' => md5($this->config['public_key'] . $time),
        ];

        return JWT::encode($signatureData, $this->config['private_key']);
    }

    /**
     * Make a request to the Billingo API
     * @param $method
     * @param $uri
     * @param array $data
     * @return mixed|array
     * @throws JSONParseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, $data = [])
    {
        // get the key to use for the query
        if ($method == strtoupper('GET') || $method == strtoupper('DELETE')) {
            $queryKey = 'query';
        } else {
            $queryKey = 'json';
        }

        // make signature

        try {
            $response = $this->client->request($method, $uri, [
                $queryKey => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generateAuthHeader(),
                ],
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $jsonData = json_decode($response->getBody(), true);

        if ($jsonData == null) {
            throw new JSONParseException('Cannot decode: ' . $response->getBody());
        }

        return $jsonData;
    }

    /**
     * GET
     * @param $uri
     * @param array $data
     * @return array|mixed|ResponseInterface
     * @throws JSONParseException
     * @throws RequestErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($uri, $data = [])
    {
        return $this->request('GET', $uri, $data);
    }

    /**
     * POST
     * @param $uri
     * @param array $data
     * @return array|mixed|ResponseInterface
     * @throws JSONParseException
     * @throws RequestErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($uri, $data = [])
    {
        return $this->request('POST', $uri, $data);
    }

    /**
     * PUT
     * @param $uri
     * @param array $data
     * @return array|mixed|ResponseInterface
     * @throws JSONParseException
     * @throws RequestErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($uri, $data = [])
    {
        return $this->request('PUT', $uri, $data);
    }

    /**
     * DELETE
     * @param $uri
     * @param array $data
     * @return array|mixed|ResponseInterface
     * @throws JSONParseException
     * @throws RequestErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($uri, $data = [])
    {
        return $this->request('DELETE', $uri, $data);
    }

    /**
     * Downloads the given invoice
     * @param $id
     * @param null|resource|string $file
     * @return \Psr\Http\Message\StreamInterface|string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadInvoice($id, $file = null)
    {
        $uri = "invoices/{$id}/download";
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->generateAuthHeader(),
            ],
        ];
        if ($file !== null) {
            $options['sink'] = $file;
        }
        $response = $this->client->request('GET', $uri, $options);

        return $response instanceof ResponseInterface ? $response->getBody() : null;
    }
}
