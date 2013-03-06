<div class='post'>

    <h1 class='post-title h'>
        <a href='<?= $post->url() ?>'>
            <?= e($post->title) ?>
        </a>
    </h1>
    <p class='post-date'>posted <?= $post->created->format('Y-m-d') ?></p>

    <article class='post-html'>
        <?= $post->html ?>
    </article>

</div>