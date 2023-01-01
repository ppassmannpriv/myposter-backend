<?php declare(strict_types=1);

namespace Myposter\Tests\Logger;

use Monolog\Handler\TestHandler;
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

    public function testLoggerCallsPassToMonologHandler(): void
    {
        $testHandler = new TestHandler();
        Logger::getLogger()->popHandler();
        Logger::getLogger()->pushHandler($testHandler);

        Logger::debug('Test debug', ['debug' => true]);
        $this->assertTrue($testHandler->hasDebugThatMatches('/Test debug/'));
        $this->assertTrue($testHandler->getRecords()[0]->context['debug']);
        $testHandler->clear();

        Logger::info('Test info', ['info' => true]);
        $this->assertTrue($testHandler->hasInfoThatMatches('/Test info/'));
        $this->assertTrue($testHandler->getRecords()[0]->context['info']);
        $testHandler->clear();

        Logger::notice('Test notice', ['notice' => true]);
        $this->assertTrue($testHandler->hasNoticeThatMatches('/Test notice/'));

        Logger::warning('Test warning', ['warning' => true]);
        $this->assertTrue($testHandler->hasWarningThatMatches('/Test warning/'));

        Logger::error('Test error', ['error' => true]);
        $this->assertTrue($testHandler->hasErrorThatMatches('/Test error/'));

        Logger::critical('Test critical', ['critical' => true]);
        $this->assertTrue($testHandler->hasCriticalThatMatches('/Test critical/'));

        Logger::alert('Test alert', ['alert' => true]);
        $this->assertTrue($testHandler->hasAlertThatMatches('/Test alert/'));

        Logger::emergency('Test emergency', ['emergency' => true]);
        $this->assertTrue($testHandler->hasEmergencyThatMatches('/Test emergency/'));
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