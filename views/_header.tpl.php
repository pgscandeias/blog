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
                    <img class='gravatar' src='/img/pedro_gil_candeias.png'>
                    <span class='name'>
                        Pedro Gil Candeias
                    </span>
                </a>
            </h1>

            <p class='tagline'>
                Speaks Computer
            </p>

            <ul class='unstyled side-nav'>
                <li><a href='/'>Essays</a></li>
                <? foreach ($posts as $p): ?>
                    <? if ($p->isPage): ?>
                        <li><a href='/post/<?= $p->slug ?>'><?= $p->title ?></a></li>
                    <? endif; ?>
                <? endforeach; ?>
            </ul>
        </nav>

        <div class='container'>