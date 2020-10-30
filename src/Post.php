<?php

namespace Lullabot\Parsely;

/**
 * Represents a Post.
 *
 * @todo Is this data model shared for all posts? The API is not REST so it's
 * hard to tell until we need to load posts from another resource.
 *
 * @see https://www.parse.ly/help/api/analytics/
 */
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
     * @var \DateTime
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

    public function getHits(): int
    {
        return $this->hits;
    }

    /**
     * @return Post
     */
    public function setHits(int $hits): self
    {
        $this->hits = $hits;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
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

    public function getFullContentWordCount(): int
    {
        return $this->fullContentWordCount;
    }

    /**
     * @return Post
     */
    public function setFullContentWordCount(int $fullContentWordCount): self
    {
        $this->fullContentWordCount = $fullContentWordCount;

        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return Post
     */
    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return Post
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @return Post
     */
    public function setMetadata(string $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getMetrics(): array
    {
        return $this->metrics;
    }

    /**
     * @return Post
     */
    public function setMetrics(array $metrics): self
    {
        $this->metrics = $metrics;

        return $this;
    }

    public function getPubDate(): \DateTime
    {
        return $this->pubDate;
    }

    /**
     * @return Post
     */
    public function setPubDate(\DateTime $pubDate): self
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    /**
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
     * @return ?string
     */
    public function getThumbUrlMedium(): ?string
    {
        return $this->thumbUrlMedium;
    }

    /**
     * @param string $thumbUrlMedium
     *
     * @return Post
     */
    public function setThumbUrlMedium(string $thumbUrlMedium = null): self
    {
        $this->thumbUrlMedium = $thumbUrlMedium;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Post
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return Post
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
