<?php
//require Resty
require __DIR__ .'/Resty/Resty.php';

// create a rest client
$client = new Resty();

// enable debugging
$client->debug(true);

// set base URL of Rest server
$client->setBaseURL('http://localhost/slimtut/index.php');

// post book 
if($_POST){

	$book = array(
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'summary' => $_POST['summary'],
    );
    $result = $client->post('/book',$book);
    print_r($result);
}
?>
<form action='' method='post'>
    Title : <input type='text' name='title' /> </br>
    Author : <input type='text' name='author' /> </br>
    Summary : <textarea name='summary' /></textarea> </ br>
    <input type='submit' name='submit' value='Submit' >
</form>