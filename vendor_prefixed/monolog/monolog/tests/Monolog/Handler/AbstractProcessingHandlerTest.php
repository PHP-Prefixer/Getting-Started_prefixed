<?php /* This file has been prefixed by <PHP-Prefixer> for "PHP-Prefixer Getting Started" */

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PPP\Monolog\Handler;

use PPP\Monolog\TestCase;
use PPP\Monolog\Logger;
use PPP\Monolog\Processor\WebProcessor;

class AbstractProcessingHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\AbstractProcessingHandler::handle
     */
    public function testHandleLowerLevelMessage()
    {
        $handler = $this->getMockForAbstractClass('PPP\Monolog\Handler\AbstractProcessingHandler', array(Logger::WARNING, true));
        $this->assertFalse($handler->handle($this->getRecord(Logger::DEBUG)));
    }

    /**
     * @covers Monolog\Handler\AbstractProcessingHandler::handle
     */
    public function testHandleBubbling()
    {
        $handler = $this->getMockForAbstractClass('PPP\Monolog\Handler\AbstractProcessingHandler', array(Logger::DEBUG, true));
        $this->assertFalse($handler->handle($this->getRecord()));
    }

    /**
     * @covers Monolog\Handler\AbstractProcessingHandler::handle
     */
    public function testHandleNotBubbling()
    {
        $handler = $this->getMockForAbstractClass('PPP\Monolog\Handler\AbstractProcessingHandler', array(Logger::DEBUG, false));
        $this->assertTrue($handler->handle($this->getRecord()));
    }

    /**
     * @covers Monolog\Handler\AbstractProcessingHandler::handle
     */
    public function testHandleIsFalseWhenNotHandled()
    {
        $handler = $this->getMockForAbstractClass('PPP\Monolog\Handler\AbstractProcessingHandler', array(Logger::WARNING, false));
        $this->assertTrue($handler->handle($this->getRecord()));
        $this->assertFalse($handler->handle($this->getRecord(Logger::DEBUG)));
    }

    /**
     * @covers Monolog\Handler\AbstractProcessingHandler::processRecord
     */
    public function testProcessRecord()
    {
        $handler = $this->getMockForAbstractClass('PPP\Monolog\Handler\AbstractProcessingHandler');
        $handler->pushProcessor(new WebProcessor(array(
            'REQUEST_URI' => '',
            'REQUEST_METHOD' => '',
            'REMOTE_ADDR' => '',
        )));
        $handledRecord = null;
        $handler->expects($this->once())
            ->method('write')
            ->will($this->returnCallback(function($record) use (&$handledRecord){
                $handledRecord = $record;
            }))
        ;
        $handler->handle($this->getRecord());
        $this->assertEquals(3, count($handledRecord['extra']));
    }
}
