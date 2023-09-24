<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Render;

class Article extends AbstractController
{
    private ArticleManager $articleManager;

    public function __construct()
    {
        parent::__construct();

        $this->articleManager = new ArticleManager();
    }

    public function listArticles(): void
    {
        $render = new Render('Page', 'ListArticles');
        $render->process([
            'title' => 'Billet simple pour l’Alaska',
            'url' => $this->config->getUrl(),
            'domain' => $this->config->getDomain(),
            'articles' => $this->articleManager->getAll(),
        ]);
    }

    public function showArticle(string $id): void
    {
        if (!ctype_digit($id)) {
            throw new HTTPException(404);
            return;
        }

        $id = (int) $id;
        $render = new Render('Page', 'ShowArticle');
        $render->process([
            'article' => $this->articleManager->getById($id),
            'url' => $this->config->getUrl(),
            'domain' => $this->config->getDomain(),
        ]);
    }
}
