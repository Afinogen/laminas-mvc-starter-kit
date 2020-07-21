<?php
declare(strict_types=1);

$dirName = dirname(__DIR__);
chdir($dirName);
require 'vendor/autoload.php';

define('ROOT_PATH', $dirName.'/');

use Laminas\Stdlib\ArrayUtils;
use Symfony\Component\Console\Application;


$application = new Application('Application console');

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}

// Run the application!
$app = Laminas\Mvc\Application::init($appConfig);
$container = $app->getServiceManager();

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $application->add($container->get($command));
}

$application->run();