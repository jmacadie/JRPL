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
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="btnUpdateMatches">Update</button>
      </div>
    </div>
  </div>
</div>
<div id="matchesMessage"></div>
<div id="matches"></div>
