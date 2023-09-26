<?php
// phpcs:ignoreFile

declare(strict_types = 1);

require_once(__DIR__ . '/Autoloader.php');
App\Autoloader::register();

$router = new App\Model\Router();
$router->addRoute('/', ['App\Controller\Article', 'listArticles'])
       ->addRoute('/article', ['App\Controller\Article', 'showArticle'])
       ->addRoute('/commenter', ['App\Controller\Comment', 'addComment'])
       ->addRoute('/signaler', ['App\Controller\Comment', 'reportComment'])
       ->addRoute('/admin', ['App\Controller\Administration', 'showPanel'])
       ->addRoute('/admin/ajouter/article', ['App\Controller\Administration', 'addArticle'])
       ->addRoute('/admin/supprimer/article', ['App\Controller\Administration', 'deleteArticle'])
       ->addRoute('/admin/modifier/article', ['App\Controller\Administration', 'updateArticle'])
       ->addRoute('/admin/supprimer/commentaire', ['App\Controller\Administration', 'deleteComment'])
       ;

try {
    $router->run();
} catch (App\Model\Exception\HTTPException $e) {
    $httpError = new App\Controller\HTTPError($e->getCode());
    $httpError->send($e->getCode());
}
