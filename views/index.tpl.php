<!DOCTYPE html>
<html>
    <head>
        <title>Pedro Gil Candeias</title>

        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <nav>
            <h1>Pedro Gil Candeias</h1>

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
            <ul class='posts'>
                <? foreach ($posts as $p): ?>
                <li>
                    <a href='/admin/posts/<?= $p->slug ?>'>
                        <span class='date'>
                            <?= $p->created->format('Y-m-d') ?>
                        </span>
                        <span class='title'><?= $p->title ?></span>
                    </a>
                </li>
                <? endforeach ?>
            </ul>
        </div>
    </body>
</html>