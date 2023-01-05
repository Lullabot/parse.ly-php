<?php

namespace Lullabot\Parsely;

/**
 * Class PostList.
 *
 * @todo Do all lists of any object have the same format? If so, this could
 *   become just 'List'.
 */
class PostList implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var \Lullabot\Parsely\Post[]
     */
    private $data = [];

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param \Lullabot\Parsely\Post[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function count(): int
    {
        return \count($this->data);
    }

    /**
     * Merge lists of posts.
     *
     * A new post list is returned, with:
     *  - Duplicates removed, based on post title.
     *  - Sorted by the number of hits in descending order.
     *
     * @param self ...$lists The other post lists to merge.
     *
     * @return \Lullabot\Parsely\PostList
     */
    public static function merge(self ...$lists): self
    {
        $merged = [];
        foreach ($lists as $list) {
            $merged = array_merge($merged, $list->getData());
        }

        // Remove duplicate results from the other list, based on title.
        $titles = [];
        $merged = array_filter($merged, function (Post $post) use (&$titles) {
            if (\in_array($post->getTitle(), $titles)) {
                return false;
            }

            $titles[] = $post->getTitle();

            return true;
        });

        // Sort by the number of hits.
        usort($merged, function (Post $a, Post $b) {
            return $a->getHits() > $b->getHits() ? -1 : 1;
        });

        $new = new self();
        $new->setData($merged);

        return $new;
    }

    public function slice(int $offset, int $length = null, bool $perserveKeys = false): self
    {
        $slice = new self();
        $slice->setData(\array_slice($this->getData(), $offset, $length, $perserveKeys));

        return $slice;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->getData());
    }
}
