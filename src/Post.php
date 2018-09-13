<?php

namespace Lullabot\Parsely;

class Post
{
    /**
     * @var int
     */
    protected $hits;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string[]
     */
    protected $authors;

    /**
     * @var int
     */
    protected $fullContentWordCount;

    /**
     * @var string
     */
    protected $imageUrl;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $metadata;

    /**
     * @var array
     */
    protected $metrics;

    /**
     * @var string
     */
    protected $pubDate;

    /**
     * @var string
     */
    protected $section;

    /**
     * @var string[]
     */
    protected $tags;

    /**
     * @var string
     */
    protected $thumbUrlMedium;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return int
     */
    public function getHits(): int
    {
        return $this->hits;
    }

    /**
     * @param int $hits
     *
     * @return Post
     */
    public function setHits(int $hits): self
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     *
     * @return Post
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param string[] $authors
     *
     * @return Post
     */
    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * @return int
     */
    public function getFullContentWordCount(): int
    {
        return $this->fullContentWordCount;
    }

    /**
     * @param int $fullContentWordCount
     *
     * @return Post
     */
    public function setFullContentWordCount(int $fullContentWordCount): self
    {
        $this->fullContentWordCount = $fullContentWordCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     *
     * @return Post
     */
    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return Post
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     *
     * @return Post
     */
    public function setMetadata(string $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }

    /**
     * @param array $metrics
     *
     * @return Post
     */
    public function setMetrics(array $metrics): self
    {
        $this->metrics = $metrics;

        return $this;
    }

    /**
     * @return string
     */
    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    /**
     * @param string $pubDate
     *
     * @return Post
     */
    public function setPubDate(string $pubDate): self
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getSection(): string
    {
        return $this->section;
    }

    /**
     * @param string $section
     *
     * @return Post
     */
    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string[] $tags
     *
     * @return Post
     */
    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbUrlMedium(): string
    {
        return $this->thumbUrlMedium;
    }

    /**
     * @param string $thumbUrlMedium
     *
     * @return Post
     */
    public function setThumbUrlMedium(string $thumbUrlMedium): self
    {
        $this->thumbUrlMedium = $thumbUrlMedium;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Post
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
