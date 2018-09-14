<?php

namespace Lullabot\Parsely\Analytics;

use GuzzleHttp\Promise\PromiseInterface;
use Lullabot\Parsely\Client;
use Lullabot\Parsely\PostList;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Posts
{
    const PATH = 'analytics/posts';

    /**
     * @var \Lullabot\Parsely\Client
     */
    private $client;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $section;

    /**
     * Posts constructor.
     *
     * @param \Lullabot\Parsely\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return int
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return Posts
     */
    public function setPage(int $page = null): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return Posts
     */
    public function setLimit(int $limit = null): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string
     */
    public function getSection(): ?string
    {
        return $this->section;
    }

    /**
     * @param string $section
     *
     * @return Posts
     */
    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function execute(): PromiseInterface
    {
        $options = $this->toQueryParts();

        return $this->client->requestAsync('GET', self::PATH, $options)
            ->then(function (ResponseInterface $response) {
                $serializer = new Serializer([
                    new DateTimeNormalizer(),
                    new ArrayDenormalizer(),
                    new ObjectNormalizer(NULL, new CamelCaseToSnakeCaseNameConverter(), NULL, new PhpDocExtractor()),
                ], [new JsonEncoder()]);

                return $serializer->deserialize($response->getBody(), PostList::class, 'json');
            });
    }

    public function toQueryParts(): array
    {
        return array_filter([
            'page' => $this->getPage(),
            'limit' => $this->getLimit(),
            'section' => $this->getSection(),
        ]);
    }
}
