<?php
//require Resty
require __DIR__ .'/Resty/Resty.php';

// create a rest client
$client = new Resty();

// enable debugging
$client->debug(true);

// set base URL of Rest server
$client->setBaseURL('http://localhost/slimtut/index.php');

// get books
$resp = $client->get('/books');
print_r($resp['body']);