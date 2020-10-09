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

use PPP\Monolog\Logger;
use PPP\Monolog\TestCase;

class MailHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\MailHandler::handleBatch
     */
    public function testHandleBatch()
    {
        $formatter = $this->getMock('PPP\\Monolog\\Formatter\\FormatterInterface');
        $formatter->expects($this->once())
            ->method('formatBatch'); // Each record is formatted

        $handler = $this->getMockForAbstractClass('PPP\\Monolog\\Handler\\MailHandler');
        $handler->expects($this->once())
            ->method('send');
        $handler->expects($this->never())
            ->method('write'); // write is for individual records

        $handler->setFormatter($formatter);

        $handler->handleBatch($this->getMultipleRecords());
    }

    /**
     * @covers Monolog\Handler\MailHandler::handleBatch
     */
    public function testHandleBatchNotSendsMailIfMessagesAreBelowLevel()
    {
        $records = array(
            $this->getRecord(Logger::DEBUG, 'debug message 1'),
            $this->getRecord(Logger::DEBUG, 'debug message 2'),
            $this->getRecord(Logger::INFO, 'information'),
        );

        $handler = $this->getMockForAbstractClass('PPP\\Monolog\\Handler\\MailHandler');
        $handler->expects($this->never())
            ->method('send');
        $handler->setLevel(Logger::ERROR);

        $handler->handleBatch($records);
    }

    /**
     * @covers Monolog\Handler\MailHandler::write
     */
    public function testHandle()
    {
        $handler = $this->getMockForAbstractClass('PPP\\Monolog\\Handler\\MailHandler');
        $handler->expects($this->once())
            ->method('send');

        $handler->handle($this->getRecord());
    }
}