<?php

namespace Lullabot\Parsely;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

class Client implements ClientInterface
{
    /**
     * The root URL for all API requests.
     *
     * @see https://www.parse.ly/help/api/endpoint/
     */
    const ROOT_URL = 'https://api.parsely.com/v2/';

    /**
     * The underlying HTTP client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    private $apikey;

    /**
     * @var string
     */
    private $secret;

    /**
     * Client constructor.
     *
     * @param \GuzzleHttp\ClientInterface $client The underlying HTTP client to use for requests.
     * @param string $apikey
     * @param string $secret
     */
    public function __construct(ClientInterface $client, string $apikey, string $secret)
    {
        $this->client = $client;
        $this->apikey = $apikey;
        $this->secret = $secret;
    }

    /**
     * Get the default Guzzle client configuration array.
     *
     * @param mixed  $handler (optional) A Guzzle handler to use for requests.
     *
     * @return array An array of configuration options suitable for use with Guzzle.
     */
    public static function getDefaultConfiguration($handler = null)
    {
        $config = [
            'base_uri' => self::ROOT_URL,
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
        return $this->client->request($method, $url, $this->mergeAuth($options));
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return $this->client->send($request, $this->mergeAuth($options));
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
        return $this->client->sendAsync($request, $this->mergeAuth($options));
    }

    /**
     * {@inheritdoc}
     */
    public function requestAsync($method, $uri, array $options = [])
    {
        return $this->client->requestAsync($method, $uri, $this->mergeAuth($options));
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($option = null)
    {
        return $this->client->getConfig($option);
    }

    /**
     * Merge authentication headers into request options.
     *
     * @param array $options The array of request options.
     *
     * @return array The updated request options.
     */
    private function mergeAuth(array $options): array
    {
        if (!isset($options['query'])) {
            $options['query'] = [];
        }
        $options['query'] += [
            'apikey' => $this->apikey,
            'secret' => $this->secret,
        ];

        return $options;
    }
}
