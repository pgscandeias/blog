<? include __DIR__ . '/../_header.tpl.php' ?>

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

<? include __DIR__ . '/../_footer.tpl.php' ?>