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
                <a href='/'>
                    Pedro Gil Candeias
                </a>
            </h1>

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