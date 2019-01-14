<?php 

declare(strict_types = 1);

$injector = new \Auryn\Injector;

$injector->alias('Request', 'Symfony\Component\HttpFoundation\Request');
$injector->share('Symfony\Component\HttpFoundation\Request');
$injector->define('Symfony\Component\HttpFoundation\Request', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->alias('Response', 'Symfony\Component\HttpFoundation\Response');
$injector->share('Symfony\Component\HttpFoundation\Response');

$injector->define('VirtuaGym\MyPDO', [
    ':dsn'      => "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME').";", 
    ':username' => getenv('DB_USER'), 
    ':password' => getenv('DB_PASS')
]);

$injector->alias('VirtuaGym\Template\Renderer', 'VirtuaGym\Template\TwigRenderer');

$injector->define('Mustache_Engine', [
    ':options' => [
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
            'extension' => '.html',
        ]),
    ],
]);

$injector->delegate('Twig_Environment', function () use ($injector) {
    $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
    $twig = new Twig_Environment($loader);
    return $twig;
});

$injector->alias('VirtuaGym\Template\FrontendRenderer', 'VirtuaGym\Template\FrontendTwigRenderer');

$injector->alias('VirtuaGym\Menu\MenuReader', 'VirtuaGym\Menu\ArrayMenuReader');
$injector->share('VirtuaGym\Menu\ArrayMenuReader');

return $injector;
