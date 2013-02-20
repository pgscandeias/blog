<?php
define("APP_ROOT", __DIR__);

# Composer
require_once APP_ROOT . '/vendor/autoload.php';

# Framework
require_once APP_ROOT . '/framework.php';
require_once APP_ROOT . '/view.php';

# Business
require_once APP_ROOT . '/models.php';

# Init
$app = new App();
$view = new View(APP_ROOT . '/views/');

# Db connection
$dsn = 'mongodb://['.$app->config->get('db_username').':'.$app->config->get('db_password').']';
$dsn.= '@'.$app->config->get('db_host').':'.$app->config->get('db_port');
$dsn.= '/'.$app->config->get('db_name');
$mongo = new MongoClient();
Model::$db = $mongo->selectDB('blog');

