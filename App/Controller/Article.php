<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
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
}
