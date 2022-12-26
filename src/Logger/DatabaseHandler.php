<?php declare(strict_types=1);

namespace Myposter\Logger;

use \PDO;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Myposter\Database\Connection;

class DatabaseHandler extends AbstractProcessingHandler
{
    private PDO $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = Connection::getInstance();
        parent::__construct();
    }

    protected function write(LogRecord $record): void
    {
        $statement = $this->databaseConnection->prepare('
            INSERT INTO logs VALUES (
            :json, 
            :created_at, 
            :log_level, 
            :channel
        )');

        $statement->execute([
            'json' => $record->formatted,
            'created_at' => $record->datetime,
            'log_level' => $record->level->getName(),
            'channel' => $record->channel
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES, false);
    }
}