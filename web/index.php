<?php
# Core
session_start();
require_once __DIR__ . '/../bootstrap.php';


#
# Auth
#
$app->get('/login', function() use ($view) {
    echo $view->render('auth/login.tpl.php');
});

$app->post('/login', function() use ($app, $view) {
    $email = (string) $app->request->post('email');
    $token = User::generateLoginToken($email);
    $link = 'http://blog/auth?t='.$token;

    $user = User::findOneBy(array('email' => $email));
    if ($user) {
        $emailBody = $view->render('auth/email.tpl.php', array('link' => $link));
        #$user->loginToken = $token;
        $user->loginToken = "12345";
        $user->save();

        try {
            $app->mail->send($email, 'Access link', $emailBody);
            $app->session->set('wasLoginMailSent', true);
            $app->redirect('/login/sent');
        } catch (Exception $e) {
            echo $view->render('auth/email_error.tpl.php');
        }

    } else {
        $app->redirect('/login');
    }
});

$app->get('/login/sent', function() use ($app, $view) {
    if ($app->session->get('wasLoginMailSent')) {
        $app->session->remove('wasLoginMailSent');
        echo $view->render('auth/email_success.tpl.php');

    } else { $app->redirect('/'); }
});

$app->get('/auth?*', function() use ($app) {
    $user = false;
    $loginToken = (string) trim($app->request->get('t'));
    if ($loginToken) {
        $user = User::findOneBy(array('loginToken' => $loginToken));
    }
    if (!$user) { $app->redirect('/'); }

    // Burn token
    // $user->loginToken = null;
    // $user->save();

    // Generate Auth Cookie token
    $user->renewAuthCookie($app->cookie)->save();

    // Go to admin entry point
    $app->redirect('/admin/posts');
});

$app->get('/logout', function() use ($app) {
    session_destroy();
    $app->redirect('/');
});


#
# Public
#
$app->get('/', function() use ($view) {
    echo $view->render('index.tpl.php', array(
        'posts' => Post::all(array('created' => -1)),
    ));
});

$app->get('/post/:slug', function($slug) use ($view) {
    echo $view->render('post.tpl.php', array(
        'posts' => Post::all(),
        'post' => Post::findOneBy(array('slug' => (string) $slug)),
    ));
});


#
# Admin
#
$app->get('/admin', function() use ($app) {
    $app->redirect('/admin/posts');
});

$app->get('/admin/posts', function() use ($app, $view) {
    $app->firewall();

    echo $view->render('admin/posts/index.tpl.php', array(
        'posts' => Post::all(array('created' => -1)),
    ));
});

$app->get('/admin/write', function() use ($app, $view) {
    $app->firewall();

    echo $view->render('admin/posts/write.tpl.php', array(
        'post' => new Post,
    ));
});

$app->post('/admin/posts', function() use ($app) {
    $app->firewall();

    $post = new Post($_POST);
    $post->save();

    $app->redirect('/admin/posts/'.$post->slug);
});

$app->get('/admin/posts/:slug', function($slug) use ($app, $view) {
    $app->firewall();

    $post = Post::findOneBy(array('slug' => $slug));
    echo $view->render('admin/posts/edit.tpl.php', array(
        'post' => $post,
    ));
});

$app->post('/admin/posts/:slug', function($slug) use ($app, $view) {
    $app->firewall();

    $post = Post::findOneBy(array('slug' => $slug));
    $fields = array('title', 'slug', 'markdown', 'isPublished', 'isPage');
    foreach ($fields as $field) {
        $post->{$field} = $app->request->post($field);
    }
    $post->save();

    $app->redirect('/admin/posts');
});