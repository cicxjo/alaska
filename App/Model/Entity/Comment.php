<?php

declare(strict_types = 1);

namespace App\Model\Entity;

class Comment
{
    public const TABLE = 'comment';

    private int $id;
    private int $fk_article_id;
    private string $inserted_at;
    private string $name;
    private string $email;
    private string $content;
    private int $is_flagged;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFkArticleId(): int
    {
        return $this->fk_article_id;
    }

    public function setFkArticleId(int $fkArticleId): self
    {
        $this->fk_article_id = $fkArticleId;

        return $this;
    }

    public function getInsertedAt(): string
    {
        return $this->inserted_at;
    }

    public function setInsertAt(string $insertedAt): self
    {
        $this->inserted_at = $insertedAt;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsFlagged(): int
    {
        return $this->is_flagged;
    }

    public function setIsFlagged(int $isFlagged): self
    {
        $this->is_flagged = $isFlagged;

        return $this;
    }
}
