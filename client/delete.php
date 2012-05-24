<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
//require Resty
require __DIR__ .'/Resty/Resty.php';

// create a rest client
$client = new Resty();

// enable debugging
$client->debug(true);

// set base URL of Rest server
$client->setBaseURL('http://localhost/slimtut/index.php');

if($_GET['id']){
	$resp = $client->delete('/book/'.$_GET['id']);
	echo $resp['body']->message;
}