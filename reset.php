<?php
include 'models.php';

// Reset users collection
$db->users->drop();

// Create the single admin user
$user = new User(array(
    'name' => 'Pedro Gil Candeias',
    'email' => 'pgscandeias@gmail.com',
    'loginToken' => '12345',
));
$user->save();