<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Entity\Article as ArticleEntity;
use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Manager\User as UserManager;
use App\Model\Render;
use App\Model\Url;

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
            $data = [
                'title' => 'Panneau d’administration',
                'url' => Config::getUrl(),
                'domain' => Config::getDomain(),
                'tinymce' => true,
            ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['article_title'] && $_POST['article_content']) {
                    $article = new ArticleEntity();
                    $article->setTitle($_POST['article_title'])
                            ->setContent($_POST['article_content']);
                    $this->articleManager->create($article);
                    header('Location: ' . Url::build('admin'));
                    return;
                }

                if (empty($_POST['article_title'])) {
                    $data['form']['article_title'] = false;
                } else {
                    $data['form']['article_title'] = $_POST['article_title'];
                }

                if (empty($_POST['article_content'])) {
                    $data['form']['article_content'] = false;
                } else {
                    $data['form']['article_content'] =$_POST['article_content'];
                }
            }

            $render = new Render('Page', 'ArticleEditor');
            $render->process($data);
        }
    }

    public function updateArticle(string $id): void
    {
        if ($this->authenticate()) {
            if (!ctype_digit($id)) {
                throw new HTTPException(404);
                return;
            }

            $id = (int) $id;
            $article = $this->articleManager->getById($id);
            $data = [
                'title' => 'Panneau d’administration',
                'url' => Config::getUrl(),
                'domain' => Config::getDomain(),
                'tinymce' => true,
                'article' => $article,
            ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['article_title'] && $_POST['article_content']) {
                    $article = new ArticleEntity();
                    $article->setTitle($_POST['article_title'])
                            ->setContent($_POST['article_content'])
                            ->setId($id);
                    $this->articleManager->update($article);
                    header('Location: ' . Url::build('admin'));
                    return;
                }

                if (empty($_POST['article_title'])) {
                    $data['form']['article_title'] = false;
                } else {
                    $data['form']['article_title'] = $_POST['article_title'];
                }

                if (empty($_POST['article_content'])) {
                    $data['form']['article_content'] = false;
                } else {
                    $data['form']['article_content'] =$_POST['article_content'];
                }
            }

            $render = new Render('Page', 'ArticleEditor');
            $render->process($data);
        }
    }

    public function deleteArticle(string $id): void
    {
        if ($this->authenticate()) {
            if (!ctype_digit($id)) {
                throw new HTTPException(404);
                return;
            }

            $id = (int) $id;
            $this->articleManager->delete($id);
            header('Location: ' . Url::build('admin'));
        }
    }
}
