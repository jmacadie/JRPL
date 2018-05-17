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
          <input type="checkbox" id="ckbPlayedMatches" value="" checked>
          Exclude played matches
          </label>
        </div>
        <div class="checkbox">
          <label>
          <input type="checkbox" id="ckbPredictedMatches" value="">
          Exclude predicted matches
          </label>
        </div>
        <hr>
        <h3>Select Stages / Pools</h3>
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
                <button class="btn btn-sm btn-primary" type="submit" id="btnSelectGroup" data-mode="unselect">Unselect all</button>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupA" value="" checked>
                  <strong>Pool A</strong><br />
                  Egypt, Russia, Saudi Arabia, Uruguay
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupB" value="" checked>
                  <strong>Pool B</strong><br />
                  Iran, Morocco, Portugal, Spain
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupC" value="" checked>
                  <strong>Pool C</strong><br />
                  Australia, Denmark, France, Peru
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupD" value="" checked>
                  <strong>Pool D</strong><br />
                  Argentina, Croatia, Iceland, Nigeria
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupE" value="" checked>
                  <strong>Pool E</strong><br />
                  Brazil, Costa Rica, Serbia, Switzerland
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupF" value="" checked>
                  <strong>Pool F</strong><br />
                  Germany, South Korea, Mexico, Sweden
                  </label>
                </div>
				<div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupG" value="" checked>
                  <strong>Pool G</strong><br />
                  Belguim, England, Panama, Tunisia
                  </label>
                </div>
				<div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupH" value="" checked>
                  <strong>Pool H</strong><br />
                  Colombia, Japan, Poland, Senegal
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="checkbox">
          <label>
          <input type="checkbox" id="ckbR16" value="" checked>
          Round of 16
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
