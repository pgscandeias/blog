<!DOCTYPE html>
<html>
    <head>
        <title>Posts | Admin</title>

        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <nav>
            <h1>Pedro Gil Candeias</h1>
        </nav>

        <div class='container'>
            <h2>
                All posts
                <small>
                    <a href='/admin/write'>write new</a>
                </small>
            </h2>
                
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