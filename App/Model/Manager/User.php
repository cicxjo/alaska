<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Config;
use App\Model\Entity\User as UserEntity;
use App\Model\PDOHandler;
use App\Model\PrintAndDie;
use PDO;
use PDOException;

class User
{
    private PDOHandler $pdoHandler;
    private string $userEntity = UserEntity::class;
    private string $userTable = UserEntity::class::TABLE;

    public function __construct()
    {
        $this->pdoHandler = PDOHandler::getInstance();
    }

    public function getByUsername(string $username): ?UserEntity
    {
        $sql = <<<HEREDOC
        SELECT * FROM user
        WHERE username = '{$username}'
        HEREDOC;

        try {
            $user = $this->pdoHandler
                         ->execute($sql)
                         ->fetchAll(PDO::FETCH_CLASS, $this->userEntity);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return !empty($user) ? $user[0] : null;
    }
}
