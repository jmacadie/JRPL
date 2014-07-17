<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#t<?php echo($sID); ?>" id="btn<?php echo($sID); ?>">
	Hide / unhide table
</button>
<div id="t<?php echo($sID); ?>" class="collapse in">
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
				<?php foreach ($rLeague as $row): ?>
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
							$out = (int($row['results'])) ? round($row['results']) : $row['results'];
							htmlout($out);
						} ?></td>
					<td class="text-center"><?php if($row['scores'] == 0) {
							htmlout('-');
						} else {
							$out = (int($row['scores'])) ? round($row['scores']) : $row['scores'];
							htmlout($out);
						} ?></td>
					<td class="text-center"><strong><?php if($row['totalPoints'] == 0) {
							htmlout('-');
						} else {
							$out = (int($row['totalPoints'])) ? round($row['totalPoints']) : $row['totalPoints'];
							htmlout($out);
						} ?></strong></td>
					<td class="text-center"><?php if(($row['submitted'] == 0) || ($row['totalPoints'] == 0)) {
							htmlout('-');
						} else {
							htmlout(round($row['totalPoints'] / $row['submitted'], 2));
						} ?></td>
				</tr>
				<?php endforeach; ?>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>