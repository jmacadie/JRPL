<h1>Tables</h1>
<div id="messageTables"></div>
<hr>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/scoringSystemForm.html.php'; ?>
<hr>
<h3>Overall</h3>
<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#tOverallCont" id="btnOverallCont">
	hide / unhide table
</button>
<div id="tOverallCont" class="collapse in">
	<div class="table-responsive" data-pattern="priority-columns">
		<table class="table table-small-font table-striped">
			<thead>
				<tr>
					<th data-priority="1">Position</th>
					<th>Player</th>
					<th data-priority="2" class="text-center">Predicted</th>
					<th data-priority="2" class="text-center">Correct Results</th>
					<th data-priority="2" class="text-center">Exact Scores</th>
					<th data-priority="1" class="text-center">Points</th>
					<th data-priority="2" class="text-center">Points per Prediction</th>
				</tr>
			</thead>
				<?php foreach ($resultLeague as $row): ?>
				<tr>
					<td><?php if($row['rankCount'] > 1) {
							htmlout($row['rank'] . '=');
						} else {
							htmlout($row['rank']);
						} ?></td>
					<td><?php htmlout($row['name']); ?></td>
					<td class="text-center"><?php if($row['submitted'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['submitted']);
						} ?></td>
					<td class="text-center"><?php if($row['results'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['results']);
						} ?></td>
					<td class="text-center"><?php if($row['scores'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['scores']);
						} ?></td>
					<td class="text-center"><strong><?php if($row['totalPoints'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['totalPoints']);
						} ?></strong></td>
					<td class="text-center"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
							htmlout('-');
						} else {
							htmlout(round($row['totalPoints'] / $row['submitted'], 1));
						} ?></td>
				</tr>
				<?php endforeach; ?>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>
<hr>
<h3>Group Stages</h3>
<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#tGSCont" id="btnGSCont">
	hide / unhide table
</button>
<div id="tGSCont" class="collapse in">
	<div class="table-responsive" data-pattern="priority-columns">
		<table class="table table-small-font table-striped">
			<thead>
				<tr>
					<th data-priority="1">Position</th>
					<th>Player</th>
					<th data-priority="2" class="text-center">Predicted</th>
					<th data-priority="2" class="text-center">Correct Results</th>
					<th data-priority="2" class="text-center">Exact Scores</th>
					<th data-priority="1" class="text-center">Points</th>
					<th data-priority="2" class="text-center">Points per Prediction</th>
				</tr>
			</thead>
				<?php foreach ($resultGSLeague as $row): ?>
				<tr>
					<td><?php if($row['rankCount'] > 1) {
							htmlout($row['rank'] . '=');
						} else {
							htmlout($row['rank']);
						} ?></td>
					<td><?php htmlout($row['name']); ?></td>
					<td class="text-center"><?php if($row['submitted'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['submitted']);
						} ?></td>
					<td class="text-center"><?php if($row['results'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['results']);
						} ?></td>
					<td class="text-center"><?php if($row['scores'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['scores']);
						} ?></td>
					<td class="text-center"><strong><?php if($row['totalPoints'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['totalPoints']);
						} ?></strong></td>
					<td class="text-center"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
							htmlout('-');
						} else {
							htmlout(round($row['totalPoints'] / $row['submitted'], 1));
						} ?></td>
				</tr>
				<?php endforeach; ?>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>
<hr>
<h3>Last 16</h3>
<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#tL16Cont" id="btnL16Cont">
	hide / unhide table
</button>
<div id="tL16Cont" class="collapse in">
	<div class="table-responsive" data-pattern="priority-columns">
		<table class="table table-small-font table-striped">
			<thead>
				<tr>
					<th data-priority="1">Position</th>
					<th>Player</th>
					<th data-priority="2" class="text-center">Predicted</th>
					<th data-priority="2" class="text-center">Correct Results</th>
					<th data-priority="2" class="text-center">Exact Scores</th>
					<th data-priority="1" class="text-center">Points</th>
					<th data-priority="2" class="text-center">Points per Prediction</th>
				</tr>
			</thead>
				<?php foreach ($resultL16League as $row): ?>
				<tr>
					<td><?php if($row['rankCount'] > 1) {
							htmlout($row['rank'] . '=');
						} else {
							htmlout($row['rank']);
						} ?></td>
					<td><?php htmlout($row['name']); ?></td>
					<td class="text-center"><?php if($row['submitted'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['submitted']);
						} ?></td>
					<td class="text-center"><?php if($row['results'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['results']);
						} ?></td>
					<td class="text-center"><?php if($row['scores'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['scores']);
						} ?></td>
					<td class="text-center"><strong><?php if($row['totalPoints'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['totalPoints']);
						} ?></strong></td>
					<td class="text-center"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
							htmlout('-');
						} else {
							htmlout(round($row['totalPoints'] / $row['submitted'], 1));
						} ?></td>
				</tr>
				<?php endforeach; ?>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>
<hr>
<h3>Semi-Finals, Quarter-Finals, 3<sup>rd</sup> 4<sup>th</sup> Place Play-off & Final</h3>
<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#tRCont" id="btnRCont">
	hide / unhide table
</button>
<div id="tRCont" class="collapse in">
	<div class="table-responsive" data-pattern="priority-columns">
		<table class="table table-small-font table-striped">
			<thead>
				<tr>
					<th data-priority="1">Position</th>
					<th>Player</th>
					<th data-priority="2" class="text-center">Predicted</th>
					<th data-priority="2" class="text-center">Correct Results</th>
					<th data-priority="2" class="text-center">Exact Scores</th>
					<th data-priority="1" class="text-center">Points</th>
					<th data-priority="2" class="text-center">Points per Prediction</th>
				</tr>
			</thead>
				<?php foreach ($resultRLeague as $row): ?>
				<tr>
					<td><?php if($row['rankCount'] > 1) {
							htmlout($row['rank'] . '=');
						} else {
							htmlout($row['rank']);
						} ?></td>
					<td><?php htmlout($row['name']); ?></td>
					<td class="text-center"><?php if($row['submitted'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['submitted']);
						} ?></td>
					<td class="text-center"><?php if($row['results'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['results']);
						} ?></td>
					<td class="text-center"><?php if($row['scores'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['scores']);
						} ?></td>
					<td class="text-center"><strong><?php if($row['totalPoints'] == 0) {
							htmlout('-');
						} else {
							htmlout($row['totalPoints']);
						} ?></strong></td>
					<td class="text-center"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
							htmlout('-');
						} else {
							htmlout(round($row['totalPoints'] / $row['submitted'], 1));
						} ?></td>
				</tr>
				<?php endforeach; ?>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>