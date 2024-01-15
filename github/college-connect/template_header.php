<?php
session_start();
include 'config.php';
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
    </head>

    <body>
    <?php
    if (isset($_SESSION['name'])) {
      $collection = $db->user;
      $document = $collection->findOne(array('name'=>$_SESSION['name']));
      $id = 'user_profile.php?id='.$document['_id'];
      $notifs = 'notifications.php?id='.$document['_id'];
      $change = 'change_pass.php?id='.$document['_id'];
    }else{
      header('Location: index.php');
    }
    ?>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    <ul id="dropdown1" class="dropdown-content">
  <li><a href=<?php echo $id; ?>>User Profile</a></li>
  <li disabled><a href=<?php echo $change; ?>>Change Password</a></li>
  <li class="divider"></li>
  <li><a href="destroy.php">Logout</a></li>
</ul>

<nav>
  <div class="nav-wrapper">
    <img src="images/logo.png">
    <ul class="right hide-on-med-and-down">
     <li><a href="main.php">Home</a></li>
          <li><a href="announcement_list.php">Announcements</a></li>
      <li><a href="question_list.php?page=1">Questions</a></li>
      <li><a href="members.php">Members</a></li>
     <li><a href=<?php echo $notifs; ?>>Notifications</a></li>
      <!-- Dropdown Trigger -->
      <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Welcome, <?php echo $_SESSION['name'];?><i class="material-icons right">arrow_drop_down</i></a></li>
    </ul>
  </div>
</nav>


        
