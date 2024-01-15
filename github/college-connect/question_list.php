<?php 
include "template_header.php"; 

$it[2] = array('DS','CO','FDS','DELD','PS&OOP','FCN','AD','PAI','DSFL','CG');
$it[3] = array('DBMS','CNT','WET','SE','TOC','DAA','SP','OS','MT','ITPM');
$it[4] = array('ICS','SMD','ML','DS','FPL-1','FPL-2');
$as = array('EM-1','PHYSICS','CHEMISRTY','FPL-1','ELECTRONICS','ELECTRICAL','CIVIL','GRAPHICS','EM-2','FPL-2','MECHANICS','MECHANICAL','EM-3');
$ce[2] = array('DS','DSPS','DELD','OSA','MA','OOMP','MIT','CGG','CO','TOC');
$ce[3] = array('OSD','WSN','DBMS','CF&CA','CDP','EOS','CN','SE','DSPA','DAA');
$ce[4] = array('MCD','SSD','SDMT','HPC');
$entc[2] = array('SS','EDC','NT','DSA','DE','IC','CS','AC','CO','DC');
$entc[3] = array('DSP','MCA','ETL','SPOS','ITCT','AWP','EP','IP','PE','VLSI');
$entc[4] = array('CN','ME','MC','BCS');

$next = "location.href='question_list.php?page=".($_GET['page']+1)."';";
$back = "location.href='question_list.php?page=".($_GET['page']-1)."';";
?>
	<div class="row"></div>
	<div class="row right">
		<div class="input-field col l5">
			<select class="browser-default" id="department">
				<option value="" <?php if (!isset($_GET['dept'])) {
					echo "disabled selected";
				}else{ echo "disabled"; } ?>>Choose Department</option>
				<option value="gen" <?php if ($_GET['dept']=='gen') {
					echo "selected";
				} ?>>General</option>
				<option value="tnp" <?php if ($_GET['dept']=='tnp') {
					echo "selected";
				} ?>>Training and Placements</option>
				<option value="it" <?php if ($_GET['dept']=='it') {
					echo "selected";
				} ?>>Information Technology</option>
				<option value="ce" <?php if ($_GET['dept']=='ce') {
					echo "selected";
				} ?>>Computer Engineering</option>
				<option value="entc" <?php if ($_GET['dept']=='entc') {
					echo "selected";
				} ?>>Electronics & Telecommunication</option>
				<option value="as" <?php if ($_GET['dept']=='as') {
					echo "selected";
				} ?>>Applied Science</option>
			</select>
		</div>
		<div class="input-field col l3">
			<select class="browser-default" <?php if (!isset($_GET['dept'])||in_array($_GET['dept'], array('gen','tnp','as'))) {
					echo "disabled";
				} ?> id="year">
				<option value="" <?php if (!isset($_GET['year'])) {
					echo "disabled selected";
				}else{ echo "disabled"; } ?>>Choose Year</option>
				<option value="1" <?php if ($_GET['year']=='1') {
					echo "selected";
				} ?>>All years</option>
				<option value="2" <?php if ($_GET['year']=='2') {
					echo "selected";
				} ?>>S.E.</option>
				<option value="3" <?php if ($_GET['year']=='3') {
					echo "selected";
				} ?>>T.E.</option>
				<option value="4" <?php if ($_GET['year']=='4') {
					echo "selected";
				} ?>>B.E.</option>
			</select>
		</div>
		<div class="input-field col l4">
			<select class="browser-default" <?php if (!($_GET['dept']=='as')&&(!(isset($_GET['year']))||$_GET['year']==1)) {
					echo "disabled";
				} ?> id="subject">
				<option value="" <?php if (!isset($_GET['subject'])) {
					echo "disabled selected";
				}else{ echo "disabled"; } ?>>Choose Subject</option>
				<?php 
				switch ($_GET['dept']) {
					case 'it':
						$array = $it;
						break;
					case 'ce':
						$array = $ce;
						break;
					case 'entc':
						$array = $entc;
						break;
					case 'as':
						$array = $as;
						break;
				}
				switch ($_GET['year']) {
					case 2:
						foreach ($array[2] as $sub) {
							?>
							<option value=<?php echo $sub; ?> <?php if ($_GET['subject']==$sub) {
								echo "selected";
							} ?>><?php echo $sub; ?></option>
							<?php
						}						
						break;
					case 3:
						foreach ($array[3] as $sub) {
							?>
							<option value=<?php echo $sub; ?> <?php if ($_GET['subject']==$sub) {
								echo "selected";
							} ?>><?php echo $sub; ?></option>
							<?php
						}						
						break;
					case 4:
						foreach ($array[4] as $sub) {
							?>
							<option value=<?php echo $sub; ?> <?php if ($_GET['subject']==$sub) {
								echo "selected";
							} ?>><?php echo $sub; ?></option>
							<?php
						}						
						break;
					default:
						foreach ($array as $sub) {
							?>
							<option value=<?php echo $sub; ?> <?php if ($_GET['subject']==$sub) {
								echo "selected";
							} ?>><?php echo $sub; ?></option>
							<?php
						}
						break;
				}
				?>
			</select>
		</div>
	</div>
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<table class="highlight">
				<thead>
					<tr>
						<th data-field="title">Title</th>
						<th data-field="by">Posted by</th>
						<th data-field="date">Posted on</th>
					</tr>
				</thead>
				<?php
				$collection = $db->post;
				if (isset($_GET['dept'])) {
					if (isset($_GET['year'])) {
						if (isset($_GET['subject'])) {
							$cursor = $collection->find(
									array(
											'type' => 'Question',
											'department'=> $_GET['dept'],
											'year'=> $_GET['year'],
											'subject'=> $_GET['subject']
										)
								)->sort(array('date' => -1))->skip(($_GET['page']-1)*3)->limit(3);
						}else{
							$cursor = $collection->find(
									array(
											'type' => 'Question',
											'department'=> $_GET['dept'],
											'year'=> $_GET['year']
										)
								)->sort(array('date' => -1))->skip(($_GET['page']-1)*3)->limit(3);
						}
					}else{
						$cursor = $collection->find(
								array(
										'type' => 'Question',
										'department'=> $_GET['dept']
									)
							)->sort(array('date' => -1))->skip(($_GET['page']-1)*3)->limit(3);
					}
				}else{
					$cursor = $collection->find(array('type' => 'Question'))->sort(array('date' => -1))->skip(($_GET['page']-1)*3)->limit(3);
				}
				$count = $cursor->count();
				$rem = $count - ($_GET['page']*3);
				?>
				<tbody>
				<?php
				if ($count) 
				{
					foreach ($cursor as $document)
					{		
						//$acount = $document['answers']->count();
						$collection = $db->user;
						$id = new MongoId($document['by']);
						$doc = $collection->findOne(array('_id'=>$id));
						$title="question_page.php?show_question=1&id=".$document['_id'];
						?>
						<tr>
							<td><a href='<?php echo $title; ?>'><?php echo $document['title']; ?></a></td>
							<td><?php echo $doc['name']; ?></td>
							<td><?php echo date('d / M / Y', $document['date']->sec); ?></td>
						</tr>
						<?php
					}
				}else{
					?>
					<tr>
						<td>No new Questions</td>
					</tr>
					<?php 
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<?php if (!($rem<=0)) { ?>
			<button class="btn waves-effect waves-light right" style="background: #40c4ff" type="submit" name="action" onclick=<?php echo $next; ?>>Next
	        	<i class="material-icons right">fast_forward</i>
	        </button>
	        <?php } ?>
	        <?php if ($_GET['page']!=1) { ?>
			<button class="btn waves-effect waves-light left" style="background: #40c4ff" type="submit" name="action" onclick=<?php echo $back; ?>>Back
	       		<i class="material-icons left">fast_rewind</i>
	       	</button>
	        <?php } ?>
		</div>
	</div>
	<div class="row"></div>

<script>
	$(document).ready(function() {
    	$('select').material_select();
	    $('#department').change(function(){
        	var dept = $('#department').find(':selected').attr('value');
	    	window.location.href='question_list.php?page=1&dept='+dept;
	    });
	    $('#year').change(function(){
        	var dept = $('#department').find(':selected').attr('value');
        	var year = $('#year').find(':selected').attr('value');
	    	window.location.href='question_list.php?page=1&dept='+dept+'&year='+year;
	    });
	    $('#subject').change(function(){
        	var dept = $('#department').find(':selected').attr('value');
        	var year = $('#year').find(':selected').attr('value');
        	var subject = $('#subject').find(':selected').attr('value');
	    	window.location.href='question_list.php?page=1&dept='+dept+'&year='+year+'&subject='+subject;
	    });
	});
</script>	
<?php include "template_footer.html"; ?>