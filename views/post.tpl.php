<? include '_header.tpl.php' ?>
<div class='container-wrapper'>

    <h2 class='post-title'><?= e($post->title) ?></h2>
    <p class='post-date'>posted <?= $post->created->format('Y-m-d') ?></p>

    <div class='post-html'>
        <?= $post->html ?>
    </div>

</div>
<? include '_footer.tpl.php' ?>