<?php declare(strict_types=1);

namespace Myposter;

use Dotenv\Dotenv;
use \InvalidArgumentException;

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
        $application->dotEnv = Dotenv::createImmutable(static::getRootDirectoryPath());
        $application->dotEnv->load();
        return $application;
    }

    public function getEnv($envName)
    {
        return $_ENV[$envName];
    }

    public function setEnv($envName, $envValue): void
    {
        $_ENV[$envName] = $envValue;
    }

    public static function getRootDirectoryPath(): string
    {
        return __DIR__ . '/../';
    }

    public static function ensureDirectory(string $pathFromRoot): string
    {
        $directoryPath = static::getRootDirectoryPath() . $pathFromRoot;

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        if (!is_dir($directoryPath)) {
            throw new InvalidArgumentException('Path is not a directory!');
        }

        return $directoryPath;
    }
}