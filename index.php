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
$dsn = 'mysql:dbname=slimtut;host=127.0.0.1';
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
    echo "Hello world";
});
$app->post('/users',function() use($app,$db){
    $user = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'age' => $_POST['age'],
        );
    $result = $db->users->insert($user);
    echo json_encode(array('id' => $result['id']));
});

$app->get('/users',function() use ($app,$db){
   // $app->response()->header('Content-Type', 'application/json');
    $users = array();
    foreach ($db->users as $user) {
        $users[]  = array(
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'age' => $user['age']
            );
    }
    echo json_encode($users);
    echo "<form action='' method='post'>
            Name : <input type='text' name='name' /> </br>
            Email : <input type='text' name='email' /> </br>
            Age : <input type='text' name='age' /> </ br>
            <input type='submit' name='submit' value='Submit' >
        </form>";
});





$app->run();
