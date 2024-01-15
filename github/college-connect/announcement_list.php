<?php include "template_header.php"; 
	$collection = $db->post;
	if ($_SESSION['type']=='staff') {
		$cursor = $collection->find(array('type' => 'Announcement'))->sort(array('date'=>-1));
	}else{
		$cursor = $collection->find(array('type' => 'Announcement','department' => array('$in' => array('tnp','gen',$_SESSION['department']))))->sort(array('date'=>-1));
	}
	$count = $cursor->count();
	if ($_SESSION['department']=='it') {
		$dep = 'it';
		$$dep = 'Information Technology';
	}elseif ($_SESSION['department']=='ce') {
		$dep = 'ce';
		$$dep = 'Computer Engineering';
	}elseif ($_SESSION['department']=='entc') {
		$dep = 'entc';
		$$dep = 'Electronics and Telecommunication';
	}
	$departments = array('gen'=>'General','tnp'=>'Training and Placements',$dep=>$$dep);
?>
		<div class="row"></div>
		<div class="row right">
		<?php if ($count) { 
				if ($_SESSION['type']=='student') {
					?>
       				<div class="input-field col l8">
        			    <select class="browser-default" name="department" id="department">
        			        <option value="" disabled selected>Choose Department</option>
        			        <?php foreach ($departments as $key => $value) {
        			        	?>
        			        	<option value=<?php echo $key; ?>><?php echo $value; ?></option>
        			        	<?php
        			        } ?>
        			    </select>
        			</div>
        			<?php
        		}else{
        			?>
        			<div class="input-field col l10">
						<select class="browser-default" id="department">
							<option value="" disabled selected>Choose Department</option>
							<option value="gen">General</option>
							<option value="tnp">Training and Placements</option>
							<option value="it">Information Technology</option>
							<option value="ce">Computer Engineering</option>
							<option value="entc">Electronics & Telecommunication</option>
							<option value="as">Applied Science</option>
						</select>
					</div>
        			<?php
        		}
        	 } ?>
		</div>
		<div class="row"></div>
		<div class="row">
			<div class="col l6 offset-l3">
				<table class="highlight">
					<thead>
						<tr>
							<th data-field="title">Title</th>
							<th data-field="on">Posted On</th>
							<th data-field="by">Posted By</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if ($count) 
					{
						foreach ($cursor as $document)
							{	
							$collection = $db->user;
							$id = new MongoId($document['by']);
							$doc = $collection->findOne(array('_id'=>$id));
							$title="announcement_page.php?id=".$document['_id'];
							if (($_SESSION['type']=='student')) {
								if ($document['department']==$_SESSION['department']) {
									if (in_array($document['year'], array($_SESSION['year'],'1'))) {
										?>
										<tr class=<?php echo $document['department']; ?> value="hide">
											<td><a href='<?php echo $title; ?>'><?php echo $document['title']; ?></a></td>
											<td><?php echo date('d / M / Y', $document['date']->sec); ?></td>
											<td><?php echo $doc['name']; ?></td>
										</tr>
										<?php
									}else{
										?>
										<!-- <tr>
											<td>No new Announcements</td>
										</tr> -->
										<?php
									}
								}else{
									?>
									<tr class=<?php echo $document['department']; ?> value="hide">
										<td><a href='<?php echo $title; ?>'><?php echo $document['title']; ?></a></td>
										<td><?php echo date('d / M / Y', $document['date']->sec); ?></td>
										<td><?php echo $doc['name']; ?></td>
									</tr>
									<?php
								}
							}else{
								?>
								<tr class=<?php echo $document['department']; ?> value="hide">
									<td><a href='<?php echo $title; ?>'><?php echo $document['title']; ?></a></td>
									<td><?php echo date('d / M / Y', $document['date']->sec); ?></td>
									<td><?php echo $doc['name']; ?></td>
								</tr>
								<?php
							}	
						}
					}else{
							?>
							<tr>
								<td>No new Announcements</td>
							</tr>
							<?php 
					} 
					?>
					</tbody>
				</table>
			</div>
		</div><!--
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
		<?php if ($page == 1) { ?>
			<button class="btn waves-effect waves-light left disabled" type="submit" name="action">Back
				<i class="material-icons left">fast_rewind</i>
			</button>
		<?php } ?>
			<button class="btn waves-effect waves-light right" type="submit" name="action">Next
				<i class="material-icons right">fast_forward</i>
			</button>
		</div>
	</div>-->
	<div class="row"></div>
<script>
$(document).ready(function() {
    $('select').material_select();
    $('#department').change(function(){
        var dept = '.'+$('#department').find(':selected').attr('value');
        $('tr').show();
    	$('tr[value="hide"]').not(dept).hide();
    });
});
</script>

<?php include "template_footer.html"; ?>