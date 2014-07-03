<!-- TODO: check for Admin -->
<div class="panel-group" id="accordionTournamentRoles">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordionTournamentRoles" href="#collapseTournamentRoles">
				  Set Tournament Roles
				</a>
			</h4>
		</div>
		<div id="collapseTournamentRoles" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="panel-group" id="accordionTRGroup">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordionTRGroup" href="#collapseTRGroup">
									Groups
								</a>
							</h4>
						</div>
						<div id="collapseTRGroup" class="panel-collapse collapse">
							<div class="panel-body">
								<?php foreach ($arrTournamentRoles as $row) : ?>
									<?php if($row['stage'] == 'Group') : ?>
										<form class="form-inline" role="form">
											<label for=""><b><?php echo($row['tournamentRole']); ?>:</b></label>
											<select class="form-control" id="">
												<option value="0" <?php if($row['teamID'] === NULL) echo('selected'); ?>> - - - </option>
												<?php foreach ($row['selectTeam'] as $team) : ?>
													<?php if($team['id'] !=== NULL) : ?>
														<option value = "<?php echo($team['id']); ?>" <?php if($team['id'] === $row['teamID']) echo('selected'); ?>><?php echo($team['name']); ?></option>
													<?php endif; ?>
												<?php endforeach; ?>
											</select>
											<button type="submit" class="btn btn-primary">Update</button>
										</form>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group" id="accordionTRLast16">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordionTRLast16" href="#collapseTRLast16">
									Last 16
								</a>
							</h4>
						</div>
						<div id="collapseTRLast16" class="panel-collapse collapse">
							<div class="panel-body">
								
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group" id="accordionTRQuarterFinal">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordionTRQuarterFinal" href="#collapseTRQuarterFinal">
									Quarter-Final
								</a>
							</h4>
						</div>
						<div id="collapseTRQuarterFinal" class="panel-collapse collapse">
							<div class="panel-body">
								
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group" id="accordionTRSemiFinal">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordionTRSemiFinal" href="#collapseTRSemiFinal">
									Semi-Final
								</a>
							</h4>
						</div>
						<div id="collapseTRSemiFinal" class="panel-collapse collapse">
							<div class="panel-body">
								
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group" id="accordionTRFinal">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordionTRFinal" href="#collapseTRFinal">
									Final
								</a>
							</h4>
						</div>
						<div id="collapseTRFinal" class="panel-collapse collapse">
							<div class="panel-body">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="matchesMessage"></div>