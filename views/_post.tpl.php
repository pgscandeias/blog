<div class='post'>

    <h2 class='post-title'>
        <a href='<?= $post->url() ?>'>
            <?= e($post->title) ?>
        </a>
    </h2>
    <p class='post-date'>posted <?= $post->created->format('Y-m-d') ?></p>

    <article class='post-html'>
        <?= $post->html ?>
    </article>

</div>