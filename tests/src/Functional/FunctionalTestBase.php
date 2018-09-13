<?php

namespace Lullabot\Parsely\Tests\Functional;

use Concat\Http\Middleware\Logger;
use GuzzleHttp\MessageFormatter;
use Lullabot\Parsely\Client;
use Namshi\Cuzzle\Middleware\CurlFormatterMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class FunctionalTestBase extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $key = getenv('PARSELY_KEY');
        $secret = getenv('PARSELY_SECRET');

        if (empty($secret) || empty($key)) {
            $this->markTestSkipped(
                'PARSELY_KEY, PARSELY_SECRET, must be defined as environment variables or in phpunit.xml for functional tests.'
            );
        }

        $config = Client::getDefaultConfiguration($key, $secret);

        if (getenv('PARSELY_LOG_CURL')) {
            $output = new ConsoleOutput();
            $output->setVerbosity(ConsoleOutput::VERBOSITY_DEBUG);
            $cl = new ConsoleLogger($output);
            /** @var $handler \GuzzleHttp\HandlerStack */
            $handler = $config['handler'];
            $handler->after('cookies', new CurlFormatterMiddleware($cl));

            $responseLogger = new Logger($cl);
            $responseLogger->setLogLevel(LogLevel::DEBUG);
            $responseLogger->setFormatter(new MessageFormatter(MessageFormatter::DEBUG));
            $handler->after('cookies', $responseLogger);
        }

        $this->client = new Client(new \GuzzleHttp\Client($config));
    }
}
