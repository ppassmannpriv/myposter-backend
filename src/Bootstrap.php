<?php declare(strict_types=1);

namespace Myposter;

use Dotenv\Dotenv;

class Bootstrap
{
    private static ?self $instance = null;

    private Dotenv $dotEnv;

    private function __construct() {}

    private function __clone() {}

    public function __wakeUp() {
        throw new \Exception('Bootstrap cannot be serialized!');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }

    private static function create(): self
    {
        $application = new self();
        $application->dotEnv = Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR .  '../');
        $application->dotEnv->load();
        return $application;
    }

    public function getEnv($envName)
    {
        return $_ENV[$envName];
    }
}