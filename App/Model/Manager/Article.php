<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Config;
use App\Model\Entity\Article as ArticleEntity;
use App\Model\PDOHandler;
use App\Model\PrintAndDie;
use PDO;
use PDOException;

class Article
{
    private string $articleEntity = ArticleEntity::class;
    private string $articleTable = ArticleEntity::class::TABLE;

    public function getAll(): ?array
    {
        $sql = <<<HEREDOC
        SELECT * FROM {$this->articleTable}
        HEREDOC;

        try {
            $articles = PDOHandler::run($sql)
                ->fetchAll(PDO::FETCH_CLASS, $this->articleEntity);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return !empty($articles) ? $articles : null;
    }

    public function getById(int $id): ?ArticleEntity
    {
        $sql = <<<HEREDOC
        SELECT * FROM {$this->articleTable}
        WHERE id = {$id}
        HEREDOC;

        try {
            $article = PDOHandler::run($sql)
                ->fetchAll(PDO::FETCH_CLASS, $this->articleEntity);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return !empty($article) ? $article[0] : null;
    }

    public function create(ArticleEntity $entity): void
    {
        $sql = <<<HEREDOC
        INSERT INTO {$this->articleTable}
        (title, content)
        VALUES (:title, :content)
        HEREDOC;

        $values = [
            'title' => $entity->getTitle(),
            'content' => $entity->getContent(),
        ];

        try {
            PDOHandler::run($sql, $values);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function delete(int $id): void
    {
        $sql = <<<HEREDOC
        DELETE FROM {$this->articleTable}
        WHERE id = {$id}
        HEREDOC;

        try {
            PDOHandler::run($sql);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function update(ArticleEntity $entity): void
    {
        $sql = <<<HEREDOC
        UPDATE {$this->articleTable}
        SET title = :title, content = :content
        WHERE id = {$entity->getId()}
        HEREDOC;

        $values = [
            'title' => $entity->getTitle(),
            'content' => $entity->getContent(),
        ];

        try {
            PDOHandler::run($sql, $values);
        } catch (PDOException $e) {
            if (Config::getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }
}
