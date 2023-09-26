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

    private function isNameValid(string $name) : bool
    {
        return strlen($name) <= 60;
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
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

                if ($this->isNameValid($_POST['comment_name'])
                    && $this->isValidEmail($_POST['comment_email'])
                    && $_POST['comment_content']) {
                    $comment = new CommentEntity();
                    $comment->setFkArticleId($fkArticleId)
                            ->setName($_POST['comment_name'])
                            ->setEmail($_POST['comment_email'])
                            ->setContent($_POST['comment_content']);
                    $this->commentManager->create($comment);
                    header('Location: ' . $this->url->build('article', $fkArticleId));
                    return;
                }

                $getParameters = [];

                empty($_POST['comment_name'])
                    ? $getParameters['comment_name'] = null
                    : $getParameters['comment_name'] = $_POST['comment_name'];

                $this->isNameValid($_POST['comment_name'])
                    ? $getParameters['comment_name_valid'] = 1
                    : $getParameters['comment_name_valid'] = 0;

                empty($_POST['comment_email'])
                    ? $getParameters['comment_email'] = null
                    : $getParameters['comment_email'] = $_POST['comment_email'];

                $this->isValidEmail($_POST['comment_email'])
                    ? $getParameters['comment_email_valid'] = 1
                    : $getParameters['comment_email_valid'] = 0;

                empty($_POST['comment_content'])
                    ? $getParameters['comment_content'] = null
                    : $getParameters['comment_content'] = $_POST['comment_content'];

                header('Location: ' . $this->url->build('article', $fkArticleId, $getParameters));
                return;
            } else {
                throw new HTTPException(405);
                return;
            }
        }
    }
}
