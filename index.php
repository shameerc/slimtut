<?php

require 'Slim/Slim.php';

include "NotORM.php";
$dsn = 'mysql:dbname=library;host=127.0.0.1';
$pdo = new PDO($dsn,'root','root');
$db  = new NotORM($pdo);

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
    $book = $app->request()->post();
    if($post){
        $result = $db->books->insert($book);
        echo json_encode(array('id' => $result['id']));
    }
    else{
        echo json_encode(array('status' => false, 'message' => 'Error'));
    }
});


$app->get('/books',function() use ($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $books = array();
    foreach ($db->books() as $book) {
        $books[]  = array(
                'id' => $book['id'],
                'title' => $book['title'],
                'author' => $book['author'],
                'summary' => $book['summary']
            );
    }
    echo json_encode($books);
});

$app->get('/book/:id',function($id) use($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $book = $db->books()->where('id',$id);
    if($data = $book->fetch()){
        echo json_encode(array(
                'id' => $data['id'],
                'title' => $data['title'],
                'author' => $data['author'],
                'summary' => $data['summary']
            ));
    }
    else{
        echo json_encode(array(
                'status' => false,
                'message' => "Book id $id does not exist"
            ));
    }
});

$app->delete('/book/:id',function($id) use($app,$db){
    $app->response()->header('Content-Type', 'application/json');
    $book = $db->books()->where('id',$id);
    if($book->fetch()){
        $result = $book->delete();
        echo json_encode(array(
                'status' => true,
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
    $post = $app->request()->put();
        $result = $book->update($post);
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

$app->notFound(function() use($app){
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode(array('status' => 404, 'message' => 'Not supported'));
});

$app->run();