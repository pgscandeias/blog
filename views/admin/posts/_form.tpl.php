<label>Title</label>
<input type='text' name='title' value='<?= $post->title ?>' required>

<label>Slug</label>
<input type='text' name='slug' value='<?= $post->slug ?>'required>

<label>Post</label>
<textarea name='markdown' required><?= $post->markdown ?: $post->html ?></textarea>

<label>
    <input type='checkbox' name='isPublished' value='1'
        <? if ($post->isPublished): ?>checked<? endif ?>
    >
    Published
</label>

<label>
    <input type='checkbox' name='isPrivate' value='1'
        <? if ($post->isPrivate): ?>checked<? endif ?>
    >
    Private
</label>

<label>
    <input type='checkbox' name='isPage' value='1'
        <? if ($post->isPage): ?>checked<? endif ?>
    >
    Page (appears in side nav)
</label>