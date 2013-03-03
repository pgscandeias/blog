<? include '_header.tpl.php' ?>

<ul class='unstyled posts'>
    <? foreach ($posts as $p): ?>
    <li>
        <a href='/<?= $p->slug ?>'>
            <span class='date'>
                <?= $p->created->format('Y-m-d') ?>
            </span>
            <span class='title'><?= $p->title ?></span>
        </a>
    </li>
    <? endforeach ?>
</ul>

<? include '_footer.tpl.php' ?>