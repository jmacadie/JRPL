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
		<img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($homeTeamS)); ?>.png">
		<?php htmlout($homeTeam); ?> <?php htmlout($homeTeamGoals); ?>
	</div>
	<div class="row visible-xs text-left">
		<?php htmlout($awayTeam); ?> <?php htmlout($awayTeamGoals); ?>
		<img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout(strtolower($awayTeamS)); ?>.png">
	</div>
</h3>
<form role="form">
	<h4 class="form-heading">Prediction</h4>
	<div class="form-group">
		<label for="homeScore"><?php htmlout($homeTeam); ?></label>
		<input type="text" class="form-control" id="homeScore" name="homeScore"
			value="">
	</div>
	<div class="form-group">
		<label for="awayScore"><?php htmlout($awayTeam); ?></label>
		<input type="text" class="form-control" id="awayScore" name="awayScore"
			value="">
	</div>
	<div id="updatePrediction"></div>
	<button class="btn btn-sm btn-primary" type="submit" id="updateBtn">Update</button>
</form>