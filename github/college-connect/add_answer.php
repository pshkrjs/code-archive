<?php

include 'config.php';
session_start();
$id = new MongoId($_POST['id']);
$pby = new MongoId($_POST['pby']);
$answer = $_POST['answer'];
$by = new MongoId($_SESSION['id']);
$collection = $db->post;
$collection->update(array('_id'=>$id),array('$addToSet'=>array('answers'=>array('aid'=>new MongoId(),'answer'=>$answer,'by'=>$by,'date'=>new MongoDate()))));
$collection = $db->user;
$collection->update(array('_id'=>$pby),array('$addToSet'=>array('notifications.answers'=>$id)));
header('Location: question_page.php?id='.$_POST['id']);
?>