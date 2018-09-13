<?php

namespace Lullabot\Parsely;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

class Client implements ClientInterface
{
    /**
     * The underlying HTTP client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Client constructor.
     *
     * Custom client implementations should include the Middleware
     * handler, otherwise MPX errors may not be exposed correctly.
     *
     *
     * @param \GuzzleHttp\ClientInterface $client The underlying HTTP client to use for requests.
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get the default Guzzle client configuration array.
     *
     * @param mixed $handler (optional) A Guzzle handler to use for
     *                       requests. If a custom handler is specified, it must
     *                       include Middleware::mpxErrors or a replacement.
     *
     * @return array An array of configuration options suitable for use with Guzzle.
     */
    public static function getDefaultConfiguration($handler = null)
    {
        $config = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];

        if (!$handler) {
            $handler = HandlerStack::create();
        }
        $config['handler'] = $handler;

        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function request($method = 'GET', $url = null, array $options = [])
    {
        return $this->client->request($method, $url, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return $this->client->send($request, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
        return $this->client->sendAsync($request, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function requestAsync($method, $uri, array $options = [])
    {
        return $this->client->requestAsync($method, $uri, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($option = null)
    {
        return $this->client->getConfig($option);
    }
}
