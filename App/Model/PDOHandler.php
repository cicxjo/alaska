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

    private function __construct()
    {
        $dsn  = 'mysql:host=localhost;dbname=';
        $dsn .= Config::getDatabaseName();
        $dsn .= ';charset=utf8mb4';

        try {
            $this->pdo = new PDO(
                $dsn,
                Config::getDatabaseUsername(),
                Config::getDatabasePassword(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
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
