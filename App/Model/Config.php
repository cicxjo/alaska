<?php

declare(strict_types = 1);

namespace App\Model;

class Config
{
    private static ?self $instance = null;
    private string $databaseName;
    private string $databaseUsername;
    private string $databasePassword;
    private bool $databaseDebug;

    private function __construct()
    {
        $config = realpath(getcwd() . '/config.ini');
        $config = parse_ini_file($config, true, INI_SCANNER_TYPED);

        $this->databaseName = $config['database']['name'];
        $this->databaseUsername = $config['database']['username'];
        $this->databasePassword = $config['database']['password'];
        $this->databaseDebug = $config['database']['debug'];
    }

    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getDatabaseName(): string
    {
        return self::getInstance()->databaseName;
    }

    public static function getDatabaseUsername(): string
    {
        return self::getInstance()->databaseUsername;
    }

    public static function getDatabasePassword(): string
    {
        return self::getInstance()->databasePassword;
    }

    public static function getDatabaseDebug(): bool
    {
        return self::getInstance()->databaseDebug;
    }
}
