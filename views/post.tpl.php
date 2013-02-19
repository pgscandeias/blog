<? include '_header.tpl.php' ?>

<h2><?= e($post->title) ?></h2>
<p class='date'><?= $post->created->format('Y-m-d') ?></p>

<div class='post-html'>
    <?= $post->html ?>
</div>

<? include '_footer.tpl.php' ?>