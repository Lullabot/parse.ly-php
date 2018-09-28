<?php

namespace Lullabot\Parsely\Analytics;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Lullabot\Parsely\Encoder\JsonEncoder;
use Lullabot\Parsely\PostList;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
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
     * @var string
     */
    private $periodStart;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $tag;

    /**
     * Posts constructor.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
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

    /**
     * @return string
     */
    public function getPeriodStart(): ?string
    {
        return $this->periodStart;
    }

    /**
     * @param string $periodStart
     *
     * @return Posts
     */
    public function setPeriodStart(string $periodStart = null): self
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     *
     * @return Posts
     */
    public function setTag(string $tag = null): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function execute(): PromiseInterface
    {
        $options = [
            'query' => $this->toQueryParts(),
        ];

        return $this->client->requestAsync('GET', self::PATH, $options)
            ->then(function (ResponseInterface $response) {
                $serializer = new Serializer([
                    new DateTimeNormalizer(),
                    new ArrayDenormalizer(),
                    new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter(), null, new PhpDocExtractor()),
                ], [new JsonEncoder()]);

                return $serializer->deserialize($response->getBody(), PostList::class, 'json');
            });
    }

    public function toQueryParts(): array
    {
        return array_filter([
            'page' => $this->getPage(),
            'period_start' => $this->getPeriodStart(),
            'limit' => $this->getLimit(),
            'section' => $this->getSection(),
            'tag' => $this->getTag(),
        ]);
    }
}
