<h1>Tables</h1>
<div id="messageTables"></div>
<h3>Overall</h3>
<div class="table-responsive" data-pattern="priority-columns">
	<table class="table table-small-font table-striped" id ="tOverall">
		<thead>
			<tr>
				<th data-priority="1">Position</th>
				<th>Player</th>
				<th data-priority="2">Predicted</th>
				<th data-priority="2">Correct Results</th>
				<th data-priority="2">Exact Scores</th>
				<th data-priority="1">Total Points</th>
				<th data-priority="2">Points per Prediction</th>
			</tr>
		</thead>
			<?php foreach ($resultLeague as $row): ?>
			<tr>
				<td><?php htmlout($row['rank']); ?></td>
				<td><?php htmlout($row['name']); ?></td>
				<td><?php if($row['submitted'] == 0) {
						htmlout('-');
					} else {
						htmlout($row['submitted']);
					} ?></td>
				<td><?php if($row['results'] == 0) {
						htmlout('-');
					} else {
						htmlout($row['results']);
					} ?></td>
				<td><?php if($row['scores'] == 0) {
						htmlout('-');
					} else {
						htmlout($row['scores']);
					} ?></td>
				<td><?php if($row['totalPoints'] == 0) {
						htmlout('-');
					} else {
						htmlout($row['totalPoints']);
					} ?></td>
				<td><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
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