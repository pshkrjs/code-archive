<?php include "template_header.php";
										
$collection = $db->post;
$doc = $collection->findOne(array('_id' => new MongoId($_GET['id'])));
$collection = $db->user;
$id = new MongoId($doc['by']);
$docs = $collection->findOne(array('_id'=>$id));
?>
		<div class="row">
			<div id="announcement_page" class="col l12">
				<div class="row"></div>
				<div class="row">
					<div class="col l6 offset-l3">
						<div class="card">
							<div class="card-content black-text">
								<span class="card-title black-text">Details</span>
								<br><br>Title: <?php echo $doc['title']?>
								<br><br>Description: <?php echo $doc['description']?>
								<br><br>By: <?php echo $docs['name']?>
							</div>
							<div class="card-action">
								<a class="btn waves-effect waves-light"  href="announcement_list.php">Back</a>
							</div>
						</div>
					</div>
				</div>
				<?php  
				if($_SESSION['name'] == $docs['name'])
				{
					?>
					<form action="remove_post.php" method="POST">
					<input value=<?php echo $doc['_id']; ?> name="pid" hidden>
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
<?php include "template_footer.html"; ?>