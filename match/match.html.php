<h3><?php htmlout($date); ?><br />
	<?php htmlout(substr($kickOff, 0, 5)); ?><br />
	<small><?php htmlout($venue); ?><br/>
	<?php htmlout($broadcaster); ?></small></h3>
<h3>
	<div class="row hidden-xs">
		<div class="col-sm-4 text-right">
			<img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($homeTeamS)); ?>.png">
			<?php htmlout($homeTeam); ?>
		</div>
		<div class="col-sm-4 text-center"><?php htmlout($homeTeamGoals); ?> - <?php htmlout($awayTeamGoals); ?></div>
		<div class="col-sm-4 text-left">
			<?php htmlout($awayTeam); ?>
			<img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($awayTeamS)); ?>.png">
		</div>
	</div>
	<div class="row visible-xs text-left">
		<div class="col-xs-2">
			<img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($homeTeamS)); ?>.png">
		</div>
		<div class="col-xs-6">
			<?php htmlout($homeTeam); ?>
		</div>
		<div class="col-xs-4">
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
		<div class="col-xs-4">
			<?php htmlout($awayTeamGoals); ?>
		</div>
	</div>
</h3>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE): ?>
<hr>
<h4 class="form-heading">Your Prediction</h4>
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
			<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitPrediction">Update</button>
		</div>
	</div>
	<?php if($lockedDown) echo('</fieldset>'); ?>
</form>
<form class="form-horizontal visible-xs" role="form">
	<?php if($lockedDown) echo('<fieldset disabled>'); ?>
	<div class="form-group">
		<label for="homeScore" class="col-xs-8 control-label"><?php htmlout($homeTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="homeScore" name="homeScore" value="">
		</div>
	</div>
	<div class="form-group">
		<label for="awayScore" class="col-xs-8 control-label"><?php htmlout($awayTeam); ?></label>
		<div class="col-xs-4">
			<input type="number" class="form-control" id="awayScore" name="awayScore" value="">
		</div>
	</div>
	<button class="btn btn-sm btn-primary" type="submit" id="btnSubmitPredictionXS">Update</button>
	<?php if($lockedDown) echo('</fieldset>'); ?>
</form>
<div id="updatePrediction"></div>
<?php endif; ?>
<hr>
<h4>All Predictions</h4>
<?php if ($lockedDown): ?>
<?php else: ?>
<i>Match not yet locked down, come back when it is...</i>
<?php endif; ?>