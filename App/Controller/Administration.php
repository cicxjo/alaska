<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Render;

class Administration
{
    private ArticleManager $articleManager;

    public function __construct()
    {
        $this->articleManager = new ArticleManager();
    }

    public function showPanel(): void
    {
        $render = new Render('Page', 'AdministrationPanel');
        $render->process([
            'title' => 'Panneau d’administration',
            'url' => Config::getUrl(),
            'domain' => Config::getDomain(),
            'articles' => $this->articleManager->getAll(),
        ]);
    }
}
