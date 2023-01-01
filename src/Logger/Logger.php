<?php declare(strict_types=1);

namespace Myposter\Logger;

use Monolog\Logger as MonologLogger;
use Myposter\Bootstrap;

final class Logger
{
    protected static ?MonologLogger $instance = null;

    /**
     * Method to return the Monolog instance
     *
     * @return MonologLogger
     */
    public static function getLogger(): MonologLogger
    {
        if (self::$instance === null) {
            self::$instance = self::configureInstance();
        }

        return self::$instance;
    }

    public static function configureInstance(): MonologLogger
    {
        $channelName = Bootstrap::getInstance()->getEnv('LOGGER_CHANNEL');

        $logger = new MonologLogger($channelName);
        if (Bootstrap::getInstance()->getEnv('LOGGER_MAIN_HANDLER') === 'file') {
            $logger->pushHandler(new FileHandler());
        }
        if (Bootstrap::getInstance()->getEnv('LOGGER_MAIN_HANDLER') === 'database') {
            $logger->pushHandler(new DatabaseHandler());
        }

        return $logger;
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    public static function info($message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }

    public static function notice($message, array $context = []): void
    {
        self::getLogger()->notice($message, $context);
    }

    public static function warning($message, array $context = []): void
    {
        self::getLogger()->warning($message, $context);
    }

    public static function error($message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    public static function critical($message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    public static function alert($message, array $context = []): void
    {
        self::getLogger()->alert($message, $context);
    }

    public static function emergency($message, array $context = []): void
    {
        self::getLogger()->emergency($message, $context);
    }

}
