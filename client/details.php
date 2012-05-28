<?php
//require Resty
require __DIR__ .'/Resty/Resty.php';

// create a rest client
$client = new Resty();

// enable debugging
$client->debug(true);

// set base URL of Rest server
$client->setBaseURL('http://localhost/slimtut/');

if(isset($_GET['id'])){
    $book = $client->get('book/' . trim($_GET['id']));
    print_r($book['body']);
}