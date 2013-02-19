<!DOCTYPE html>
<html>
    <head>
        <title>Write post</title>

        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <body>
        <nav>
            <h1>Pedro Gil Candeias</h1>
        </nav>

        <div class='container'>
            <h2>Edit post</h2>
            <form action='/admin/posts/<?= $post->slug ?>' method='post' class='form-post'>
                <label>Title</label>
                <input type='text' name='title' value='<?= $post->title ?>' required>

                <label>Slug</label>
                <input type='text' name='slug' value='<?= $post->slug ?>'required>

                <label>Post</label>
                <textarea name='markdown' required><?= $post->markdown ?></textarea>

                <label>
                    <input type='checkbox' name='isPublished' value='1'
                        <? if ($post->isPublished): ?>checked<? endif ?>
                        >
                    Published
                </label>

                <div>
                    <button type='submit'>Update</button>
                    <a href='/admin/posts'>Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>