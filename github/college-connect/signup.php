<?php 
include 'config.php';
session_start(); 
?>
<?php include 'header.html';
if (isset($_POST['action'])) 
{
	if ($_POST['user_type']=='student') {
		$collection = $db->user;
		$document = array(
			'name'=>$_POST['name'],
			'dob'=> new MongoDate(strtotime($_POST['dob'])),
			'gender'=>$_POST['gender'],
			'email'=>$_POST['email'],
			'mobile'=>$_POST['phone'],
			'address'=>$_POST['address'],
			'yoa'=>$_POST['stud_yoa'],
			'type'=>"student",
			'department'=>$_POST['student_department'],
			'fathers_name'=>$_POST['fat_name'],
			'fathers_mobile'=>$_POST['fat_mob'],
			'mothers_name'=>$_POST['mot_name'],
			'mothers_mobile'=>$_POST['mot_mob'],
			'approved' =>false
			);
		$collection->insert($document);
		header('Location: index.php');
	}elseif ($_POST['user_type']=='staff') {
		$collection = $db->user;
		$document = array(
			'name'=>$_POST['name'],
			'dob'=> new MongoDate(strtotime($_POST['dob'])),
			'gender'=>$_POST['gender'],
			'email'=>$_POST['email'],
			'mobile'=>$_POST['phone'],
			'address'=>$_POST['address'],
			'yoa'=>$_POST['yoa'],
			'type'=>"staff",
			'qualification'=>$_POST['qualification'],
			'department'=>$_POST['staff_department'],
			'subjects' =>$_POST['sub'],
			'approved' =>false
			);
		$collection->insert($document);
		header('Location: index.php');
	}
	/*
		*/
}
?>
<div class="row"></div>
<div id="announcement_page" class="col l12">
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<div class="card">
				<div class="card-content black-text">
					<div class="row">
						<span class="card-title black-text">User Details</span>
					</div>
					<form id="submit-form" class="form col s12" action="signup.php" method="POST">
						<div class="row">
							<div class="input-field col s4">
								<label id="name" or="name">Name <em class="form-req">*</em></label>
								<input name="name" length="20" type="text" class="validate" required>
							</div>
						</div>
						<div class="row">
							<div class="col s6">
								<label id="dob" for="dob">Date of Birth <em class="form-req">*</em></label>
								<input name="dob" type="date" class="validate datepicker" id="dob" required>
							</div>
						</div>
						<div class="row">
							<label for="gender" >Gender <em class="form-req">*</em></label><br><br>
							<input name="gender" class="with-gap" type="radio" id="m"  value="Male" class="validate" required>
							<label for="m">Male</label>
							<input name="gender" class="with-gap" type="radio" id="f" value="Female" >
							<label for="f">Female</label>
						</div>
						<div class="row">
							<div class="input-field  col  s5">
								<label id="email" for="email">Email Id <em class="form-req">*</em></label>
								<input name="email" type="text" id="email" class="validate" required>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s4">
								<label id="phoneUS" for="phoneUS">Mobile Number <em class="form-req">*</em></label>
								<input name="phoneUS" type="text" id="phoneUS" class="validate" required>
								<span id="status"></span>
							</div>							
						</div>
						<div class="row">
							<div class="input-field col s5">
								<label id="address" for="address">Address <em class="form-req">*</em></label>
								<textarea name="address" id="textarea1" length="120" class="materialize-textarea validate" required></textarea>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<select name="user_type" id="user_type" class="validate">
        							<option value="1" disabled selected>Choose Membership Type</option><em class="form-req validate" required>*</em>
        							<option value="student">Student</option>
        							<option value="staff">Staff</option>
        						</select>
							</div>
						</div>
						<div id="student_details" style="display:none;">
							<div class="row">
								<div class="input-field col s6">
									<select name="student_department" id="student_department">
        								<option value="1" disabled selected>Choose Department</option>
        								<option value="it">Information Technology</option>
        								<option value="entc">Electronics & Telecommunication</option>
        								<option value="ce">Computer Engineering</option>
        							</select>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<label for="stud_yoa">Year Of Admission <em class="form-req">*</em></label>
									<input name="stud_yoa" type="text" class="validate" id="stud_yoa" required>
								</div>
							</div>
							<div class="row">
								<span class="card-title black-text">Parent Details</span>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<label for="fat_name">Father's Name <em class="form-req">*</em></label>
									<input name="fat_name" type="text" class="validate" id="fat_name" required>
								</div>
								<div class="input-field col s4">
									<label for="fat_mob"> Mobile Number <em class="form-req">*</em></label>
									<input name="fat_mob" type="text" class="validate" id="fat_mob" required>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<label for="mot_name" >Mother's Name <em class="form-req">*</em></label>
									<input name="mot_name" class="validate" type="text" id="mot_name" required>
								</div>
								<div class="input-field col s4">
									<label for="mot_mob"> Mobile Number <em class="form-req">*</em></label>
									<input name="mot_mob" class="validate" type="text" id="mot_mob" required>
								</div>
							</div>
						</div>
						<div id="staff_details" style="display:none;">
							<div class="row">
								<div class="input-field col s4">
									<label for="yoa">Started teaching from </label>
									<input name="yoa" type="text" class="validate" id="yoa" required>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									<label for="qualification">Qualification</label>
									<textarea name="qualification" id="textarea1" class="materialize-textarea validate" required></textarea>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									<select class="browser-default" name="staff_department" id="staff_department">
        								<option value="1" disabled selected>Choose Department</option>
        								<option value="as">Applied Science</option>
        								<option value="it">Information Technology</option>
        								<option value="entc">Electronics & Telecommunication</option>
        								<option value="ce">Computer Engineering</option>
        								<option value="admin">Administration</option>
        								<option value="tnp">Training And Placement Cell</option>
        							</select>
								</div>
							</div>
							<div class="row"></div>
							<div id="staff_subject" style="display:none;">
								<div class="row">
									<span class="card-title black-text">Teaches Subject</span>
								</div>
								<div class="row"></div>
								<div class="row" id="subject_list"></div>
							</div>
						</div>
						<div class="card-action">
							<center>
                    	        <button class="btn waves-effect waves-light" onClick="ValidateForm(this.form)" type="submit" name="action">Submit
                        	        <i class="material-icons right">send</i>
								</button>
							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<footer class="page-footer">
          <div class="footer-copyright">
            <div class="container">
            Copyright &copy; Pune Institute of Computer Technology, 2015
            </div>
          </div>
        </footer>

<script>
		$('#submit-form').validate();
		</script>
<script>
	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 100 // Creates a dropdown of 15 years to control year
	});
</script>


<script>
	$(document).ready(function() {
    $('input#text, textarea#textarea1').characterCounter();
  });
       
  $(document).ready(function() {
    $('select').material_select();
  });
</script>


<script>
	$(document).ready(function() {
	    $('#user_type').change(function(){
	    	var value = $('#user_type').find(":selected").attr('value');
	    	if (value == 'student') {
	    		$('#student_details').removeAttr('style');
	    		$('#staff_details').attr('style', 'display:none;');
	    	}else{
	    		$('#staff_details').removeAttr('style');
	    		$('#student_details').attr('style', 'display:none;');
	    	}
	    });
	    $('#staff_department').change(function(){
	    	var sub_as = [];
	    	var sub_it = [];
	    	var sub_comp = [];
	    	var sub_entc = [];
	    	sub_as[2] = ['EM-1','PHYSICS','CHEMISRTY','FPL-1','ELECTRONICS','ELECTRICAL','CIVIL','GRAPHICS','EM-2','FPL-2'];
	    	sub_as[3] = ['MECHANICS','MECHANICAL','EM-3'];
	    	sub_it[2] = ['DS','CO','FDS','DELD','PS&OOP','FCN','AD','PAI','DSFL','CG'];
	    	sub_it[3] = ['DBMS','CNT','WET','SE','TOC','DAA','SP','OS','MT','ITPM'];
	    	sub_it[4] = ['ICS','SMD','ML','DS','FPL-1','FPL-2'];
	    	sub_comp[2] = ['DS','DSPS','DELD','OSA','MA','OOMP','MIT','CGG','CO','TOC'];
	    	sub_comp[3] = ['OSD','WSN','DBMS','CF&CA','CDP','EOS','CN','SE','DSPA','DAA'];
	    	sub_comp[4] = ['MCD','SSD','SDMT','HPC'];
	    	sub_entc[2] = ['SS','EDC','NT','DSA','DE','IC','CS','AC','CO','DC'];
	    	sub_entc[3] = ['DSP','MCA','ETL','SPOS','ITCT','AWP','EP','IP','PE','VLSI'];
	    	sub_entc[4] = ['CN','ME','MC','BCS'];
	    	var dept = $('#staff_department').find(':selected').attr('value')
	    	switch (dept) { 
				case 'it': 
	    			var k=0;
					var string_sub = ""; 
	    				for (var i = 2; i < 5; i++) {
	    					string_sub += "<div class='col s4'>";
	    					if (i==4) {
								for (var j = 0; j < 6; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_it[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_it[i][j];
	    						string_sub += "</label><br>";
	    					};
	    					}
	    					else
	    					{
	    						for (var j = 0; j < 10; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_it[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_it[i][j];
	    						string_sub += "</label><br>";
	    						};
	    					}
	    					
			    			string_sub += "</div>";
	    				};
					$('#subject_list').html(string_sub);
					break;
				case 'ce':
	    			var k=0;
					var string_sub = ""; 
	    				for (var i = 2; i < 5; i++) {
	    					string_sub += "<div class='col s4'>";
	    					if (i==4) {
								for (var j = 0; j < 4; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_comp[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_comp[i][j];
	    						string_sub += "</label><br>";
	    					};
	    					}
	    					else
	    					{
	    						for (var j = 0; j < 10; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_comp[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_comp[i][j];
	    						string_sub += "</label><br>";
	    						};
	    					}
			    			string_sub += "</div>";
	    				};
					$('#subject_list').html(string_sub);
					break;
				case 'entc':
	    			var k=0;
					var string_sub = ""; 
	    				for (var i = 2; i < 5; i++) {
	    					string_sub += "<div class='col s4'>";
	    					if (i==4) {
								for (var j = 0; j < 4; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_it[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_it[i][j];
	    						string_sub += "</label><br>";
	    					};
	    					}
	    					else
	    					{
	    						for (var j = 0; j < 10; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_it[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_it[i][j];
	    						string_sub += "</label><br>";
	    						};
	    					}
	    					string_sub += "</div>";
	    				};
					$('#subject_list').html(string_sub);
					break;
				case 'as':
	    			var k=0;
					var string_sub = ""; 
	    				for (var i = 2; i < 4; i++) {
	    					string_sub += "<div class='col s4'>";
	    					if (i==3) {
								for (var j = 0; j < 3; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_as[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_as[i][j];
	    						string_sub += "</label><br>";
	    					};
	    					}
	    					else
	    					{
	    						for (var j = 0; j < 10; j++) {
	    						string_sub += "<input id='sub";
	    						string_sub += k;
	    						string_sub += "' type='checkbox' name='sub[]' value='";
	    						string_sub += sub_as[i][j];
	    						string_sub += "'><label for='sub";
	    						string_sub += k++;
	    						string_sub += "'>";
	    						string_sub += sub_as[i][j];
	    						string_sub += "</label><br>";
	    						};
	    					}
			    			string_sub += "</div>";
	    				};
					$('#subject_list').html(string_sub);
					break;
			}
	    });
	});
	$(document).ready(function() {
	    $('#staff_department').change(function(){
	    	var value = $('#staff_department').find(":selected").attr('value');
	    	if (value == 'tnp' || value == 'admin') {
	    		$('#staff_subject').attr('style', 'display:none;');
	    	}else{
	    		$('#staff_subject').removeAttr('style');
	    	}
	    });
	});
</script>
