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
                  Australia, England, Wales, Fiji, Uruguay
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupB" value="" checked>
                  <strong>Pool B</strong><br />
                  South Africa,Samoa, Japan, Scotland, USA
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupC" value="" checked>
                  <strong>Pool C</strong><br />
                  New Zealand, Argentina, Tonga, Georgia, Namibia
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="ckbGroupD" value="" checked>
                  <strong>Pool D</strong><br />
                  France, Ireland, Italy, Canada, Romania
                  </label>
                </div>
              </div>
            </div>
          </div>
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
          <input type="checkbox" id="ckb34PlayOff" value="" checked>
          3<sup>rd</sup> 4<sup>th</sup> Place Play-off
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
