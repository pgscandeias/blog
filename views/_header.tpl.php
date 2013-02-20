<!DOCTYPE html>
<html>
    <head>
        <title>Pedro Gil Candeias</title>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <nav>
            <h1>
                <a href='/' class='logo'>
                    <img class='avatar' src='/assets/avatar.jpg'>
                    <span class='name'>
                        Pedro Gil Candeias
                    </span>
                </a>
            </h1>

            <p class='intro'>
                programmer and product designer
                specialized in web applications
            </p>

            <ul class='unstyled side-nav'>
                <li><a href='/'>ramblings</a></li>
                <? foreach ($posts as $p): ?>
                    <? if ($p->isPage): ?>
                        <li><a href='/post/<?= $p->slug ?>'><?= $p->title ?></a></li>
                    <? endif; ?>
                <? endforeach; ?>
            </ul>
        </nav>

        <div class='container'>