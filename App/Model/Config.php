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
    private string $websiteUrl;
    private string $websiteDomain;

    private function __construct()
    {
        $config = realpath(getcwd() . '/config.ini');
        $config = parse_ini_file($config, true, INI_SCANNER_TYPED);

        $this->databaseName = $config['database']['name'];
        $this->databaseUsername = $config['database']['username'];
        $this->databasePassword = $config['database']['password'];
        $this->databaseDebug = $config['database']['debug'];
        $this->websiteUrl = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://" . $_SERVER['HTTP_HOST'];
        // $this->websiteUrl = $config['website']['url'];
        $this->websiteDomain = $_SERVER['HTTP_HOST'];
        // $this->websiteDomain = $config['website']['domain'];
    }

    public static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getDatabaseUsername(): string
    {
        return $this->databaseUsername;
    }

    public function getDatabasePassword(): string
    {
        return $this->databasePassword;
    }

    public function getDatabaseDebug(): bool
    {
        return $this->databaseDebug;
    }

    public function getWebsiteUrl(): string
    {
        return $this->websiteUrl;
    }

    public function getWebsiteDomain(): string
    {
        return $this->websiteDomain;
    }
}
