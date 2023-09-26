<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Entity\Comment as CommentEntity;
use App\Model\Exception\HTTPException;
use App\Model\Manager\Article as ArticleManager;
use App\Model\Manager\Comment as CommentManager;
use App\Model\PrintAndDie;

class Comment extends AbstractController
{
    private CommentEntity $commentEntity;
    private CommentManager $commentManager;
    private ArticleManager $articleManager;

    public function __construct()
    {
        parent::__construct();

        $this->commentManager = new CommentManager();
        $this->articleManager = new ArticleManager();
    }

    private function isValidName(string $name)
    {
        if (strlen($name) <= 60) {
            return true;
        }

        return false;
    }

    private function isValidEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    private function isValidContent(string $content)
    {
        if (strlen($content) <= 1500) {
            return true;
        }

        return false;
    }

    public function addComment(?array $parameters)
    {
        $fkArticleId = $parameters['id'];

        if ($this->isValidId($fkArticleId)) {
            $fkArticleId = (int) $fkArticleId;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!$this->articleManager->getById($fkArticleId)) {
                    throw new HTTPError(404);
                    return;
                }

                $parameters = [];

                if (isset($_POST['comment_name'])
                    && !empty($_POST['comment_name']
                    && !ctype_space($_POST['comment_name']))) {
                    if (!$this->isValidName($_POST['comment_name'])) {
                        $parameters['comment_name_invalid'] = '1';
                    }
                } else {
                    $parameters['comment_name_empty'] = '1';
                }

                if (isset($_POST['comment_email'])
                    && !empty($_POST['comment_email']
                    && !ctype_space($_POST['comment_email']))) {
                    if (!$this->isValidEmail($_POST['comment_email'])) {
                        $parameters['comment_email_invalid'] = '1';
                    }
                } else {
                    $parameters['comment_email_empty'] = '1';
                }

                if (isset($_POST['comment_content'])
                    && !empty($_POST['comment_content']
                    && !ctype_space($_POST['comment_content']))) {
                    if (!$this->isValidContent($_POST['comment_content'])) {
                        $parameters['comment_content_invalid'] = '1';
                    }
                } else {
                    $parameters['comment_content_empty'] = '1';
                }

                if (empty($parameters)) {
                    $comment = new CommentEntity();
                    $comment->setFkArticleId($fkArticleId)
                            ->setName($_POST['comment_name'])
                            ->setEmail($_POST['comment_email'])
                            ->setContent($_POST['comment_content']);
                    $this->commentManager->create($comment);
                }

                header('Location: ' . $this->url->build('article', $fkArticleId, $parameters) . '#commenter');
                return;
            } else {
                throw new HTTPException(405);
                return;
            }
        }
    }
}
