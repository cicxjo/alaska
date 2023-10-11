<?php

declare(strict_types = 1);

namespace App\Model;

use PDO;
use PDOException;
use PDOStatement;

class PDOHandler
{
    private PDO $pdo;
    private static ?self $instance = null;
    private Config $config;

    private function __construct()
    {
        $this->config = Config::getInstance();

        $dsn  = 'mysql:host=localhost;dbname=' . $this->config->getDatabaseName() . ';charset=utf8mb4';

        try {
            $this->pdo = new PDO(
                $dsn,
                $this->config->getDatabaseUsername(),
                $this->config->getDatabasePassword(),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function execute(string $sql, ?array $args = null) : PDOStatement
    {
        $instance = self::getInstance();

        if (!isset($instance->pdo)) {
            exit();
        }

        $statement = $instance->pdo->prepare($sql);
        $args ? $statement->execute($args) : $statement->execute();

        return $statement;
    }
}
