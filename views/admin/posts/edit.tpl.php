<? include __DIR__ . '/../_header.tpl.php' ?>

<h2>Edit post</h2>
<form action='/admin/posts/<?= $post->slug ?>' method='post' class='form-post'>
    <? include '_form.tpl.php' ?>

    <div>
        <button type='submit'>Update</button>
        <a href='/admin/posts'>Cancel</a>
    </div>
</form>


<? include __DIR__ . '/../_footer.tpl.php' ?>