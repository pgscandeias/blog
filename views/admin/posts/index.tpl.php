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
        <a href='/admin/posts/<?= $p->_id ?>' class='<?
            if (!$p->isPublished) { echo 'unPublished '; }
        ?>'>
            <span class='date'>
                <?= $p->created->format('Y-m-d') ?>
            </span>
            <span class='title'>
                <? if ($p->isPage): ?>
                    <span class='tag'>page</span>
                <? endif ?>
                <? if ($p->isPrivate): ?>
                    <span class='tag tag-private'>private</span>
                <? endif ?>
                <?= $p->title ?>
            </span>
        </a>
    </li>
    <? endforeach ?>
</ul>

<? include __DIR__ . '/../_footer.tpl.php' ?>