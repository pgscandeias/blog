<?php
# Core
session_start();
define("APP_ROOT", __DIR__ . "/../");
define("CACHE_DIR", __DIR__ . "/../cache");


#
# Serve cached content?
#
function cachePath($url = null) {
    $url = $url ?: $_SERVER['REQUEST_URI'];
    return CACHE_DIR . '/' . md5($url);
}
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
    $cached = @file_get_contents(cachePath());
    if ($cached) {
        echo $cached;
        die;
    }
}


#
# Bootstrap
#
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
    $link = 'http://'.$_SERVER['HTTP_HOST'].'/auth?t='.$token;

    $user = User::findOneBy(array('email' => $email));
    if ($user) {
        $emailBody = $view->render('auth/email.tpl.php', array('link' => $link));
        $user->loginToken = $token;
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
    $user->loginToken = null;
    $user->save();

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
$app->get('/', function() use ($app, $view) {
    $html = $view->render('index.tpl.php', array(
        'posts' => Post::findPosts(),
        'pages' => Post::findPages(),
    ));
    file_put_contents(cachePath(), $html);
    echo $html;

    return;
});

function renderPost($slug, $app, $view)
{
    $post = Post::findOneBy(array('slug' => (string) $slug));
    $app->ifEmpty404($post, $view);

    $html = $view->render('post.tpl.php', array(
        'pages' => Post::findPages(),
        'post' => $post,
    ));
    file_put_contents(cachePath(), $html);
    echo $html;

    return ;
}

$app->get('/post/:slug', function($slug) use ($app, $view) {
    echo renderPost($slug, $app, $view);
});

$app->get('/:slug', function($slug) use ($app, $view) {
    echo renderPost($slug, $app, $view);
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
        'posts' => Post::all(array(), array('created' => -1)),
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
    $post->html = Post::md2html($post->markdown);
    $post->save();

    $app->redirect('/admin/posts/'.$post->_id);
});

$app->get('/admin/posts/:id', function($id) use ($app, $view) {
    $app->firewall();

    $post = Post::find($id);
    echo $view->render('admin/posts/edit.tpl.php', array(
        'post' => $post,
    ));
});

$app->post('/admin/posts/:id', function($id) use ($app, $view) {
    $app->firewall();

    $post = Post::find($id);
    $fields = array('title', 'slug', 'markdown', 'isPublished', 'isPage', 'isPrivate');
    foreach ($fields as $field) {
        $post->{$field} = $app->request->post($field);
    }
    $post->html = Post::md2html($post->markdown);
    $post->save();

    $app->redirect('/admin/posts');
});

$app->post('/admin/posts/:id/delete', function($id) use($app) {
    $app->firewall();

    $post = Post::find($id);
    $post->delete();

    $app->redirect('/admin/posts');
});


#
# 404
#
echo $view->render('404.tpl.php');
die;
