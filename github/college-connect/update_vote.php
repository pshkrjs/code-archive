<?php
session_start();
include 'config.php';
$collection = $db->post;
$id = new MongoId($_POST['id']);

if ($_POST['change']=='answer_up') {
	$collection->update(
		array('answers'=>array('$elemMatch'=>array('aid'=>$id))),
		array('$addToSet'=>array('answers.$.upvote'=>new MongoId($_SESSION['id'])))
	);
	$document = $collection->findOne(array('_id'=>$id));
	echo count($document['answers']);
}elseif ($_POST['change']=='answer_down') {
	$collection->update(
		array('answers'=>array('$elemMatch'=>array('aid'=>$id))),
		array('$addToSet'=>array('answers.$.downvote'=>new MongoId($_SESSION['id'])))
	);
}elseif ($_POST['change']=='comment_up') {
	$collection->update(
		array('comments'=>array('$elemMatch'=>array('cid'=>$id))),
		array('$addToSet'=>array('comments.$.upvote'=>new MongoId($_SESSION['id'])))
	);
}elseif ($_POST['change']=='comment_down') {
	$collection->update(
		array('comments'=>array('$elemMatch'=>array('cid'=>$id))),
		array('$addToSet'=>array('comments.$.downvote'=>new MongoId($_SESSION['id'])))
	);
}

?>