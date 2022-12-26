<?php declare(strict_types=1);

namespace Myposter\Tests\Logger;

use Monolog\Handler\TestHandler;
use Monolog\Level;
use Myposter\Logger\DatabaseHandler;
use Myposter\Logger\FileHandler;
use Myposter\Logger\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testLoggerHasFileHandler(): void
    {
        $handlers = Logger::getLogger()->getHandlers();
        self::assertCount(1, $handlers);
        self::assertInstanceOf(FileHandler::class, $handlers[0]);
    }

    public function testLoggerHasDatabaseHandler(): void
    {
        putenv('LOGGER_MAIN_HANDLER=database');
        $handlers = Logger::getLogger()->getHandlers();
        self::assertCount(1, $handlers);
        self::assertInstanceOf(DatabaseHandler::class, $handlers[0]);
    }

    /**
     * @return \Generator
     */
    public function dataProviderLoggerCanAddRecords(): \Generator
    {
        yield [
           'Debug Log Record' => ['level' => Level::Debug, 'record' => 'Test Debug 123']
        ];
        yield [
            'Info Log Record' => ['level' => Level::Info, 'record' => 'Test Info 123']
        ];
        yield [
            'Notice Log Record' => ['level' => Level::Notice, 'record' => 'Test Notice 123']
        ];
        yield [
            'Warning Log Record' => ['level' => Level::Warning, 'record' => 'Test Warning 123']
        ];
        yield [
            'Error Log Record' => ['level' => Level::Error, 'record' => 'Test Error 123']
        ];
        yield [
            'Critical Log Record' => ['level' => Level::Critical, 'record' => 'Test Critical 123']
        ];
        yield [
            'Alert Log Record' => ['level' => Level::Alert, 'record' => 'Test Alert 123']
        ];
    }

    /**
     * @dataProvider dataProviderLoggerCanAddRecords
     */
    public function testLoggerCanAddRecords(array $data): void
    {
        $logger = Logger::getLogger();
        $handler = $this->getMockBuilder('Monolog\Handler\HandlerInterface')->getMock();
        $handler->expects($this->never())->method('isHandling');
        $handler->expects($this->once())->method('handle');
        $logger->setHandlers([$handler]);

        $this->assertTrue($logger->addRecord($data['level'], $data['record']));
    }

    /**
     * @dataProvider dataProviderLoggerCanAddRecords
     */
    public function testLoggerCanCallStaticCalls(array $data): void
    {
        $logger = Logger::getLogger();
        $testHandler = new TestHandler();
        $logger->setHandlers([$testHandler]);
        $method = strtolower($data['level']->getName());
        Logger::$method($data['record']);
        list($record) = $testHandler->getRecords();
        self::assertEquals($data['level'], $record->level);
    }
}