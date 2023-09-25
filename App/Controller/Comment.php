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

    public function addComment(?array $parameters)
    {
        $fkArticleId = $parameters['id'];

        if ($this->isValidId($fkArticleId)) {
            $fkArticleId = (int) $fkArticleId;

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!$this->articleManager->getById($fkArticleId)) {
                    throw new HTTPError(404);
                    return;
                }

                if ($_GET['comment_name'] && $_GET['comment_email'] && $_GET['comment_content']) {
                    $comment = new CommentEntity();
                    $comment->setFkArticleId($fkArticleId)
                            ->setName($_GET['comment_name'])
                            ->setEmail($_GET['comment_email'])
                            ->setContent($_GET['comment_content']);
                    $this->commentManager->create($comment);
                    header('Location: ' . $this->url->build('article', $fkArticleId));
                    return;
                }

                unset($parameters['id'], $parameters['action']);

                if (empty($_GET['comment_name'])) {
                    unset($parameters['comment_name']);
                }

                if (empty($_GET['comment_email'])) {
                    unset($parameters['comment_email']);
                }

                if (empty($_GET['comment_content'])) {
                    unset($parameters['comment_content']);
                }

                header('Location: ' . $this->url->build('article', $fkArticleId, $parameters));
                return;
            } else {
                throw new HTTPException(405);
                exit;
            }
        }
    }
}
