<?php
// phpcs:ignoreFile

declare(strict_types = 1);

require_once(__DIR__ . '/Autoloader.php');
App\Autoloader::register();

$router = new App\Model\Router();
$router->addRoute('/', null, ['App\Controller\Article', 'listArticles'])
       ->addRoute('/article', 'id', ['App\Controller\Article', 'showArticle'])
       ->addRoute('/admin', null, ['App\Controller\Administration', 'showPanel'])
       ->addRoute('/admin/ajouter/article', null, ['App\Controller\Administration', 'addArticle'])
       ->addRoute('/admin/supprimer/article', 'id', ['App\Controller\Administration', 'deleteArticle'])
       ->addRoute('/admin/modifier/article', 'id', ['App\Controller\Administration', 'updateArticle']);

try {
    $router->run();
} catch (App\Model\Exception\HTTPException $e) {
    $httpError = new App\Controller\HTTPError($e->getCode());
    $httpError->send($e->getCode());
}
