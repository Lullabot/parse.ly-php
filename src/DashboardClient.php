<?php

namespace Lullabot\Parsely;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

class DashboardClient implements ClientInterface {

  /**
   * The root URL for dashboard requests.
   *
   * @see https://www.parse.ly/help/integration/trigger-crawl/
   * @see https://www.parse.ly/help/integration/crawler/#how-do-i-find-pages-that-have-not-been-crawled-correctly
   */
  const ROOT_URL = 'https://dash.parsely.com/';

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
   * @param string                      $apikey
   * @param string                      $secret
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
   * @param mixed $handler (optional) A Guzzle handler to use for requests.
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
  public function request($method = 'GET', $uri = null, array $options = [])
  {
    return $this->client->request($method, $this->mergeUriAuth($uri), $this->mergeQueryAuth($options));
  }

  /**
   * {@inheritdoc}
   */
  public function send(RequestInterface $request, array $options = [])
  {
    $request->withUri($this->mergeUriAuth($request->getUri()));
    return $this->client->send($request, $this->mergeQueryAuth($options));
  }

  /**
   * {@inheritdoc}
   */
  public function sendAsync(RequestInterface $request, array $options = [])
  {
    $request->withUri($this->mergeUriAuth($request->getUri()));
    return $this->client->sendAsync($request, $this->mergeQueryAuth($options));
  }

  /**
   * {@inheritdoc}
   */
  public function requestAsync($method, $uri, array $options = [])
  {
    return $this->client->requestAsync($method, $this->mergeUriAuth($uri), $this->mergeQueryAuth($options));
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
  private function mergeQueryAuth(array $options): array
  {
    if (!isset($options['query'])) {
      $options['query'] = [];
    }
    $options['query'] += [
      'secret' => $this->secret,
    ];

    return $options;
  }

  /**
   * Merge authentication path parts into the URL.
   *
   * @param string $uri The base URL of the request.
   *
   * @return string The updated URL.
   */
  private function mergeUriAuth(string $uri): string {
    return $this->apikey . '/' . $uri;
  }

}
