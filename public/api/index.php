<?php
use Altan\YesimTest\ApiApp;

require_once "bootstrap.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uri  = explode("/", trim($uri, "/"));
while(array_shift($uri) != 'api');

$app = new ApiApp();
$app->initDatabase(PDO_DSN, PDO_USERNAME, PDO_PASSWORD, true);

$auth = $app->getAuth();

if(!$auth->check()) {
    $view = $app->getView("403", ["error" => "Authentication required"]);
    $view->writeError();
    exit();
}

try {
    $controller = $app->getController($uri[0]);
    $controller->execute($uri, $_SERVER["REQUEST_METHOD"]);
    $view = $app->getView($controller->getStatus(), $controller->getData());
    $view->write();
} catch(Exception $e) {
    $view = $app->getView("500", ["error" => $e->getMessage()]);
    $view->writeError();
}
