<?php

namespace Lullabot\Parsely\Analytics;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Lullabot\Parsely\Encoder\JsonEncoder;
use Lullabot\Parsely\PostList;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Posts
{
    public const PATH = 'analytics/posts';

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
     * @var array
     */
    private $sections;

    /**
     * @var string
     */
    private $tag;

    private ?LoggerInterface $logger;

    /**
     * Posts constructor.
     */
    public function __construct(ClientInterface $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger;
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
     */
    public function setLimit(int $limit = null): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function getSections(): ?array
    {
        return $this->sections;
    }

    public function setSections(array $sections): self
    {
        $this->sections = $sections;

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
        $onFulfilled = function (ResponseInterface $response) {
            $serializer = new Serializer([
                new DateTimeNormalizer(),
                new ArrayDenormalizer(),
                new ObjectNormalizer(
                    null,
                    new CamelCaseToSnakeCaseNameConverter(),
                    null,
                    new PhpDocExtractor()
                ),
            ], [new JsonEncoder()]);

            return $serializer->deserialize($response->getBody(), PostList::class, 'json');
        };
        $onRejected = function () {
            // @todo Restore the real exception message here.
            // If there is an exception log it and continue with an empty
            // post list.
            if ($this->logger) {
                $this->logger->error('An error happened when retrieving posts.');
            }

            return new PostList();
        };

        return $this->client
            ->requestAsync('GET', self::PATH, $options)
            ->then($onFulfilled, $onRejected);
    }

    public function toQueryParts(): array
    {
        return array_filter([
            'page' => $this->getPage(),
            'period_start' => $this->getPeriodStart(),
            'limit' => $this->getLimit(),
            'section' => $this->getSections(),
            'tag' => $this->getTag(),
        ]);
    }
}
