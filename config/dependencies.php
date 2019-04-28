<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

$container = $app->getContainer();

$container['config'] = function($c) {
    $environment = in_array(getenv('PROVISION_CONTEXT'), ['development', 'production', 'staging']) ? getenv('PROVISION_CONTEXT') : 'development';
    return Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.' . $environment . '.yml'));
};

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer(realpath(realpath(__DIR__). '/../src/Vesica/View'));
};

$container['helper'] = function($c) {
    $config = $c->config; 
    $helper = new \stdClass();
    $helper->logger = new Logger('MicroService');
    $helper->logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());
    $helper->config= $config;
    return $helper;
};

$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

$container['doctrine'] = function($c) {
    $config = $c->config; 
    $doctrine = new \stdClass();
    $paths = array(realpath(__DIR__) . '/../src');
    $isDevMode = $config['connections']['database']['doctrine']['mode'] == 'dev' ? true : false;
    $docConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
    $docParams = [
        'driver' => $config['connections']['database']['doctrine']['driver'],
        'user' => $config['connections']['database']['doctrine']['username'],
        'password' => $config['connections']['database']['doctrine']['password'],
        'dbname' => $config['connections']['database']['doctrine']['dbname'],
        'host' => $config['connections']['database']['doctrine']['host'],
        'port' => $config['connections']['database']['doctrine']['port']
    ];

    $doctrine->entityManager = EntityManager::create($docParams, $docConfig);
    
    return $doctrine;

};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $r = [
        'code' => 404,
        'status' => 'Not Found',
        'data' => 'Invalid endpoint or resource.'
        ];
        $resp = json_encode($r);

        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write($resp);
    };
};

$container['errorHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $r = [
        'code' => 500,
        'status' => 'Internal Server Error',
        'data' => 'Something went wrong when the server tried to process this request. Sorry!'
        ];

        $resp = json_encode($r);

        return $c['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write($resp);
    };
};
