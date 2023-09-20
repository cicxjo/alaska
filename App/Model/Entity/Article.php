<?php

declare(strict_types = 1);

namespace App\Model\Entity;

class Article
{
    public const TABLE = 'article';

    private int $id;
    private string $inserted_at;
    private string $modified_at;
    private string $title;
    private string $content;
    private array $comments = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getInsertedAt(): string
    {
        return $this->inserted_at;
    }

    public function setInsertedAt(string $insertedAt): self
    {
        $this->inserted_at = $insertedAt;

        return $this;
    }

    public function getModifiedAt(): string
    {
        return $this->modified_at;
    }

    public function setModifiedAt(string $modifiedAt): self
    {
        $this->modified_at = $modifiedAt;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): self
    {
        $this->comments = $comments;

        return $this;
    }
}
