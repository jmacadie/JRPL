<h1>Tables</h1>
<div id="messageTables"></div>
<h3>Overall</h3>
<table class="table table-striped" id ="tOverall">
	<thead>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th  class="hidden-xs">Predicted</th>
			<th>Correct Results</th>
			<th>Exact Scores</th>
			<th>Total Points</th>
			<th  class="hidden-xs">Points per Prediction</th>
		</tr>
	</thead>
		<?php foreach ($resultLeague as $row): ?>
		<tr>
			<td><?php htmlout($row['rank']); ?></td>
			<td><?php htmlout($row['name']); ?></td>
			<td  class="hidden-xs"><?php if($row['submitted'] == 0) {
					htmlout('-');
				} else {
					htmlout($row['submitted']);
				} ?></td>
			<td><?php if($row['resultPoints'] == 0) {
					htmlout('-');
				} else {
					htmlout($row['resultPoints']);
				} ?></td>
			<td><?php if($row['scorePoints'] == 0) {
					htmlout('-');
				} else {
					htmlout($row['scorePoints']);
				} ?></td>
			<td><?php if($row['totalPoints'] == 0) {
					htmlout('-');
				} else {
					htmlout($row['totalPoints']);
				} ?></td>
			<td class="hidden-xs"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
					htmlout('-');
				} else {
					htmlout(round($row['totalPoints'] / $row['submitted'], 1));
				} ?></td>
		</tr>
		<?php endforeach; ?>
	<tbody>	
	</tbody>
</table>