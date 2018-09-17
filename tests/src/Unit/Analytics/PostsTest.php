<?php

namespace Lullabot\Parsely\Tests\Unit\Analytics;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use function GuzzleHttp\Psr7\parse_response;
use Lullabot\Parsely\Analytics\Posts;
use Lullabot\Parsely\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class PostsTest extends TestCase
{
    public function testExecute()
    {
        $guzzle = new GuzzleClient(Client::getDefaultConfiguration(new MockHandler([
            function (RequestInterface $request) {
                $this->assertEquals('https://api.parsely.com/v2/analytics/posts?limit=1&apikey=key&secret=secret', (string) $request->getUri());

                return parse_response(file_get_contents(__DIR__.'/../../../fixtures/analytics/posts'));
            },
        ])));
        $client = new Client($guzzle, 'key', 'secret');
        $posts = new Posts($client);

        $posts->setLimit(1);
        $result = $posts->execute()->wait();
        $this->assertCount(1, $result);
        $this->assertEquals('Gina Kirschenheiter Shares Why She and Her Husband Are Divorcing, "But We Will Never Be Split"', $result[0]->getTitle());
    }
}
