<?php declare(strict_types=1);

namespace Myposter\Tests\Logger;

use Myposter\Bootstrap;
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
        Bootstrap::getInstance()->setEnv('LOGGER_MAIN_HANDLER', 'database');

        $loggerReflection = new \ReflectionClass(Logger::class);
        $loggerInstance = $loggerReflection->getProperty('instance');
        $loggerInstance->setAccessible(true);
        $loggerInstance->setValue(null);
        $loggerInstance->setAccessible(false);

        $handlers = Logger::getLogger()->getHandlers();
        self::assertCount(1, $handlers);
        self::assertInstanceOf(DatabaseHandler::class, $handlers[0]);
    }
}