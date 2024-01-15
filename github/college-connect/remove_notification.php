<?php
include 'config.php';
$collection = $db->user;

if (in_array($_POST['remove'], array('answer','comment'))) {
	$collection->update(array('_id'=>new MongoId($_POST['from'])),array('$pull'=>array('notifications.answers'=>new MongoId($_POST['id']),'notifications.comments'=>new MongoId($_POST['id']))));
}else{
	echo "fail";
}
?>