<?php
/**
 * Step 1: Require the Slim PHP 5 Framework
 *
 * If using the default file layout, the `Slim/` directory
 * will already be on your include path. If you move the `Slim/`
 * directory elsewhere, ensure that it is added to your include path
 * or update this file path as needed.
 */
require 'Slim/Slim.php';

include "NotORM.php";
$dsn = 'mysql:dbname=library;host=127.0.0.1';
$pdo = new PDO($dsn,'root','root');
$db  = new NotORM($pdo);

//$app = new Slim();

$app = new Slim(
        array(
            'mode' => 'development',
            'templates.path' => './templates'
            )
    );

$app->get('/', function(){
    echo "Hello Slim World";
});


$app->post('/book',function() use($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $book = array(
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'summary' => $_POST['summary'],
        );
    $result = $db->books->insert($book);
    echo json_encode(array('id' => $result['id']));
});



$app->get('/books',function() use ($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $users = array();
    foreach ($db->books as $user) {
        $users[]  = array(
                'id' => $user['id'],
                'title' => $user['title'],
                'author' => $user['author'],
                'summary' => $user['summary']
            );
    }
    echo json_encode($users);

});

$app->delete('/book/:id',function($id) use($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $book = $db->books()->where('id',$id);
    if($book->fetch()){
        $result = $book->delete();
        echo json_encode(array(
                'status' => (bool)$result,
                'message' => 'Book deleted successfully'
            ));
    }
    else{
        echo json_encode(array(
                'status' => false,
                'message' => "Book id $id does not exist"
            ));
    }
});

$app->put('/book/:id',function($id) use($app,$db){
   $book = $db->books()->where('id',$id);
   if($book->fetch()){
        $result = $book->update($_POST);
        echo json_encode(array(
                'status' => (bool)$result,
                'message' => 'Book updated successfully'
            ));
    }
    else{
        echo json_encode(array(
                'status' => false,
                'message' => "Book id $id does not exist"
            ));
    }
});

$app->run();