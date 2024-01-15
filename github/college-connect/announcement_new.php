<?php 

include "template_header.php";
if (isset($_POST['post'])) 
{
		$collection = $db->post;
		$document = array(
			'title'=>$_POST['announcement_title'],
			'description'=>$_POST['description'],
			'department'=>$_POST['department'],
			'year'=>$_POST['year'],
			'subject'=>$_POST['subject'],
			'type'=>"Announcement",
			'by'=>new MongoId($_SESSION['id']),
            'date'=>new MongoDate()
			);
		$collection->insert($document);

$document = $collection->find(array('type'=>'Announcement'));
foreach ($document as $doc){
            header("Location: announcement_page.php?id=".$doc['_id']);
        }
}
?>
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<div class="card">
				<div class="card-content black-text">
					<span class="card-title black-text">Add An Announcement</span>
					<div class="row">
						<form class="col l15" action="announcement_new.php" method="POST" >
							<div class="row">
								<div class="input-field col l10">
        							<input name="announcement_title" id="announcement_title" type="text">
        							<label for="announcement_title">Announcement Title</label>
        						</div>
        						<div class="input-field col l8">
        							<textarea name="description" id="description" class="materialize-textarea"></textarea>
        							<label for="description">Description</label>
        						</div>
        						<div class="input-field col l8">
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
							</div>
							<center>
	        					<button class="btn waves-effect waves-light" type="submit" name="post">Post Announcement
							    	<i class="material-icons right">send</i>
								</button>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row"></div>

<script>
$(document).ready(function() {
    $('select').material_select();
    $('#department').change(function(){
        var dept = $('#department').find(':selected').attr('value');
        switch(dept){
            case 'it':
            case 'entc':
            case 'ce':
                $('#year').removeAttr('style');
                break;
            case 'gen':
            case 'tnp':
            case  'as':
                $('#year').attr('style', 'display:none;');
                break;
        }
    });
});
</script>
<?php include "template_footer.html"; ?>