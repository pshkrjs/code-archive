<?php include 'template_header.php';
if (isset($_POST['change'])) {
	$collection = $db->user;
	$collection->update(array('_id'=>new MongoId($_SESSION['id'])),array('$set'=>array('password'=>$_POST['new_pass'])));
	$_SESSION['password']=$_POST['new_pass'];
	header('Location: main.php');		
}else{
	$collection = $db->user;
	$document = $collection->findOne(array('_id'=>new MongoId($_SESSION['id'])));
?>
<div class="row"></div>
<div id="announcement_page" class="col l8">
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<div class="card">
				<div class="card-content black-text">
					<div class="row">
						<div class="card-title black-text">Account</div>
					</div>
					<form class="col s12" action="change_pass.php" method="POST">
						<div class="row">
							<div class="input-field col s6">
								<label for="old_pass">Current Password</label><br>
								<input name="old_pass" id="old_pass" type="password">
							</div><br><i id="old_pass_check" class="material-icons"></i>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<label for="new_pass">New Password</label><br>
								<input name="new_pass" id="new_pass" type="password">
							</div><br><label id="new_pass_check_1"></label><i id="new_pass_check" class="material-icons"></i>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<label for="re_pass">Re-Type New Password</label><br>
								<input name="re_pass" id="re_pass" type="password">
							</div><br><i id="re_pass_check" class="material-icons"></i>
						</div>
						<br>
						<center>
	        			<button class="btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="change" id="change">Change
						   	<i class="material-icons right">send</i>
						</button>	
						<br><br>										
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){ //jquery init
		$("i").hide();//hide all ticks
		$("#new_pass_check_1").hide();//hide new pass text span
		$("#old_pass").focusout(function(){//check for current password
			$("#change").attr('disabled','disabled');//disable submit button
			var dpass = <?php echo json_encode($document['password']); ?>;
			var cpass = $("#old_pass").val();
			console.log(dpass);
			console.log(cpass);
			if(cpass!=dpass){
				$("#old_pass_check").html("X").show();
				$("#old_pass").html("").focus();
			}else{
				$("#old_pass_check").html("done").show();
			}
		});
		$("#new_pass").focusout(function(){//check for new password should be 6-12 characters long
			$("#change").attr('disabled','disabled');//disable submit button
			var npass = $("#new_pass").val().length;
			console.log(npass);
			if((npass>13) || (npass<5)){
				$("#new_pass_check").hide();
				$("#new_pass_check_1").html("password must be 6-12 characters long").show();
				$("#new_pass").html("").focus();
			}else{
				$("#new_pass_check_1").hide();
				$("#new_pass_check").html("done").show();
			}
		});
		$("#re_pass").focusout(function(){//check for seeing if new password and recheck pass is same
			$("#change").attr('disabled','disabled');//disable submit button
			var npass = $("#new_pass").val();
			var cnpass = $("#re_pass").val();
			if(npass!=cnpass){
				$("#re_pass_check").html("X").attr('class','material-icons tiny').show();
				$("#re_pass").html("").focus();
			}else{
				$("#re_pass_check").html("done").removeAttr('class').attr('class','material-icons').show();
				$("#change").removeAttr('disabled');//activate submit button
			}
		});
	});
</script>
<?php
} include 'template_footer.html'; ?>