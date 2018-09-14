<?php

namespace Lullabot\Parsely\Tests\Functional\Analytics;

use Lullabot\Parsely\Analytics\Posts;
use Lullabot\Parsely\Post;
use Lullabot\Parsely\PostList;
use Lullabot\Parsely\Tests\Functional\FunctionalTestBase;

class PostsTest extends FunctionalTestBase
{

    /**
     * A test that loads 10 posts.
     */
    public function testExecute()
    {
        $posts = new Posts($this->client);
        /** @var PostList $result */
        $result = $posts->execute()->wait();
        $this->assertInstanceOf(PostList::class, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }
}
