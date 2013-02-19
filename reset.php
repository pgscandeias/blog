<?php
include 'bootstrap.php';

// Reset users
Model::$db->users->drop();
$user = new User(array(
    'name' => 'Pedro Gil Candeias',
    'email' => 'pgscandeias@gmail.com',
    'loginToken' => '12345',
));
$user->save();


// Reset posts
Post::$db->posts->drop();
$posterousJsonFile = 'posterous_2013-02-19.json';
$posterous = json_decode(file_get_contents($posterousJsonFile));
foreach ($posterous as $p) {
    $post = new Post(array(
        'created' => new DateTime($p->display_date),
        'title' => $p->title,
        'html' => utf8_encode(strip_tags(html_entity_decode($p->body_full))),
        'slug' => $p->slug,
        'isPublished' => !$p->draft,
        'isPrivate' => $p->is_private,
    ));
    $post->save();
}