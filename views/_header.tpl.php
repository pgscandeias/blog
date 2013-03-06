<!DOCTYPE html>
<html>
    <head>
        <title>Pedro Gil Candeias</title>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <link href='http://fonts.googleapis.com/css?family=Roboto:300,500' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <nav>
            <h1 class='logo logo-title'>
                <a href='/'>
                    <img class='avatar' src='/assets/avatar.jpg'>
                    <span class='name'>
                        Pedro Gil Candeias
                    </span>
                </a>
            </h1>

            <p class='intro'>
                web app developer
            </p>

            <ul class='unstyled side-nav'>
                <li><a href='/'>ramblings</a></li>
                <? if (isset($pages)): foreach ($pages as $p): ?>
                    <li><a href='<?= $p->url() ?>'>
                        <?= strtolower($p->title) ?>
                    </a></li>
                <? endforeach; endif; ?>
            </ul>
        </nav>

        <div class='container'>