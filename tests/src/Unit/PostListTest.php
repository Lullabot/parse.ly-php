<?php

namespace Lullabot\Parsely\Tests\Unit;

use Lullabot\Parsely\Post;
use Lullabot\Parsely\PostList;
use PHPUnit\Framework\TestCase;

class PostListTest extends TestCase
{
    public function testMerge()
    {
        // Four mock posts to use in different lists.
        $one = $this->getPost('One post', 3);
        $two = $this->getPost('Two post', 4);
        $three = $this->getPost('Three post', 2);
        $four = $this->getPost('Four post', 10);

        $firstList = new PostList();
        $firstList->setData([
            $one,
            $two,
        ]);

        // "two" is a duplicate post so it should be removed.
        $secondList = new PostList();
        $secondList->setData([
            $two,
            $three,
        ]);

        // "two" and "three" will be removed, and "four" will be sorted to the
        // top.
        $thirdList = new PostList();
        $thirdList->setData([
            $two,
            $three,
            $four,
        ]);

        $merged = PostList::merge($firstList, $secondList, $thirdList);

        $expected = [
            $four,
            $two,
            $one,
            $three,
        ];
        $this->assertEquals($expected, $merged->getData());
    }

    private function getPost(string $title, int $hits): Post
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setHits($hits);

        return $post;
    }
}
