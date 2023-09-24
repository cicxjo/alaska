<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Entity\Article as ArticleEntity;
use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Manager\User as UserManager;
use App\Model\Render;

class Administration extends AbstractController
{
    private ArticleManager $articleManager;
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();

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

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $user = $this->userManager
                         ->getByUsername($_SERVER['PHP_AUTH_USER']);
            $hashPassword = hash('sha256', $_SERVER['PHP_AUTH_PW']);

            if ($user) {
                if ($_SERVER['PHP_AUTH_USER'] === $user->getUsername() && $hashPassword === $user->getPassword()) {
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
            'url' => $this->config->getWebsiteUrl(),
            'domain' => $this->config->getWebsiteDomain(),
            'articles' => $this->articleManager->getAll(),
            ]);
        }
    }

    public function addArticle(): void
    {
        if ($this->authenticate()) {
            $data = [
                'title' => 'Panneau d’administration',
                'url' => $this->config->getWebsiteUrl(),
                'domain' => $this->config->getWebsiteDomain(),
                'tinymce' => true,
            ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['article_title'] && $_POST['article_content']) {
                    $article = new ArticleEntity();
                    $article->setTitle($_POST['article_title'])
                            ->setContent($_POST['article_content']);
                    $this->articleManager->create($article);
                    header('Location: ' . $this->url->build('admin'));
                    return;
                }

                empty($_POST['article_title'])
                    ? $data['form']['article_title'] = false
                    : $data['form']['article_title'] = $_POST['article_title'];

                empty($_POST['article_content'])
                    ? $data['form']['article_content'] = false
                    : $data['form']['article_content'] =$_POST['article_content'];
            }

            $render = new Render('Page', 'ArticleEditor');
            $render->process($data);
        }
    }

    public function updateArticle(string $id): void
    {
        if ($this->authenticate() && $this->isValidId($id)) {
            $id = (int) $id;
            $article = $this->articleManager->getById($id);

            if ($article) {
                $data = [
                    'title' => 'Panneau d’administration',
                    'url' => $this->config->getWebsiteUrl(),
                    'domain' => $this->config->getWebsiteDomain(),
                    'tinymce' => true,
                    'article' => $article,
                ];
            } else {
                throw new HTTPException(404);
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['article_title'] && $_POST['article_content']) {
                    $article = new ArticleEntity();
                    $article->setTitle($_POST['article_title'])
                            ->setContent($_POST['article_content'])
                            ->setId($id);
                    $this->articleManager->update($article);
                    header('Location: ' . $this->url->build('admin'));
                    return;
                }

                empty($_POST['article_title'])
                    ? $data['form']['article_title'] = false
                    : $data['form']['article_title'] = $_POST['article_title'];

                empty($_POST['article_content'])
                    ? $data['form']['article_content'] = false
                    : $data['form']['article_content'] =$_POST['article_content'];
            }

            $render = new Render('Page', 'ArticleEditor');
            $render->process($data);
        }
    }

    public function deleteArticle(string $id): void
    {
        if ($this->authenticate() && $this->isValidId($id)) {
            $id = (int) $id;
            $article = $this->articleManager->getById($id);

            if ($article) {
                $this->articleManager->delete($id);
                header('Location: ' . $this->url->build('admin'));
            } else {
                throw new HTTPException(404);
                return;
            }
        }
    }
}
