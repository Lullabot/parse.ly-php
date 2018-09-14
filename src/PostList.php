<?php

namespace Lullabot\Parsely;

/**
 * Class PostList.
 *
 * @todo Do all lists of any object have the same format? If so, this could
 *   become just 'List'.
 */
class PostList implements \ArrayAccess, \Countable
{
    /**
     * @var \Lullabot\Parsely\Post[]
     */
    private $data;

    /**
     * @param \Lullabot\Parsely\Post[] $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function count() {
        return count($this->data);
    }
}
