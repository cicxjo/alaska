<?php
// phpcs:ignoreFile

declare(strict_types = 1);

require_once(__DIR__ . '/Autoloader.php');
App\Autoloader::register();

$router = new App\Model\Router();
$router->addRoute('/', ['App\Controller\Article', 'listArticles'])
       ->addRoute('/article/:id', ['App\Controller\Article', 'showArticle'])
       ->addRoute('/admin', ['App\Controller\Administration', 'showPanel'])
       ->addRoute('/admin/ajouter/article', ['App\Controller\Administration', 'addArticle']);

try {
    $router->run();
} catch (App\Model\Exception\HTTPException $e) {
    App\Controller\HTTPError::send($e->getCode());
}
