<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Entity\Article as ArticleEntity;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Manager\User as UserManager;
use App\Model\Render;

class Administration
{
    private ArticleManager $articleManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->articleManager = new ArticleManager();
        $this->userManager = new UserManager();
    }

    private function authenticate(): bool
    {
        function destroySessionAndSendHeader()
        {
            if (isset($_SERVER['PHP_AUTH_USER'])) {
                unset($_SERVER['PHP_AUTH_USER']);
            }

            if (isset($_SERVER['PHP_AUTH_PW'])) {
                unset($_SERVER['PHP_AUTH_PW']);
            }

            header('WWW-Authenticate: Basic realm="My Realm"');
        }

        if (isset($_SERVER['PHP_AUTH_USER'])
            && isset($_SERVER['PHP_AUTH_PW'])) {
            $user = $this->userManager
                         ->getByUsername($_SERVER['PHP_AUTH_USER']);
            $hashPassword = hash('sha256', $_SERVER['PHP_AUTH_PW']);

            if ($user) {
                if ($_SERVER['PHP_AUTH_USER'] === $user->getUsername()
                    && $hashPassword === $user->getPassword()) {
                    return true;
                } else {
                    destroySessionAndSendHeader();
                }
            } else {
                destroySessionAndSendHeader();
            }
        } else {
            destroySessionAndSendHeader();
        }
    }

    public function showPanel(): void
    {
        if ($this->authenticate()) {
            $render = new Render('Page', 'AdministrationPanel');
            $render->process([
            'title' => 'Panneau d’administration',
            'url' => Config::getUrl(),
            'domain' => Config::getDomain(),
            'articles' => $this->articleManager->getAll(),
            ]);
        }
    }

    public function addArticle(): void
    {
        if ($this->authenticate()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['article_title'] && $_POST['article_content']) {
                    $article = new ArticleEntity();
                    $article->setTitle($_POST['article_title'])
                            ->setContent($_POST['article_content']);
                    $this->articleManager->create($article);
                    header('Location: ' . Config::getUrl() . '/admin');
                    return;
                }
            }

            $render = new Render('Page', 'ArticleEditor');
            $render->process([
                'title' => 'Panneau d’administration',
                'url' => Config::getUrl(),
                'domain' => Config::getDomain(),
                'tinymce' => true,
            ]);
        }
    }
}
