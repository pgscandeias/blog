<? include __DIR__ . '/../_header.tpl.php' ?>

<h2>New post</h2>
<form action='/admin/posts' method='post' class='form-post'>
    <? include '_form.tpl.php' ?>

    <div>
        <button type='submit'>Post</button>
        <a href='/admin/posts'>Cancel</a>
    </div>
</form>

<? include __DIR__ . '/../_footer.tpl.php' ?>