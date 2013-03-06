<? include __DIR__ . '/../_header.tpl.php' ?>

<h2>
    Edit post
    <small>
        <a href='<?= $post->url() ?>'>[view]</a>
    </small>
</h2>

<form action='/admin/posts/<?= $post->_id ?>' method='post' class='form-post'>
    <? include '_form.tpl.php' ?>

    <div>
        <button type='submit'>Update</button>
        <a href='/admin/posts'>Cancel</a>
    </div>
</form>

<form action='/admin/posts/<?= $post->_id ?>/delete' method='post' class='form-delete'>
    <button type='submit'>Delete</button>
</form>

<? include __DIR__ . '/../_footer.tpl.php' ?>