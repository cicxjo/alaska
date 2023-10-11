<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Entity\Article as ArticleEntity;
use App\Model\Entity\Comment as CommentEntity;
use App\Model\PrintAndDie;
use PDO;
use PDOException;
use ReflectionClass;

class Article extends AbstractManager
{
    private string $articleEntity = ArticleEntity::class;
    private string $commentEntity = CommentEntity::class;
    private string $articleTable = ArticleEntity::class::TABLE;
    private string $commentTable = CommentEntity::class::TABLE;
    private ReflectionClass $articleReflection;
    private ReflectionClass $commentReflection;
    private string $articleAlias = 'article';
    private string $commentAlias = 'comment';

    public function __construct()
    {
        parent::__construct();

        $this->articleReflection = new ReflectionClass($this->articleEntity);
        $this->commentReflection = new ReflectionClass($this->commentEntity);
    }

    private function get(): string
    {
        $sql = "SELECT\n";
        $articleProperties = $this->articleReflection->getProperties();
        $commentProperties = $this->commentReflection->getProperties();

        foreach ($articleProperties as $articleProperty) {
            if ($articleProperty->getName() === 'comments') {
                break;
            }
            $string = $this->articleTable . '.' . $articleProperty->getName();
            $string .= ' AS ';
            $string .= $this->articleAlias . '_' . $articleProperty->getName();
            $string .= ",\n";
            $sql .= $string;
        }

        for ($i=0; $i < count($commentProperties); $i++) {
            $commentProperty = current($commentProperties);
            $string = $this->commentTable . '.' . $commentProperty->getName();
            $string .= ' AS ';
            $string .= $this->commentAlias . '_' . $commentProperty->getName();
            if ($i !== (count($commentProperties) - 1)) {
                $string .= ',';
            }
            $string .= "\n";
            $sql .= $string;
            $commentProperty = next($commentProperties);
        }

        $sql .= <<<HEREDOC
        FROM {$this->articleTable}
        LEFT JOIN {$this->commentTable} ON {$this->articleTable}.id = {$this->commentTable}.fk_article_id
        HEREDOC;

        return $sql;
    }

    private function getWithComments(string $sql, ?array $args = null): ?array
    {
        $articles = [];
        $comments = [];

        $query = $this->pdoHandler
                      ->execute($sql, $args);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new ArticleEntity();
            $article->setId($row[$this->articleAlias . '_id'])
                    ->setInsertedAt($row[$this->articleAlias . '_inserted_at'])
                    ->setModifiedAt($row[$this->articleAlias . '_modified_at'])
                    ->setTitle($row[$this->articleAlias . '_title'])
                    ->setContent($row[$this->articleAlias . '_content']);

            if (!in_array($article, $articles)) {
                $articles[$article->getId()] = $article;
            }

            if ($row[$this->commentAlias . '_id']) {
                $comment = new CommentEntity();
                $comment->setId($row[$this->commentAlias . '_id'])
                        ->setFkArticleId($row[$this->commentAlias . '_fk_article_id'])
                        ->setName($row[$this->commentAlias . '_name'])
                        ->setEmail($row[$this->commentAlias . '_email'])
                        ->setIsFlagged($row[$this->commentAlias . '_is_flagged'])
                        ->setContent($row[$this->commentAlias . '_content'])
                        ->setInsertAt($row[$this->commentAlias . '_inserted_at']);
                $comments[$comment->getFkArticleId()][] = $comment;
            }
        }

        foreach ($comments as $key => $value) {
            $articles[$key]->setComments($value);
        }

        return empty($articles) ? null : array_values($articles);
    }

    public function getAll(): ?array
    {
        $sql = $this->get();
        $sql .= "\n" . 'ORDER BY ' . $this->articleTable . '.id ASC';

        try {
            $articles = $this->getWithComments($sql);
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return empty($articles) ? null : $articles;
    }

    public function getById(int $id): ?ArticleEntity
    {
        $sql = $this->get();
        $sql .= "\n" . 'WHERE ' . $this->articleTable . '.id = :id';

        try {
            $article = $this->getWithComments($sql, ['id' => $id]);
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }

        return empty($article) ? null : $article[0];
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
            $this->pdoHandler
                 ->execute($sql, $values);
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function delete(int $id): void
    {
        $sql = <<<HEREDOC
        DELETE FROM {$this->articleTable}
        WHERE id = :id
        HEREDOC;

        try {
            $this->pdoHandler
                 ->execute($sql, ['id' => $id]);
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }

    public function update(ArticleEntity $entity): void
    {
        $sql = <<<HEREDOC
        UPDATE {$this->articleTable}
        SET title = :title, content = :content
        WHERE id = :id
        HEREDOC;

        $values = [
            'title' => $entity->getTitle(),
            'content' => $entity->getContent(),
            'id' => $entity->getId()
        ];

        try {
            $this->pdoHandler
                 ->execute($sql, $values);
        } catch (PDOException $e) {
            if ($this->config->getDatabaseDebug()) {
                PrintAndDie::vars($e->getMessage());
            }
        }
    }
}
