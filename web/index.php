<?php
# Core
session_start();
define("PWD", __DIR__);
require_once PWD . '/../models.php';
require_once PWD . '/../framework.php';
require_once PWD . '/../view.php';

# Composer
require_once PWD . '/../vendor/autoload.php';

$app = new App();
$view = new View(__DIR__ . '/../views/');


#
# Auth
#
$app->get('/login', function() use ($view) {
    echo $view->render('auth/login.tpl.php');
});

$app->post('/login', function() use ($app, $view) {
    $email = $app->request->post('email');
    $token = User::generateLoginToken($email);
    $link = 'http://blog/auth?t='.$token;

    $emailBody = $view->render('auth/email.tpl.php', array('link' => $link));

    if ($app->mail->send($email, 'Access link', $emailBody)) {
        $app->session->set('wasLoginMailSent', true);
        $app->redirect('/login/sent');
    } else {
        echo $view->render('auth/email_error.tpl.php');
    }
});

$app->get('/login/sent', function() use ($app, $view) {
    if ($app->session->get('wasLoginMailSent')) {
        echo $view->render('auth/email_success.tpl.php');

    } else { $app->redirect('/'); }
});

$app->get('/auth?*', function() use ($app) {
    $token = $app->request->get('t');
    var_dump($token);
});

$app->get('/logout', function() use ($view) {
    echo "Ending session";
});


#
# Public
#
$app->get('/', function() {
    echo "Home page";
});

$app->get('/post/:slug', function($slug) use ($view) {
    echo "Post page";
});


#
# Admin
#
$app->get('/admin/write', function() use ($view) {
    echo $view->render('admin/write.tpl.php', array('foo' => 'bar'));
});

$app->post('/admin/posts', function() {

});
