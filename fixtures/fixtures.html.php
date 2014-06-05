<h1>Fixtures</h1>
<div class="panel-group" id="accordionFilters">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordionFilters" href="#collapseFilters">
				  Filters
				</a>
			</h4>
		</div>
		<div id="collapseFilters" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbLockedMatches" value="">
					Exclude locked-down matches
				  </label>
				</div>
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbPredictedMatches" value="">
					Exclude predicted matches
				  </label>
				</div>
				<hr>
				<h3>Select Stages / Groups</h3>
				<div class="panel-group" id="accordionGroup">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="checkbox">
							  <label>
								<input type="checkbox" id="ckbGroupStage" value="" checked>
								Group Stage
							  </label>
							</div>
							<a data-toggle="collapse" data-parent="#accordionGroup" href="#collapseGroup">
								Hide / unhide
							</a>
						</div>
						<div id="collapseGroup" class="panel-collapse collapse">
							<div class="panel-body">
								<button class="btn btn-sm btn-info" type="submit" id="btnSelectGroup" data-mode="unselect">Unselect all</button>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupA" value="" checked>
									<strong>Group A</strong><br />
									Brazil, Croatia, Mexico, Cameroon
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupB" value="" checked>
									<strong>Group B</strong><br />
									Spain, Netherlands, Chile, Australia
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupC" value="" checked>
									<strong>Group C</strong><br />
									Columbia, Greece, Ivory Coast, Japan
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupD" value="" checked>
									<strong>Group D</strong><br />
									Uruguay, Costa Rica, England, Italy
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupE" value="" checked>
									<strong>Group E</strong><br />
									Switzerland, Ecuador, France, Honduras
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupF" value="" checked>
									<strong>Group F</strong><br />
									Argentina, Bosnia and Herzegovina, Iran, Nigeria
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupG" value="" checked>
									<strong>Group G</strong><br />
									Germany, Portugal, Ghana, USA
								  </label>
								</div>
								<div class="checkbox">
								  <label>
									<input type="checkbox" id="ckbGroupH" value="" checked>
									<strong>Group H</strong><br />
									Belgium, Algeria, Russia, South Korea
								  </label>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbLast16" value="" checked>
					Last 16
				  </label>
				</div>
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbQuarterFinals" value="" checked>
					Quarter-finals
				  </label>
				</div>
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbSemiFinals" value="" checked>
					Semi-finals
				  </label>
				</div>
				<div class="checkbox">
				  <label>
					<input type="checkbox" id="ckbFinal" value="" checked>
					Final
				  </label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" id="btnUpdateMatches">Update</button>
			</div>
		</div>
	</div>
</div>
<div id="matchesMessage"></div>
<div id="matches"></div>
