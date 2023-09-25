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
            'url' => $this->config->getWebsiteUrl(),
            'domain' => $this->config->getWebsiteDomain(),
            'articles' => $this->articleManager->getAll(),
        ]);
    }

    public function showArticle(?array $parameters): void
    {
        $id = $parameters['id'] ?? null;

        if ($this->isValidId($id)) {
            $article = $this->articleManager->getById((int) $id);

            if ($article) {
                $render = new Render('Page', 'ShowArticle');
                $render->process([
                    'article' => $article,
                    'url' => $this->config->getWebsiteUrl(),
                    'domain' => $this->config->getWebsiteDomain(),
                ]);
            } else {
                throw new HTTPException(404);
                return;
            }
        }
    }
}
