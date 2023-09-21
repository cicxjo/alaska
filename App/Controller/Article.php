<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Render;

class Article
{
    private ArticleManager $articleManager;

    public function __construct()
    {
        $this->articleManager = new ArticleManager();
    }

    public function listArticles(): void
    {
        $render = new Render('Page', 'ListArticles');
        $render->process([
            'title' => 'Billet simple pour l’Alaska',
            'url' => Config::getUrl(),
            'domain' => Config::getDomain(),
            'articles' => $this->articleManager->getAll(),
        ]);
    }

    public function showArticle(array $params): void
    {
        $id = $params['id'];

        if (!ctype_digit($id)) {
            throw new HTTPException(404);
            return;
        }

        $id = (int) $id;
        $article = $this->articleManager->getById($id);
        $render = new Render('Page', 'ShowArticle');
        $render->process([
            'article' => $this->articleManager->getById($id),
            'url' => Config::getUrl(),
            'domain' => Config::getDomain(),
        ]);
    }
}
