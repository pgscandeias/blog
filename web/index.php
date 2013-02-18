<?php
define("PWD", __DIR__);
require_once PWD . '/../models.php';
require_once PWD . '/../framework.php';
require_once PWD . '/../view.php';

$app = new App();
$view = new View(__DIR__ . '/../views/');

# Auth
# ...

# Public
$app->get('/', function() {
    echo "Home page";
});

$app->get('/post/:slug', function($slug) use ($view) {
    echo "Post page";
});


# Admin
$app->get('/admin/write', function() use ($view) {
    $view->render('admin/write.tpl.php', array('foo' => 'bar'));
});

$app->post('/admin/posts', function() {

});