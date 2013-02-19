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
                <? include 'post_form.tpl.php' ?>

                <div>
                    <button type='submit'>Update</button>
                    <a href='/admin/posts'>Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>