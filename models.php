<?php
$mongo = new MongoClient();
$db = $mongo->selectDB('blog');


class Model
{
    public $_id;
}

class Post extends Model
{
    public $title;
    public $created;
    public $updated;
    public $content;
    public $tags = array();
    public $isPublished;
}