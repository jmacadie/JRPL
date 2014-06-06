<h3>[Date & Time]</h3>
<h3>
	<div class="row hidden-xs">
		<div class="col-sm-4 text-right">
			<img alt="Bazil" class="flag" src="../assets/img/flags/bra.png">
			[One Team]
		</div>
		<div class="col-sm-4 text-center">[s1] - [s2]</div>
		<div class="col-sm-4 text-left">
			[Another]
			<img alt="Croatia" class="flag" src="../assets/img/flags/cro.png">
		</div>
	</div>
	<div class="row visible-xs text-left">
		<img alt="Bazil" class="flag" src="../assets/img/flags/bra.png">
		[One Team] [s1]
	</div>
	<div class="row visible-xs text-left">
		[Another] [s2]
		<img alt="Croatia" class="flag" src="../assets/img/flags/cro.png">
	</div>
</h3>
<form role="form">
	<h2 class="form-heading">Prediction</h2>
	<div class="form-group">
		<label for="homeScore">[One Team]</label>
		<input type="text" class="form-control" id="homeScore" name="homeScore"
			value="">
	</div>
	<div class="form-group">
		<label for="awayScore">[Another]</label>
		<input type="text" class="form-control" id="awayScore" name="awayScore"
			value="">
	</div>
	<div id="updatePrediction"></div>
	<button class="btn btn-sm btn-primary" type="submit" id="updateBtn">Update</button>
</form>