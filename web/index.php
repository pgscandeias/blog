<?php
# Core
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

    $emailBody = $view->render('auth/email.tpl.php', array(
        'link' => $link,
    ));

    $transport = Swift_SmtpTransport::newInstance()
                ->setHost($app->config->get('smtp_host'))
                ->setPort($app->config->get('smtp_port'))
                ->setEncryption($app->config->get('smtp_encryption'))
                ->setUsername($app->config->get('smtp_username'))
                ->setPassword($app->config->get('smtp_password'))
    ;
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance()
                ->setSubject('Access link')
                ->setFrom(array($app->config->get('address') => $app->config->get('name')))
                ->setTo(array($email))
                ->setBody($emailBody)
    ;
    if ($mailer->send($message)) {
        echo "Sent";
    } else {
        echo "Mail fail";
    }
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
