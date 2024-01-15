<?php 
include 'config.php';
session_start(); 
include "template_header.php";
if (isset($_POST['post'])) 
{
    $collection = $db->post;
    $document = array(
        'title'=>$_POST['question_title'],
        'description'=>$_POST['description'],
        'department'=>$_POST['department'],
        'year'=>$_POST['year'],
        'subject'=>$_POST['subject'],
        'type'=>"Question",
        'by'=>new MongoId($_SESSION['id']),
        'date'=>new MongoDate(),
        'answers'=>array(),
        'comments'=>array()
        );
    $collection->insert($document);

$document = $collection->find(array('type'=>'Question'));
foreach ($document as $doc){
            header("Location: question_page.php?id=".$doc['_id']);
        }
}
?>

<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<div class="card">
				<div class="card-content black-text">
					<span class="card-title black-text">Add a question</span>
					<div class="row">
						<form class="col l12" action="question_new.php" method="POST">
							<div class="row">
								<div class="input-field col l10">
        							<input name="question_title" id="question_title" type="text">
        							<label for="question_title">Question Title</label>
        						</div>
        						<div class="input-field col l10">
        							<textarea name="description" id="description" class="materialize-textarea"></textarea>
        							<label for="description">Description</label>
        						</div>
        						<div class="input-field col l5">
        							<select class="browser-default" name="department" id="department">
        								<option value="" disabled selected>Choose Department</option>
        								<option value="gen">General</option>
        								<option value="tnp">Training and Placements</option>
        								<option value="it">Information Technology</option>
        								<option value="ce">Computer Engineering</option>
        								<option value="entc">Electronics & Telecommunication</option>
        								<option value="as">Applied Science</option>
        							</select>
        						</div>
        						<div class="input-field col l8">
        							<select class="browser-default" name="year" id="year" style="display:none;">
        								<option value="" disabled selected>Choose Year</option>
        								<option value="1">General</option>
        								<option value="2">S.E.</option>
        								<option value="3">T.E.</option>
        								<option value="4">B.E.</option>
        							</select>
        						</div>
        						<div class="input-field col l8" id="subject_list" style="display:none;">HI</div>
							</div>
							<center>
	        					<button class="btn waves-effect waves-light" type="submit" name="post">Post Question
								    <i class="material-icons right">send</i>
								</a>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row"></div>

    <script>
        var it =[];
        var ce =[];
        var entc =[];
        var as =[];
            it[2] = ['DS','CO','FDS','DELD','PS&OOP','FCN','AD','PAI','DSFL','CG'];
            it[3] = ['DBMS','CNT','WET','SE','TOC','DAA','SP','OS','MT','ITPM'];
            it[4] = ['ICS','SMD','ML','DS','FPL-1','FPL-2'];
            as = ['EM-1','PHYSICS','CHEMISRTY','FPL-1','ELECTRONICS','ELECTRICAL','CIVIL','GRAPHICS','EM-2','FPL-2','MECHANICS','MECHANICAL','EM-3'];
            ce[2] = ['DS','DSPS','DELD','OSA','MA','OOMP','MIT','CGG','CO','TOC'];
            ce[3] = ['OSD','WSN','DBMS','CF&CA','CDP','EOS','CN','SE','DSPA','DAA'];
            ce[4] = ['MCD','SSD','SDMT','HPC'];
            entc[2] = ['SS','EDC','NT','DSA','DE','IC','CS','AC','CO','DC'];
            entc[3] = ['DSP','MCA','ETL','SPOS','ITCT','AWP','EP','IP','PE','VLSI'];
            entc[4] = ['CN','ME','MC','BCS'];
	$(document).ready(function() {
    	$('select').material_select();
        $('#department').change(function(){
            var dept = $('#department').find(':selected').attr('value');
            switch(dept){
                case 'it':
                case 'entc':
                case 'ce':
                    $('#subject_list').attr('style', 'display:none;');
                    $('#year').removeAttr('style');
                    break;
                case 'as':
                    $('#year').attr('style', 'display:none;');
                    var string_sub = '<select class="browser-default" name="subject" id="subject">'
                    for (var i = as.length - 1; i >= 0; i--) {
                        string_sub += '<option ';
                        string_sub += 'value="';
                        string_sub += as[i];
                        string_sub += '">';
                        string_sub += as[i];
                        string_sub += '</option>';
                    };
                    $('#subject_list').removeAttr('style');
                    string_sub += '</select>';
                    $('#subject_list').html(string_sub);
                    break;
                case 'gen':
                case 'tnp':
                    $('#year').attr('style', 'display:none;');
                    $('#subject_list').attr('style', 'display:none;');
                    break;
            }
        });
        $('#year').change(function(){
            var dept = $('#department').find(':selected').attr('value');
            var year = $('#year').find(':selected').attr('value');
            switch(dept){
                case 'it':
                    var array = it;
                    break;
                case 'ce':
                    var array = ce;
                    break;
                case 'entc':
                    var array = entc;
                    break;
            }
            if (year == 1) {
                $('#subject_list').attr('style','display:none;');
            }else{
                var string_sub = '<select class="browser-default" name="subject" id="subject">'
                for (var i = array[year].length - 1; i >= 0; i--) {
                    string_sub += '<option ';
                    string_sub += 'value="';
                    string_sub += array[year][i];
                    string_sub += '">';
                    string_sub += array[year][i];
                    string_sub += '</option>';
                };
                $('#subject_list').removeAttr('style');
                string_sub += '</select>';
                $('#subject_list').html(string_sub);
            }
        });
	});
</script>

<?php include "template_footer.html"; ?>