<?php

include 'config.php';
session_start();
$pid = new MongoId($_POST['pid']);
$aid = new MongoId($_POST['aid']);
$pby = new MongoId($_POST['pby']);
$aby = new MongoId($_POST['aby']);
$comment = $_POST['comment'];
$by = new MongoId($_SESSION['id']);
$collection = $db->post;
$collection->update(array('answers.aid'=>$aid),array('$addToSet'=>array('comments'=>array('cid'=>new MongoId(),'aid'=>$aid,'comment'=>$comment,'by'=>$by,'date'=>new MongoDate()))));
$collection = $db->user;
if ($pby!=$by) {
	$collection->update(array('_id'=>$pby),array('$addToSet'=>array('notifications.comments'=>$pid)));
}
if ($aby!=$by) {
	$collection->update(array('_id'=>$aby),array('$addToSet'=>array('notifications.comments'=>$pid)));
}
header('Location: question_page.php?id='.$_POST['pid']);

?>