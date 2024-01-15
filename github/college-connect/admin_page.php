<?php
   	include 'config.php';
   	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<!--Import Google Icon Font-->
	<link href="images/material.icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>College Connect</title>
	<link rel="shortcut icon" href="images/favicon.png">
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
</head>

<body>

<nav>
	<div class="nav-wrapper">
		<img src="images/logo.png">
		<ul class="right hide-on-med-and-down">
			<!-- Dropdown Trigger -->
			<li>Welcome, admin</li>
			<li><a href="destroy.php">Logout</a></li>
		</ul>
	</div>
</nav>

<div class="row"></div>
<div class="row">
	<?php
		if ($_SESSION['type']!='admin') {
			header('Location: main.php');
		}
	   	$collection = $db->user;
	   	$cursor = $collection->find(array('approved'=>false));
	   	$count = $cursor->count();
	?>
	<div class="col l6 offset-l3">
		<h5><?php echo $count; ?> Users to be approved.</h5>
	</div>
</div>
<div class="row">
	<ul class="collapsible popout col l6 offset-l3" data-collapsible="accordion">
	    <?php
	    	foreach ($cursor as $document) {
	    		$aid = $count;
	    		$inpid = 'rid'.$count--;
	    		?>
	    		<li>
	    			<div class="collapsible-header active">
	    				<i class="material-icons">add_alert</i><?php echo $document['name']; ?>
	    			</div>
	    			<div class="collapsible-body">
	    			<div class="row">
	    				<form method="POST" action="approve_user.php" class="col l10 offset-l1">
	    				Name: <?php echo $document['name']; ?><br>
	    				<?php if ($document['type']=='staff') {
	    					echo "Started Teaching from: ";
	    				}elseif ($document['type']=='student') {
	    					echo "Year of Admission: ";
	    				}?><?php echo $document['yoa']; ?><br>
	    				Date of birth: <?php echo date('d-M-Y', $document['dob']->sec); ?><br>
	    				Email: <?php echo $document['email']; ?><br>
	    				Type: <?php echo $document['type']; ?><br><br>
	    				<center>
	    					<input value=<?php echo $document['_id'];?> name="id" hidden>
	    					<input value=<?php echo $document['type'];?> name="type" hidden>
        					<button class="btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="approve">Approve
        						<i class="material-icons right">send</i>
        					</button>
        					<button class="btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="disapprove">Disapprove
        						<i class="material-icons right">X</i>
        					</button>
	    				</center>
        				</form>
	    			</div>
	    			</div>
	    		</li>
	    		<?php
	    	}
	    ?>
	</ul>
</div>

</body>
</html>