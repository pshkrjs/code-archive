<?php include "template_header.php"; 
?>
	<div class="row">
		<div class="col l12">
			<ul class="tabs">
				<li class="tab col l4"><a href="#announcement_tab" class="active">Announcements</a></li>
				<li class="tab col l4"><a href="#qna_tab" class="active">Question and Answers</a></li>
			</ul>
		</div>
		<div id="announcement_tab" class="col l12">
			<div class="row"></div>
			<div class="row">
				<div class="col l6 offset-l3">
					<div class="card">
						<div class="card-content black-text">
							<span class="card-title black-text">Recent Announcements</span>
							<div class="row">
								<div class="col l10 offset-l1">
									<table class="highlight">
										<thead>
											<tr>
												<th data-field="title">Title</th>
												<th data-field="on">Posted On</th>
												<th data-field="by">Posted By</th>
											</tr>
										</thead>
										<?php
										$collection = $db->post;
										if ($_SESSION['type']=='staff') {
											$cursor = $collection->find(array('type' => 'Announcement'))->limit(5)->sort(array('date'=>-1));
										}else{
											$cursor = $collection->find(array('type' => 'Announcement','department' => array('$in' => array('tnp','gen',$_SESSION['department']))))->limit(5)->sort(array('date'=>-1));
										}
										$count = $cursor->count();
										?>
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
								</div>
						<div class="card-action valign-wrapper">
							<a class="valign-center btn waves-effect waves-light white-text" style="background: #40c4ff;" href="announcement_list.php?page=1">More Announcements</a>
	    		    		<?php if ($_SESSION['type']=='staff') { ?>
	    		    		<form action="announcement_new.php" method="POST">
	    		    			<button class="valign-center btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="login">Add announcement</button>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
include "template_footer.html"; 
?>
		<div id="qna_tab" class="col l12">
			<div class="row"></div>
			<div class="row">
				<div class="col l6 offset-l3">
					<div class="card">
						<div class="card-content black-text">
							<span class="card-title black-text">Recent Questions</span>
							<div class="row">
								<div class="col l10 offset-l1">
									<table class="highlight">
										<thead>
											<tr>
												<th data-field="title">Title</th>
												<th data-field="on">Posted On</th>
												<th data-field="by">Posted By</th>
											</tr>
										</thead>
									<?php
									$collection = $db->post;
									$cursor = $collection->find(array('type' => 'Question'))->sort(array('date' => -1))->limit(5);
									$count = $cursor->count();
									if ($count) 
									{
										foreach ($cursor as $document)
										{		
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
									</table>
								</div>
								</div>
						<div class="card-action valign-wrapper">
							<a class="valign-center btn waves-effect waves-light white-text" style="background: #40c4ff;" href="question_list.php?page=1">More Questions</a>
	   
	    		    		<form action="question_new.php" method="POST" >
	    		    			<button class="valign-center btn waves-effect waves-light" style="background: #40c4ff" type="submit" name="login">Add Question</button>
							</form>
					</div>
					</div>
				</div>
			</div>
		</div>
<?php 
include "template_footer.html"; 
?>
