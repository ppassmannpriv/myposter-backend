<?php declare(strict_types=1);

namespace Myposter\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\SyslogFormatter;
use Monolog\Handler\RotatingFileHandler;
use Myposter\Bootstrap;
use Myposter\Logger\Formatter\FileFormatter;

class FileHandler extends RotatingFileHandler
{
    public function __construct()
    {
        $dir = Bootstrap::ensureDirectory('log');
        $channelName = Bootstrap::getInstance()->getEnv('LOGGER_CHANNEL');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        parent::__construct($dir . DIRECTORY_SEPARATOR . $channelName . '.log', 5);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new FileFormatter();
    }
}