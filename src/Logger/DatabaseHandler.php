<?php declare(strict_types=1);

namespace Myposter\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class DatabaseHandler extends AbstractProcessingHandler
{
    private $databaseConnection;

    public function __construct($databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        parent::__construct(Level::Debug);
    }

    protected function write(LogRecord $record): void
    {
        var_dump($record->formatted);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES, false);
    }
}