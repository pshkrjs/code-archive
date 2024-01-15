<?php
session_start();
include 'config.php';

$collection = $db->post;
print_r($_POST);

$doc = $collection->findOne(array('_id' => new MongoId($_POST['pid'])));
$type = $doc['type'];
$collection->remove(array('_id' => new MongoId($_POST['pid'])));
if ($type=='Announcement') {
	header('Location: announcement_list.php');
}elseif ($type=='Question') {
	header('Location: question_list.php?page=1');
}
?>