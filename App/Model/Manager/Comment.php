<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Config;
use App\Model\Entity\Comment as CommentEntity;
use App\Model\PDOHandler;
use App\Model\PrintAndDie;
use PDO;
use PDOException;

class Comment
{
    private PDOHandler $pdoHandler;
    private string $commentEntity = CommentEntity::class;
    private string $commentTable = CommentEntity::class::TABLE;

    public function __construct()
    {
        $this->pdoHandler = PDOHandler::getInstance();
    }

    public function getAll(?bool $flagged = null): ?array
    {

        $sql = <<<HEREDOC
        SELECT * FROM {$this->commentTable}
        HEREDOC;

        $sql .= isset($flagged)
        ? ($flagged
            ? ' WHERE is_flagged = 1'
            : ' WHERE is_flagged = 0')
        : '';

        try {
            $comments = $this->pdoHandler->execute($sql)
                ->fetchAll(PDO::FETCH_CLASS, $this->commentEntity);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return !empty($comments) ? $comments : null;
    }

    public function getById(int $id): ?CommentEntity
    {
        $sql = <<<HEREDOC
        SELECT * FROM {$this->commentTable}
        WHERE id = {$id}
        HEREDOC;

        try {
            $comment = $this->pdoHandler->execute($sql)
                ->fetchAll(PDO::FETCH_CLASS, $this->commentEntity);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return !empty($comment) ? $comment[0] : null;
    }

    public function create(CommentEntity $entity): void
    {
        $sql = <<<HEREDOC
        INSERT INTO {$this->commentTable}
        (name, email, content, fk_article_id)
        VALUES (:name, :email, :content, :fk_article_id)
        HEREDOC;

        $values = [
            'name' => $entity->getName(),
            'email' => $entity->getEmail(),
            'content' => $entity->getContent(),
            'fk_article_id' => $entity->getFkArticleId()
        ];


        try {
            $this->pdoHandler->execute($sql, $values);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function updateReport(int $id, bool $flagged): void
    {
        $sql = <<<HEREDOC
        UPDATE {$this->commentTable}
        SET is_flagged = :is_flagged
        WHERE id = {$id}
        HEREDOC;

        $values = ['is_flagged' => $flagged ? 1 : 0];

        try {
            $this->pdoHandler->execute($sql, $values);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function delete(int $id): void
    {
        $sql = <<<HEREDOC
        DELETE FROM {$this->commentTable}
        WHERE id = {$id}
        HEREDOC;

        try {
            $this->pdoHandler->execute($sql);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }
}
