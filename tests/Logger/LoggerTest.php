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
        Bootstrap::getInstance()->setEnv('LOGGER_MAIN_HANDLER', 'file');

        $handlers = Logger::getLogger()->getHandlers();
        self::assertCount(1, $handlers);
        self::assertInstanceOf(FileHandler::class, $handlers[0]);

        $this->resetSingleton(Logger::class);
        $this->resetSingleton(Bootstrap::class);
        Bootstrap::getInstance()->setEnv('LOGGER_MAIN_HANDLER', 'file');
    }

    public function testLoggerHasDatabaseHandler(): void
    {
        Bootstrap::getInstance()->setEnv('LOGGER_MAIN_HANDLER', 'database');

        $handlers = Logger::getLogger()->getHandlers();
        self::assertCount(1, $handlers);
        self::assertInstanceOf(DatabaseHandler::class, $handlers[0]);

        $this->resetSingleton(Logger::class);
        $this->resetSingleton(Bootstrap::class);
        Bootstrap::getInstance()->setEnv('LOGGER_MAIN_HANDLER', 'file');
    }

    /**
     * @throws \ReflectionException
     */
    protected function resetSingleton(string $singletonFQN)
    {
        $loggerReflection = new \ReflectionClass($singletonFQN);
        $loggerInstance = $loggerReflection->getProperty('instance');
        $loggerInstance->setAccessible(true);
        $loggerInstance->setValue(null);
        $loggerInstance->setAccessible(false);
    }
}