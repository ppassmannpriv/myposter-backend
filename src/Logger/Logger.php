<?php declare(strict_types=1);

namespace Myposter\Logger;

use Monolog\Handler\RotatingFileHandler;
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
    static public function getLogger(): MonologLogger
    {
        if (self::$instance === null) {
            self::$instance = self::configureInstance();
        }

        return self::$instance;
    }

    public static function configureInstance(): MonologLogger
    {
        $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . '../log';
        $channelName = Bootstrap::getInstance()->getEnv('LOGGER_CHANNEL');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $logger = new MonologLogger('MyPoster ' . $channelName);
        $logger->pushHandler(new RotatingFileHandler($dir . DIRECTORY_SEPARATOR . $channelName . '.log', 5));
        $logger->pushHandler(new DatabaseHandler());

        return $logger;
    }

    public static function debug($message, array $context = [])
    {
        self::getLogger()->debug($message, $context);
    }

    public static function info($message, array $context = [])
    {
        self::getLogger()->info($message, $context);
    }

    public static function notice($message, array $context = [])
    {
        self::getLogger()->notice($message, $context);
    }

    public static function warning($message, array $context = [])
    {
        self::getLogger()->warning($message, $context);
    }

    public static function error($message, array $context = [])
    {
        self::getLogger()->error($message, $context);
    }

    public static function critical($message, array $context = [])
    {
        self::getLogger()->critical($message, $context);
    }

    public static function alert($message, array $context = [])
    {
        self::getLogger()->alert($message, $context);
    }

    public static function emergency($message, array $context = [])
    {
        self::getLogger()->emergency($message, $context);
    }

}
