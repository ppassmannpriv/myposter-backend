<?php declare(strict_types=1);

namespace Myposter\Database;

use PDO;
use Myposter\Bootstrap;

class Connection
{
    protected static ?PDO $instance = null;

    private function __construct() {}

    private function __clone() {}

    public function __wakeUp() {
        throw new \Exception('Connection cannot be serialized!');
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }

    private static function create(): PDO
    {
        $dsn = Bootstrap::getInstance()->getEnv('DATABASE_URL');
        return new PDO($dsn);
    }
}