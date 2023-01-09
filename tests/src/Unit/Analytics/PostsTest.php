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
        $limit = 1;
        $mock_callback = function (RequestInterface $request) use ($limit) {
            $expected_uri = "https://api.parsely.com/v2/analytics/posts?limit=$limit&apikey=fakeKey&secret=fakeSecret";
            $actual_uri = (string) $request->getUri();
            $this->assertSame($expected_uri, $actual_uri);
            $message_fixture = file_get_contents(__DIR__.'/../../../fixtures/analytics/posts');

            return parse_response($message_fixture);
        };
        $mock_handler = new MockHandler([$mock_callback]);
        $guzzle = new GuzzleClient(Client::getDefaultConfiguration($mock_handler));
        $client = new Client($guzzle, 'fakeKey', 'fakeSecret');
        $posts = new Posts($client);

        $posts->setLimit($limit);
        $result = $posts->execute()->wait();
        $this->assertCount($limit, $result);

        $expected_title = 'Gina Kirschenheiter Shares Why She and Her Husband Are Divorcing, "But We Will Never Be Split"';
        $actual_title = $result[0]->getTitle();
        $this->assertSame($expected_title, $actual_title);
    }
}
