<div class="row">
	<div class="col-xs-6 text-left"><a href="<?php echo($prev); ?>">&lt; Previous Match</a></div>
	<div class="col-xs-6 text-right"><a href="<?php echo($next); ?>">Next Match &gt;</a></div>
</div>
<h3><?php htmlout($date); ?><br />
	<?php htmlout(substr($kickOff, 0, 5)); ?><br />
	<small><?php htmlout($venue); ?><br/>
	<?php htmlout($broadcaster); ?></small>
</h3>
<h3>
	<!-- Layout for tablets and bigger -->
	<div class="row hidden-xs">
		<div class="col-sm-4 text-right">
			<img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($homeTeamS)); ?>.png">
			<?php htmlout($homeTeam); ?>
		</div>
		<div class="col-sm-4 text-center">
			<span id="homeTeamGoals"><?php htmlout($homeTeamGoals); ?></span>
			-
			<span id="awayTeamGoals"><?php htmlout($awayTeamGoals); ?></span>
		</div>
		<div class="col-sm-4 text-left">
			<?php htmlout($awayTeam); ?>
			<img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($awayTeamS)); ?>.png">
		</div>
	</div>
	<!-- Layout for phones -->
	<div class="row visible-xs text-left">
		<div class="col-xs-2">
			<img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($homeTeamS)); ?>.png">
		</div>
		<div class="col-xs-6">
			<?php htmlout($homeTeam); ?>
		</div>
		<div class="col-xs-4" id="homeTeamGoalsXS">
			<?php htmlout($homeTeamGoals); ?>
		</div>
	</div>
	<div class="row visible-xs text-left">
		<div class="col-xs-6 col-xs-offset-2"><small>vs.</small></div>
	</div>
	<div class="row visible-xs text-left">
		<div class="col-xs-2">
			<img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($awayTeamS)); ?>.png">
		</div>
		<div class="col-xs-6">
			<?php htmlout($awayTeam); ?>
		</div>
		<div class="col-xs-4" id="awayTeamGoalsXS">
			<?php htmlout($awayTeamGoals); ?>
		</div>
	</div>
</h3>
<?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == TRUE && $lockedDown): ?>
<!-- Admin post result section -->
<hr>
<h4 class="form-heading">Post Result</h4>
<!-- Layout for tablets and bigger -->
<form class="hidden-xs" role="form">
	<?php if(!$lockedDown) echo('<fieldset disabled>'); ?>
	<div class="row form-group">
		<div class="col-sm-4 text-right">
			<label for="homeScore"><?php htmlout($homeTeam); ?></label>
		</div>
		<div class="col-sm-2">
			<input type="number" class="form-control" id="homeScoreRes" name="homeScore" value="<?php htmlout($homeTeamGoals); ?>">
		</div>
		<div class="col-sm-2">
			<input type="number" class="form-control" id="awayScoreRes" name="awayScore" value="<?php htmlout($awayTeamGoals); ?>">
		</div>
		<div class="col-sm-4 text-left">
			<label for="awayScore"><?php htmlout($awayTeam); ?></label>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-sm-12 text-center">
			<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitRes">Submit</button>
		</div>
	</div>
	<input type="hidden" name="matchID" id="matchIDRes" value="<?php htmlout($matchID); ?>">
	<?php if($lockedDown) echo('</fieldset>'); ?>
</form>
<!-- Layout for phones -->
<form class="form-horizontal visible-xs" role="form">
	<div class="form-group">
		<label for="homeScore" class="col-xs-8 control-label"><?php htmlout($homeTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="homeScoreResXS" name="homeScoreXS" value="<?php htmlout($homeTeamGoals); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="awayScore" class="col-xs-8 control-label"><?php htmlout($awayTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="awayScoreResXS" name="awayScoreXS" value="<?php htmlout($awayTeamGoals); ?>">
		</div>
	</div>
	<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitResXS">Submit</button>
	<input type="hidden" name="matchID" id="matchIDResXS" value="<?php htmlout($matchID); ?>">
</form>
<div id="updateRes"></div>
<?php endif; ?>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE): ?>
<hr>
<h4 class="form-heading">Your Prediction</h4>
<?php if($lockedDown) echo('<i>Match locked down. No more updates to predictions possible</i><br />'); ?>
<!-- Layout for tablets and bigger -->
<form class="hidden-xs" role="form">
	<?php if($lockedDown) echo('<fieldset disabled>'); ?>
	<div class="row form-group">
		<div class="col-sm-4 text-right">
			<label for="homeScore"><?php htmlout($homeTeam); ?></label>
		</div>
		<div class="col-sm-2">
			<input type="number" class="form-control" id="homeScore" name="homeScore" value="<?php htmlout($homeTeamPredGoals); ?>">
		</div>
		<div class="col-sm-2">
			<input type="number" class="form-control" id="awayScore" name="awayScore" value="<?php htmlout($awayTeamPredGoals); ?>">
		</div>
		<div class="col-sm-4 text-left">
			<label for="awayScore"><?php htmlout($awayTeam); ?></label>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-sm-12 text-center">
			<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitPrediction">Submit</button>
		</div>
	</div>
	<input type="hidden" name="matchID" id="matchID" value="<?php htmlout($matchID); ?>">
	<?php if($lockedDown) echo('</fieldset>'); ?>
</form>
<!-- Layout for phones -->
<form class="form-horizontal visible-xs" role="form">
	<?php if($lockedDown) echo('<fieldset disabled>'); ?>
	<div class="form-group">
		<label for="homeScore" class="col-xs-8 control-label"><?php htmlout($homeTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="homeScoreXS" name="homeScoreXS" value="<?php htmlout($homeTeamPredGoals); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="awayScore" class="col-xs-8 control-label"><?php htmlout($awayTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="awayScoreXS" name="awayScoreXS" value="<?php htmlout($awayTeamPredGoals); ?>">
		</div>
	</div>
	<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitPredictionXS">Submit</button>
	<input type="hidden" name="matchID" id="matchIDXS" value="<?php htmlout($matchID); ?>">
	<?php if($lockedDown) echo('</fieldset>'); ?>
</form>
<div id="updatePrediction"></div>
<?php endif; ?>
<hr>
<h4>All Predictions</h4>
<?php if ($lockedDown): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Player</th>
			<th>Prediction</th>
			<th>Points</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($arrPredictions as $result): ?>
		<tr>
			<?php if ($result['HomeTeamPrediction'] == 'No prediction') { echo('<i>'); }; ?>
			<td><?php htmlout($result['DisplayName']); ?></td>
			<td><b>
			<?php if($result['HomeTeamPrediction'] == 'No prediction') {
				echo('No prediction');
			} elseif($result['HomeTeamPrediction'] > $result['AwayTeamPrediction']) {
				htmlout($result['HomeTeam']);
				echo(' win<br/>');
				htmlout($result['HomeTeamPrediction']);
				echo(' - ');
				htmlout($result['AwayTeamPrediction']);
			} elseif ($result['HomeTeamPrediction'] < $result['AwayTeamPrediction']) {
				htmlout($result['AwayTeam']);
				echo(' win<br/>');
				htmlout($result['AwayTeamPrediction']);
				echo(' - ');
				htmlout($result['HomeTeamPrediction']);
			} else {
				echo('Draw<br/>');
				htmlout($result['HomeTeamPrediction']);
				echo(' - ');
				htmlout($result['AwayTeamPrediction']);
			} ?>
			</b>
			</td>
			<td><?php if($result['TotalPoints'] == 0) {
					htmlout('-');
				} else {
					htmlout($result['TotalPoints']);
				} ?></td>
			<?php if ($result['HomeTeamPrediction'] == 'No prediction') { echo('</i>'); }; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
<i>Match not yet locked down. Come back when it is...</i><br />
<?php endif; ?>
<div class="row">
	<div class="col-xs-6 text-left"><a href="<?php echo($prev); ?>">&lt; Previous Match</a></div>
	<div class="col-xs-6 text-right"><a href="<?php echo($next); ?>">Next Match &gt;</a></div>
</div>