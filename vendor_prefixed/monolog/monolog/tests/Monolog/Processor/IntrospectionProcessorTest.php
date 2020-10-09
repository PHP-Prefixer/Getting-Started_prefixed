<?php /* This file has been prefixed by <PHP-Prefixer> for "PHP-Prefixer Getting Started" */

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PPP\Monolog\Processor;

use PPP\Monolog\TestCase;
use PPP\Monolog\Handler\TestHandler;

class IntrospectionProcessorTest extends TestCase
{
    public function getHandler()
    {
        $processor = new IntrospectionProcessor();
        $handler = new TestHandler();
        $handler->pushProcessor($processor);
        return $handler;
    }

    public function testProcessorFromClass()
    {
        $handler = $this->getHandler();
        $tester = new \Acme\Tester;
        $tester->test($handler, $this->getRecord());
        list($record) = $handler->getRecords();
        $this->assertEquals(__FILE__, $record['extra']['file']);
        $this->assertEquals(57, $record['extra']['line']);
        $this->assertEquals('Acme\Tester', $record['extra']['class']);
        $this->assertEquals('test', $record['extra']['function']);
    }

    public function testProcessorFromFunc()
    {
        $handler = $this->getHandler();
        \Acme\tester($handler, $this->getRecord());
        list($record) = $handler->getRecords();
        $this->assertEquals(__FILE__, $record['extra']['file']);
        $this->assertEquals(63, $record['extra']['line']);
        $this->assertEquals(null, $record['extra']['class']);
        $this->assertEquals('Acme\tester', $record['extra']['function']);
    }
}

namespace Acme;

class Tester
{
    function test($handler, $record)
    {
        $handler->handle($record);
    }
}

function tester($handler, $record)
{
    $handler->handle($record);
}