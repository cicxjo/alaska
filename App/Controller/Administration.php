<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Entity\Article as ArticleEntity;
use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Manager\Comment as CommentManager;
use App\Model\Manager\User as UserManager;
use App\Model\Render;

class Administration extends AbstractController
{
    private ArticleManager $articleManager;
    private UserManager $userManager;
    private CommentManager $commentManager;

    public function __construct()
    {
        parent::__construct();

        $this->articleManager = new ArticleManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
    }

    public function authenticate(): bool
    {
        session_start();

        $data = [
            'title' => 'Connectez-vous',
            'url' => $this->config->getWebsiteUrl(),
            'domain' => $this->config->getWebsiteDomain(),
        ];

        if (isset($_SESSION['authenticated'])) {
            return true;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['auth_username']) && isset($_POST['auth_password'])) {
                $user = $this->userManager->getByUsername($_POST['auth_username']);

                if ($user) {
                    if ($_POST['auth_username'] === $user->getUsername()
                        && hash('sha256', $_POST['auth_password']) === $user->getPassword()) {
                            $_SESSION['authenticated'] = true;
                            header('Location: ' . $this->url->build('admin'));
                            return true;
                    }
                }
            }

            empty($_POST['auth_username'])
                ? $data['form']['auth_username'] = false
                : $data['form']['auth_username'] = $_POST['auth_username'];

            empty($_POST['auth_password'])
                ? $data['form']['auth_password'] = false
                : $data['form']['auth_password'] = $_POST['auth_password'];
        }

        $render = new Render('Page', 'AuthenticationPanel');
        $render->process($data);
        return false;
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

    public function showArticle(?array $parameters): void
    {
        $id = $parameters['id'];

        if ($this->authenticate() && $this->isValidId($id)) {
            $id = (int) $id;

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $article = $this->articleManager->getById((int) $id);

                if ($article) {
                    $render = new Render('Page', 'AdminShowArticle');
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

    public function updateArticle(?array $parameters): void
    {
        $id = $parameters['id'] ?? null;

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

    public function deleteArticle(?array $parameters): void
    {
        $id = $parameters['id'] ?? null;

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

    public function deleteComment(?array $parameters): void
    {
        $id = $parameters['id'];

        if ($this->authenticate() && $this->isValidId($id)) {
            $id = (int) $id;
            $action = $parameters['action'];

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $comment = $this->commentManager->getById($id);

                if ($comment) {
                    if ($action === 'admin/voir/article/supprimer/commentaire') {
                        $url = $this->url->build('admin/voir/article', $comment->getFkArticleId());
                    } else {
                        $url = $this->url->build('admin');
                    }
                    $url .= '#commentaires';
                    $this->commentManager->delete($id);
                    header('Location: ' . $url);
                    return;
                } else {
                    throw new HTTPException(404);
                }
            } else {
                throw new HTTPException(405);
                return;
            }
        }
    }

    public function approveComment(?array $parameters): void
    {
        $id = $parameters['id'];
        $action = $parameters['action'];

        if ($this->authenticate() && $this->isValidId($id)) {
            $id = (int) $id;

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $comment = $this->commentManager->getById($id);

                if ($comment->getIsFlagged()) {
                    $this->commentManager->updateReport($id, false);
                    if ($action === 'admin/voir/article/approuver/commentaire') {
                        $url = $this->url->build('admin/voir/article', $comment->getFkArticleId());
                        $url .= '#commentaire-' . $comment->getId();
                    } else {
                        $url = $this->url->build('admin');
                        $url .= '#commentaires';
                    }
                    header('Location: ' . $url);
                    return;
                } else {
                    throw new HTTPException(404);
                }
            } else {
                throw new HTTPException(405);
                return;
            }
        }
    }
}
