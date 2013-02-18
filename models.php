<?php
$mongo = new MongoClient();
$db = $mongo->selectDB('blog');


class User
{
    public static function generateLoginToken($email)
    {
        // Yeah this is wrong. Just experimenting.
        return sha1(mt_rand());
    }
}