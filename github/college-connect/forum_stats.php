<?php include 'template_header.php'; ?>
<div class="row"></div>
<div class="row">
	<div class="col l6 offset-l3">
		<div class="card black-text">
		<div class="col l10 offset-l1">
			<span class="card-title black-text">Forum Statistics</span>
			<div class="col l6 offset-l3">
				<table class="highlight">
					<thead>
						<tr>
							<th>Department</th>
							<th>Question Count</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$map_question = new MongoCode("function() { emit(this.department,1); }");
						$reduce_question = new MongoCode("function(k, vals) { ".
    									"var sum = 0;".
    									"for (var i in vals) {".
    									    "sum += vals[i];". 
    									"}".
    									"return sum; }");
						$questions = $db->command(array(
    									"mapreduce" => "post", 
    									"map" => $map_question,
    									"reduce" => $reduce_question,
    									"query" => array("type" => "Question"),
    									"out" => array("replace" => "questionCount")));
						$collection = $db->selectCollection($questions['result']);
						$cursor = $collection->find();
						foreach ($cursor as $document) {
							?>
							<tr>
								<td><?php echo $document['_id']; ?></td>
								<td><?php echo $document['value']; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<table class="highlight">
					<thead>
						<tr>
							<th>Department</th>
							<th>Answer Count</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$map_answer = new MongoCode("function() { for(var i=0;i<this.answers.length;i++){emit(this.department,1);} }");
						$reduce_answer = new MongoCode("function(k, vals) { return Array.sum(vals); }");
						$answers = $db->command(array(
    									"mapreduce" => "post", 
    									"map" => $map_answer,
    									"reduce" => $reduce_answer,
    									"query" => array("type" => "Question"),
    									"out" => array("replace" => "answerCount")));
						$collection = $db->selectCollection($answers['result']);
						$cursor = $collection->find();
						foreach ($cursor as $document) {
							?>
							<tr>
								<td><?php echo $document['_id']; ?></td>
								<td><?php echo $document['value']; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<table class="highlight">
					<thead>
						<tr>
							<th>Department</th>
							<th>Comment Count</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$map_comment = new MongoCode("function() { for(var i=0;i<this.comments.length;i++){emit(this.department,1);} }");
						$reduce_comment = new MongoCode("function(k, vals) { return Array.sum(vals); }");
						$comments = $db->command(array(
    									"mapreduce" => "post", 
    									"map" => $map_comment,
    									"reduce" => $reduce_comment,
    									"query" => array("type" => "Question"),
    									"out" => array("replace" => "commentCount")));
						$collection = $db->selectCollection($comments['result']);
						$cursor = $collection->find();
						foreach ($cursor as $document) {
							?>
							<tr>
								<td><?php echo $document['_id']; ?></td>
								<td><?php echo $document['value']; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
</div>
<div class="row"></div>
<?php include 'template_footer.html'; ?>