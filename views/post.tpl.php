<? include '_header.tpl.php' ?>
<div class='container-wrapper'>

    <h2><?= e($post->title) ?></h2>
    <p class='date'><?= $post->created->format('Y-m-d') ?></p>

    <div class='post-html'>
        <?= $post->html ?>
    </div>

</div>
<? include '_footer.tpl.php' ?>