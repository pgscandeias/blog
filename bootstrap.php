<?php
define("APP_ROOT", __DIR__);

# Configuration
require_once 'config.php';
Config::_init(__DIR__ . '/config.ini');

# Composer
require_once APP_ROOT . '/vendor/autoload.php';

# Framework
require_once APP_ROOT . '/framework.php';
require_once APP_ROOT . '/view.php';

# Business
require_once APP_ROOT . '/models.php';

# Db connection
$dsn = 'mongodb://'.Config::get('db_username').':'.Config::get('db_password').'';
$dsn.= '@'.Config::get('db_host').':'.Config::get('db_port');
$dsn.= '/'.Config::get('db_name');

try { $mongo = new MongoClient($dsn); }
catch (Exception $e) {
    echo "Database error";
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') { # XXX: Fugly. What about VMs?
        echo "<br>".$dsn;
        var_dump($e->getMessage());
    }
    die;
}
Model::$db = $mongo->selectDB(Config::get('db_name'));

# Init
$app = new App();
$view = new View(APP_ROOT . '/views/');
