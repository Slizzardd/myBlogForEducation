<?php
// controller
include_once SITE_ROOT . "/app/database/db.php";
$commentsForAdm = selectAll('comments');

$page = '';
$email = '';
$comment = '';
$errMsg = [];
$status = 0;
$comments = [];


// Code for the comment form
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goComment'])){
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);


    if($email === '' || $comment === ''){
        array_push($errMsg, "Not all fields are filled in!");
    }elseif (mb_strlen($comment, 'UTF8') < 2){
        array_push($errMsg, "The comment must be longer than 2 characters");
    }else{
        $user = selectOne('users', ['email' => $email]);
        if ($user['email'] == $email && $user['admin'] == 1){
            $status = 1;
        }

        $comment = [
            'status' => $status,
            'page' => $_POST['post_idd'],
            'email' => $email,
            'comment' => $comment
        ];
        $comment = insert('comments', $comment);
        $comments = selectAll('comments', ['page' => $page, 'status' => 1] );

    }
}else{
    $email = '';
    $comment = '';
    $comments = selectAll('comments', ['page' => $page, 'status' => 1] );

}
// Deleting a comment
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    delete('comments', $id);
    header('location: ' . BASE_URL . 'admin/comments/index.php');
}

// Status to publish or withdraw from publication
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])){
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    update('comments', $id, ['status' => $publish]);

    header('location: ' . BASE_URL . 'admin/comments/index.php');
    exit();
}


// АПДЕЙТ СТАТЬИ
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $oneComment = selectOne('comments', ['id' => $_GET['id']]);
    $id =  $oneComment['id'];
    $email =  $oneComment['email'];
    $text1 = $oneComment['comment'];
    $pub = $oneComment['status'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])){
    $id =  $_POST['id'];
    $text = trim($_POST['content']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    if($text === ''){
        array_push($errMsg, "The comment has no text content");
    }elseif (mb_strlen($text, 'UTF8') < 2){
        array_push($errMsg, "The number of characters inside the comment is less than 2");
    }else{
        $com = [
            'comment' => $text,
            'status' => $publish
        ];

        update('comments', $id, $com);
        header('location: ' . BASE_URL . 'admin/comments/index.php');
    }
}else{
    $text = '';
    $publish = isset($_POST['publish']) ? 1 : 0;
}