<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

require_once dirname(__DIR__).'/vendor/autoload.php';

$container = new ContainerBuilder();
$loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));
$loader->load('services.php');
$container->compile();

return $container;