<?php 
include 'config.php';
session_start(); 
include 'header.html';
?>

<div class="row"></div>
<div class="row">

	<div class="card col l7 offset-l1">
		<div class="row">
			<div class="col l12">
				<ul class="tabs">
					<li class="tab col l1"><a href="#about_us" class="active">About us</a></li>
					<li class="tab col l1"><a href="#contact_us">Contact Us</a></li>
				</ul>
			</div>
			<div id="about_us" class="col l10 offset-l1">
				<div class="card-content">
					<span class="card-title black-text">About Us</span>
					<p>Members of the College Connect fraternity would bring students together and elaborate what it takes to make it through college in our &quot; Welcome Back &quot; forum.<br>
					Students would have the responsibility of accepting the people around them. An important thing is to know everyone is different and students should accept themselves as individuals.
					&quot; Accepting everyone is different is huge, and we need to socialize more because we are the future. &quot;
					Another topic the forum touched on is how students should present themselves while on campus.<br>
					The company you keep could make a difference in how outsiders perceive you.
					&quot; You want people to see you for who you are and not for who you hang around. &quot;<br>
					Open dialogues are important to teach students balance and helps set them up to succeed in college. The ultimate goal is to take the edge off students.<br>
					</p>
				</div>
			</div>
			<div id="contact_us" class="col l6 offset-l3">
				<div class="card-content">
					<span class="card-title black-text">Contact</span>
					<p>Pushkaraj Shinde- +91-8983632885<br>
					Shweta Singh- +91-8087757614<br>
					Tanay Mittal- +91-9999211125</p>
				</div>
			</div>
		</div>
	</div>
<?php
function index_form()
{
?>
	<div class="col l3 offset-l1">
	    <div class="card col l10">
	    	<form action="index.php" method="POST">
	    	<div class="row"></div>
	    		<label style=" font-size: 1.6rem"><center>Login</center></label>
	    		<div class="row">
	    	    	<div class="input-field col l11">
	    	    		<i class="material-icons prefix">account_circle</i>
	    	    		<input id="icon_prefix" type="text" name="reg_id">
	    	    		<label for="icon_prefix">Username</label>
	    	    	</div>
	    		</div>
	    		<div class="row">
	    	    	<div class="input-field col l11">
	    	    		<i class="material-icons prefix">vpn_key</i>
	    	    		<input id="icon_telephone" type="password" name="password">
	    	    		<label for="icon_telephone">Password</label>
	    	    	</div>
	    		</div>
	    		<div class="row">
	    		    <center><button class="btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="login">Login
	    		    <i class="material-icons right">send</i>
	    		    </button></center>
	    		</div>
	    		<div class="row">
	    			<center><label style=" font-size: 1em">Not an existing member?</label>
	    			<a href="signup.php">Sign Up</a></center>
	    		</div>
	    	</form>
	    </div>
	</div>
    <?php
}
if ($_SESSION['login'])
{
	header('Location: main.php');
}
elseif(isset($_POST['login']))
{
	$collection = $db->user;
	$registration = $_POST["reg_id"];
	$password = $_POST["password"];
	//verify registraion number and password, if correct set session and redirect to main page else give error and stay on same page.
	$cursor = $collection->findOne(array('reg_id' => $registration, 'password' => $password));
	if ($cursor['type']=='admin') {
		$_SESSION["type"] = $cursor["type"];
		header("Location: admin_page.php");
	}
	elseif (isset($cursor["name"])) 
	{
		$dept = array('it','entc','ce');
		$_SESSION["name"] = $cursor["name"];
		$_SESSION["id"] = $cursor["_id"];
		$_SESSION["reg_id"] = $cursor["reg_id"];
		$_SESSION["department"] = $cursor["department"];
		if (in_array($cursor['department'], $dept)) {
			$_SESSION['year'] = ('2016' - $cursor['yoa']);
		}
		$_SESSION["type"] = $cursor["type"];
		$_SESSION["login"] = true;
		header("Location: main.php");
	}else{
		echo "<div class='col l3 offset-l1'>Invalid registration id and password combo.</div>";		
		index_form();
	}
}
else
{
	index_form();
}
?>
</div>

	
        
<footer class="page-footer">
          <div class="footer-copyright">
            <div class="container">
            Copyright &copy; Pune Institute of Computer Technology, 2015
            </div>
          </div>
        </footer>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
  </html>
        