<?php

include 'config.php';
$collection = $db->user;
$id = new MongoId($_POST['id']);
if ($_POST['type']=='student') {
	$cursor = $collection->find(array('type'=>'student','approved'=>true))->sort(array('mem_since'=>-1))->limit(1);
	if ($cursor->count()) {
		foreach ($cursor as $document) {
			$reg_id = ($document['reg_id']+1);
			$sreg_id = sprintf('%.0f', $reg_id);
		}
		if (isset($_POST['approve'])) {
		 	$collection->update(array('_id' => $id), array('$set' => array('password'=>'123456', 'reg_id' => $sreg_id, 'approved' => true, 'mem_since' => new MongoDate())));
			header("Location: admin_page.php");
			die();
		}elseif (isset($_POST['disapprove'])) {
			$collection->remove(array('_id'=> $id), array('justOne'=>'true'));
			header("Location: admin_page.php");
			die();
		}
	}else{
		$reg_id = '100001';
		if (isset($_POST['approve'])) {
		 	$collection->update(array('_id' => $id), array('$set' => array('password'=>'123456', 'reg_id' => $reg_id, 'approved' => true, 'mem_since' => new MongoDate())));
			header("Location: admin_page.php");
			die();
		}elseif (isset($_POST['disapprove'])) {
			$collection->remove(array('_id'=> $id), array('justOne'=>'true'));
			header("Location: admin_page.php");
			die();
		}
	}
}elseif ($_POST['type']=='staff') {
	$cursor = $collection->find(array('type'=>'staff','approved'=>true))->sort(array('mem_since'=>-1))->limit(1);
	if ($cursor->count()) {
		foreach ($cursor as $document) {
			$reg_id = ($document['reg_id']+1);
			$sreg_id = sprintf('%.0f', $reg_id);
		}
		if (isset($_POST['approve'])) {
		 	$collection->update(array('_id' => $id), array('$set' => array('password'=>'123456', 'reg_id' => $sreg_id, 'approved' => true, 'mem_since' => new MongoDate())));
			header("Location: admin_page.php");
			die();
		}elseif (isset($_POST['disapprove'])) {
			$collection->remove(array('_id'=> $id), array('justOne'=>'true'));
			header("Location: admin_page.php");
			die();
		}
	}else{
		$reg_id = '1001';
		if (isset($_POST['approve'])) {
		 	$collection->update(array('_id' => $id), array('$set' => array('password'=>'123456', 'reg_id' => $reg_id, 'approved' => true, 'mem_since' => new MongoDate())));
			header("Location: admin_page.php");
			die();
		}elseif (isset($_POST['disapprove'])) {
			$collection->remove(array('_id'=> $id), array('justOne'=>'true'));
			header("Location: admin_page.php");
			die();
		}
	}
}
?>