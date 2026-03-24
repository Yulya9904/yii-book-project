#!/usr/bin/env php
<?php


use Dotenv\Dotenv;
use function PHPUnit\Framework\throwException;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/src/config/console.php';
$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
