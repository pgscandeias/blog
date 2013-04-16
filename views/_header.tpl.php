<!DOCTYPE html>
<html>
    <head>
        <title><?
            if (isset($title)) echo $title;
            elseif (isset($post->title)) echo $post->title;
            else echo "Pedro Gil Candeias";
        ?></title>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Roboto:300,500' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <header class='site-header'>
            <a href='/' class='site-title h'>
                <img class='avatar' src='/assets/avatar.jpg'>
                <span class='name'>
                    Pedro Gil Candeias
                </span>
            </a>

            <p class='intro'>
                web dev | huge nerd
            </p>

            <ul class='unstyled header-nav'>
                <li><a href='/'>ramblings</a></li>
                <? if (isset($pages)): foreach ($pages as $p): ?>
                    <li><a href='<?= $p->url() ?>'>
                        <?= strtolower($p->title) ?>
                    </a></li>
                <? endforeach; endif; ?>
            </ul>
        </header>

        <div class='container'>