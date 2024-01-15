<?php
include 'template_header.php';
$id = new MongoId($_GET['id']);
$collection = $db->user;
$document = $collection->findOne(array('_id'=>$id));
?>
<div class="row"></div>
<div class="row">
	<div class="col l6 offset-l3">
		<div class="card black-text">
			<div class="row"></div>
			<div class="col l10 offset-l1">
				<span class="card-title black-text">Notifications</span>
				<div class="card-content">
					<span class="card-title black-text"><small><?php $count = count($document['notifications']['answers']); echo $count; ?> unseen Answer(s).</small></span><br>
					<?php
					foreach ($document['notifications']['answers'] as $doc) {
						?> New answer on <?php
						$collection = $db->post;
						$post = $collection->findOne(array('_id'=>new MongoId($doc)));
						$link = 'question_page.php?id='.$post['_id'];
						?><a id="<?php echo $post['_id']; ?>" name=<?php echo $_SESSION['id']; ?> class="answer"><?php echo $post['title']; ?></a><br><?php
					}
					?>
					<span class="card-title black-text"><small><?php $count = count($document['notifications']['comments']); echo $count; ?> unseen Comment(s).</small></span><br>
					<?php
					foreach ($document['notifications']['comments'] as $doc) {
						?> New comment on <?php
						$collection = $db->post;
						$post = $collection->findOne(array('_id'=>new MongoId($doc)));
						$link = 'question_page.php?id='.$post['_id'];
						?><a id="<?php echo $post['_id']; ?>" name=<?php echo $_SESSION['id']; ?> class="comment"><?php echo $post['title']; ?></a><br><?php
					}
					?>
				</div>
			</div>
			<div class="row"></div>
		</div>
	</div>
</div>
<div class="row"></div>

<script>
	$(document).ready(function(){
		$('a.answer').click(function(){
			var id = $(this).attr('id');
			var from = $(this).attr('name');
			var data = "remove=answer&id="+id+"&from="+from;
			$.ajax({
				type: "POST",
				url: "remove_notification.php", // Database name search 
				data: data,
				cache: false,
				success: function(msg){
					console.log(msg);
					if (msg=='fail') {
						window.location.href="main.php";
					}else{
						window.location.href = "question_page.php?id="+id;
					}
				}
			});
		});
		$('a.comment').click(function(){
			var id = $(this).attr('id');
			var from = $(this).attr('name');
			var data = "remove=comment&id="+id+"&from="+from;
			$.ajax({
				type: "POST",
				url: "remove_notification.php", // Database name search 
				data: data,
				cache: false,
				success: function(msg){
					console.log(msg);
					if (msg=='fail') {
						window.location.href="notifications.php?id="+<?php echo json_encode(new MongoId($_SESSION['id'])); ?>;
					}else{
						window.location.href = "question_page.php?id="+id;
					}
				}
			});
		});
	});
</script>

<?php include 'template_footer.html'; ?>