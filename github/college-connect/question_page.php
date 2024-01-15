<?php 
	include "template_header.php"; 
	$collection = $db->post;
	$id = $_GET["id"];
	$cursor = $collection->findOne(array('_id' => new MongoId($id)));
	$collection = $db->user;
	$id = new MongoId($cursor['by']);
	$docs1 = $collection->findOne(array('_id'=>$id));
?>
		<div class="row"></div>
		<div class="row">
			<div class="col l6 offset-l3">
				<div class="card" style="background: #40c4ff">
					<div class="card-content">
						<span class="card-title"><?php echo $cursor['title']; ?></span>
						<div>
							Description: <?php echo $cursor['description']; ?><br>
							By: <?php echo $docs1['name']; ?><br>
							Posted on: <?php echo date('d-M-Y', $cursor['date']->sec); ?><br>
						</div>
					</div>
				</div>
				<div>
					<?php 
				if($_SESSION['id'] == $docs1['_id'])
				{
					?>
					<form action="remove_post.php" method="POST">
					<input value=<?php echo $cursor['_id']; ?> name="pid" hidden>
					<center>
					    <button class="btn waves-effect waves-light" type="submit" name="remove">Delete Post
                           <i class="material-icons right">send</i>
						</button>
					</center>
					</form>
				<?php
				}
				?>
				</div>
			</div>
		</div>
		<?php if ($_SESSION['name'] != $docs1['name']) { ?>
		<div class="row">
			<div class="col l6 offset-l3">
				<form action="add_answer.php" method="POST">
				<input value=<?php echo $cursor['_id']; ?> name="id" hidden>
				<input value=<?php echo $cursor['by']; ?> name="pby" hidden>
					<div class="input-field col l8 offset-l2">
						<label for="answer">Answer</label>
						<textarea name="answer" id="answer" class="materialize-textarea"></textarea>
					</div><br>
					<center><button class="btn waves-effect waves-light" type="submit" name="action">Answer</button></center>
				</form>
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col l6 offset-l3" >
				<ul class="collapsible popout" data-collapsible="accordion" >
				    <?php foreach ($cursor['answers'] as $document) {
				    	//if ((count($document['upvote'])-count($document['downvote']) > -5) {
				    		$collection = $db->user;
							$id = new MongoId($document['by']);
							$docs2 = $collection->findOne(array('_id'=>$id));
							?>
				    		<li id="<?php echo $document['aid']; ?>">
				    		  	<div class="collapsible-header active">
				    		  	<div class="row">
				    		  	<div class="col l10">
				    		  	<p>
				    		  		Description: <?php echo $document['answer']; ?><br>
									By: <?php echo $docs2['name']; ?><br>
									Posted on: <?php echo date('d-M-Y', $document['date']->sec); ?><br>
									</p>
									</div>
									<div class="col l2" id="<?php echo $id; ?>">
				    		  	<i class="material-icons ans_up" value=<?php echo $document['aid']; ?>>thumb_up</i><br>
				    		  	<label class="left ans_count"><?php echo (count($document['upvote'])-count($document['downvote'])); ?></label><br>
				    		  	<i class="material-icons ans_down" value=<?php echo $document['aid']; ?>>thumb_down</i>
				    		  	</div>
				    		  		
				    		  	</div>
				    		  	</div>
				    		  	<div class="collapsible-body">
				    		  		<div>
				    		  		<?php
				    		  		foreach ($cursor['comments'] as $doc) {
				    		  			if ($doc['aid']==$document['aid']) {
				    		  				//if ((count($doc['upvote'])-count($doc['downvote']) > -5) { 
				    		  					$collection = $db->user;
												$id = new MongoId($doc['by']);
												$docs = $collection->findOne(array('_id'=>$id));
												?>
												<blockquote>
													<?php echo $doc['comment']; ?><br>
													By: <?php echo $docs['name']; ?><br><br><div id="<?php echo $doc['cid']; ?>">
													<i class="material-icons comm_up tiny left" value=<?php echo $doc['cid']; ?>>thumb_up</i>
													<label class="left comm_count"><?php echo (count($doc['upvote'])-count($doc['downvote'])); ?></label>&nbsp;&nbsp;
				    		  						<i class="material-icons comm_down tiny" value=<?php echo $doc['cid']; ?>>thumb_down</i></div>
												</blockquote>
												<?php
											//}
										}
									} 
									?>
									</div>
									<form action="add_comment.php" method="POST">
										<input value=<?php echo $cursor['_id']; ?> name="pid" hidden>
										<input value=<?php echo $document['aid']; ?> name="aid" hidden>
										<input value=<?php echo $cursor['by']; ?> name="pby" hidden>
										<input value=<?php echo $document['by']; ?> name="aby" hidden>
										<div class="input-field col l9">				
											<input name="comment" type="text" class="validate">
											<label for="comment">Comment</label>
										</div><br>
										<button class="btn waves-effect waves-light" type="submit" name="action">Comment</button>
									</form>
									<br>
				    		  	</div>
				    		  	<?php } ?>
				    		</li>
				    		<?php
				    	//}
				    ?>
				</ul>
				<?php  
				if($_SESSION['name'] == $cursor['by'])
				{
					?>
					<form action="remove_post.php" method="POST">
					<center>
                        <button class="btn waves-effect waves-light" type="submit" name="remove">Delete Post
                           <i class="material-icons right">send</i>
						</button>
						<?php $_SESSION['title']='Question';?>
					</center>
					</form>
				<?php
				}
				?>
			</div>
		</div>
		<div class="row"></div>

<script>
	$(document).ready(function(){
		$('.ans_up').click(function(){
			var aid = $(this).closest('div').attr('id');
			var id = $('#'+aid).children('.ans_up').attr('value');
			var data = "change=answer_up&id="+id;
			var votes = $('#'+aid).children(".ans_count").html();
			console.log(votes);
			votes++;
			$.ajax({
				type: "POST",
				url: "update_vote.php",  
				data: data,
				cache: false,
				success: function(){
					$('#'+aid).children(".ans_count").html(votes);
				}
			});
		});
		$('.ans_down').click(function(){
			var aid = $(this).closest('div').attr('id');
			var id = $('#'+aid).children('.ans_down').attr('value');
			var data = "change=answer_down&id="+id;
			var votes = $('#'+aid).children(".ans_count").html();
			votes--;
			$.ajax({
				type: "POST",
				url: "update_vote.php",  
				data: data,
				cache: false,
				success: function(){
					$('#'+aid).children(".ans_count").html(votes);
					var vid = '#'+aid;
					if (votes <= -5) {
						$(vid).attr('style','display:none;')
					}
				}
			});
		});
		$('.comm_up').click(function(){
			var aid = $(this).closest('div').attr('id');
			var id = $('#'+aid).children('.comm_up').attr('value');
			var data = "change=comment_up&id="+id;
			var votes = $('#'+aid).children(".comm_count").html(); 
			votes++;
			$.ajax({
				type: "POST",
				url: "update_vote.php",  
				data: data,
				cache: false,
				success: function(){
					$('#'+aid).children(".comm_count").html(votes);
				}
			});
		});
		$('.comm_down').click(function(){
			var aid = $(this).closest('div').attr('id');
			var id = $('#'+aid).children('.comm_down').attr('value');
			var data = "change=comment_down&id="+id;
			var votes = $('#'+aid).children(".comm_count").html();
			votes--;
			$.ajax({
				type: "POST",
				url: "update_vote.php",  
				data: data,
				cache: false,
				success: function(){
					$('#'+aid).children(".comm_count").html(votes);
					var vid = '#'+aid;
					if (votes <= -5) {
						$(vid).attr('style','display:none;')
					}
				}
			});
		});
	});
</script>

<?php include "template_footer.html"; ?>