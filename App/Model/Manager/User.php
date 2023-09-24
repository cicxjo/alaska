<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Entity\User as UserEntity;
use App\Model\PrintAndDie;
use PDO;
use PDOException;

class User extends AbstractManager
{
    private string $userEntity = UserEntity::class;
    private string $userTable = UserEntity::class::TABLE;

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
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return empty($user) ? null : $user[0];
    }
}
