<?php
require_once(realpath(__DIR__) . '/environment.php');

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Yaml\Yaml;

$paths = array(realpath(__DIR__) . '/../src');
$config = Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.' . $provisionContext . '.yml'));
$isDevMode = $config['connections']['database']['doctrine']['mode'] == 'dev' ? true : false;
$dbConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$dbParams = [
    'driver' => $config['connections']['database']['doctrine']['driver'],
    'user' => $config['connections']['database']['doctrine']['username'],
    'password' => $config['connections']['database']['doctrine']['password'],
    'dbname' => $config['connections']['database']['doctrine']['dbname'],
    'host' => $config['connections']['database']['doctrine']['host'],
    'port' => $config['connections']['database']['doctrine']['port']
];

$entityManager = EntityManager::create($dbParams, $dbConfig);

return ConsoleRunner::createHelperSet($entityManager);
