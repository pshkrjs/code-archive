<?php 
include "template_header.php";
$page = 1;
?>

	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<table class="highlight">
				<thead>
					<tr>
						<th data-field="name">Name</th>
						<th data-field="mem_since">Member Since</th>
						<th data-field="type">Type</th>
					</tr>
				</thead>
		<?php
				$collection = $db->user;
				$sta_cursor = $collection->find(array('type' => 'staff','approved'=> true));
				$stu_cursor = $collection->find(array('type' => 'student','approved'=> true));
				$stu_count = $stu_cursor->count();
				$sta_count = $sta_cursor->count();
		?>	
				<tbody>

				<?php
					if ($sta_count) 
					{
						foreach ($sta_cursor as $document)
						{		
							$profile="user_profile.php?id=".$document['_id'];
				?>
							<tr>
								<td><a href='<?php echo $profile; ?>'><?php echo $document['name']; ?></a></td>
								<td><?php echo date('d-M-Y', $document['mem_since']->sec); ?></td>
								<td><?php echo $document['type']; ?></td>
							</tr>
			</div>
			<?php
		}
	}	
					if ($stu_count) 
					{
						foreach ($stu_cursor as $document)
						{		
							$profile="user_profile.php?id=".$document['_id'];
				?>
							<tr>
								<td><a href='<?php echo $profile; ?>'><?php echo $document['name']; ?></a></td>
								<td><?php echo date('d-M-Y', $document['mem_since']->sec); ?></td>
								<td><?php echo $document['type']; ?></td>
							</tr>
					</tbody>
			</div>
			<?php
		}
	}	
	?>
				</table>
		</div>
	</div>
	<div class="row"></div>
	<div class="row">
		<div class="col l6 offset-l3">
			<button class="btn waves-effect waves-light right" style="background: #40c4ff" type="submit" name="action">Next
	        	<i class="material-icons right">fast_forward</i>
	        </button>
			<button class="btn waves-effect waves-light left" style="background: #40c4ff"  type="submit" name="action">Previous
	        	<i class="material-icons left">fast_rewind</i>
	        </button>
		</div>
	</div>
	<div class="row"></div>
<?php include "template_footer.html"; ?>
