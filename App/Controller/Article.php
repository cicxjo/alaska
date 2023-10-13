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
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $render = new Render('Page', 'ListArticles');
            $render->process([
                'title' => 'Billet simple pour l’Alaska',
                'url' => $this->config->getWebsiteUrl(),
                'domain' => $this->config->getWebsiteDomain(),
                'articles' => $this->articleManager->getAllWithoutComment(),
            ]);
            return;
        } else {
            throw new HTTPException(405);
            return;
        }
    }

    public function showArticle(?array $parameters): void
    {
        $id = $parameters['id'];

        if ($this->isValidId($id)) {
            $article = $this->articleManager->getById((int) $id);

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if ($article) {
                    $render = new Render('Page', 'ShowArticle');
                    $render->process([
                        'article' => $article,
                        'url' => $this->config->getWebsiteUrl(),
                        'domain' => $this->config->getWebsiteDomain(),
                    ]);
                    return;
                } else {
                    throw new HTTPException(404);
                    return;
                }
            } else {
                throw new HTTPException(405);
                return;
            }
        }
    }
}
