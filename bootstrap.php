<?php
define("APP_ROOT", __DIR__);

# Composer
require_once APP_ROOT . '/vendor/autoload.php';

# Framework
require_once APP_ROOT . '/framework.php';
require_once APP_ROOT . '/view.php';

# Business
require_once APP_ROOT . '/models.php';

# Db
$mongo = new MongoClient();
Model::$db = $mongo->selectDB('blog');


# Init
$app = new App();
$view = new View(APP_ROOT . '/views/');
