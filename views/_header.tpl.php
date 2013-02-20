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
            <h1 class='logo'>
                <a href='/'>
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
                <? foreach ($pages as $p): ?>
                    <li><a href='/post/<?= $p->slug ?>'>
                        <?= strtolower($p->title) ?>
                    </a></li>
                <? endforeach; ?>
            </ul>
        </nav>

        <div class='container'>