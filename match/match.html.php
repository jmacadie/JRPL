<div class="row">
  <div class="col-xs-6 text-left"><a href="<?php echo($prev); ?>">&lt; Previous Match</a></div>
  <div class="col-xs-6 text-right"><a href="<?php echo($next); ?>">Next Match &gt;</a></div>
</div>
<h3><?php htmlout($stage); ?><br />
  <?php htmlout($date); ?><br />
  <?php htmlout(substr($kickOff, 0, 5)); ?><br />
  <small><?php htmlout($venue); ?><br/>
  <?php htmlout($broadcaster); ?></small>
</h3>
<h3>
  <!-- Layout for tablets and bigger -->
  <div class="row hidden-xs">
    <div class="col-sm-2 text-center"><img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeFlag); ?>.png"></div>
    <div class="col-sm-2 text-right">
      <span class="lead"><?php htmlout($homeTeam); ?></span>
      <br />
      <button id="btnHomeOrigin" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
    <div class="col-sm-1 text-center lead"><b><span id="homeTeamGoals"><?php htmlout($homeTeamGoals); ?></span></b></div>
    <div class="col-sm-2 text-center">vs.</div>
    <div class="col-sm-1 text-center lead"><b><span id="awayTeamGoals"><?php htmlout($awayTeamGoals); ?></span></b></div>
    <div class="col-sm-2 text-left lead">
      <span class="lead"><?php htmlout($awayTeam); ?></span>
      <br />
      <button id="btnAwayOrigin" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
    <div class="col-sm-2 text-center"><img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayFlag); ?>.png"></div>
  </div>
  <!-- Team origin details for tablets and bigger -->
  <div class="row hidden-xs text-left">
    <div class="col-sm-5">
      <div id="homeOrigin" class="panel panel-default" style="display: none;">
        <div class="panel-body">
        <a href="../match/?id=<?php htmlout($homeTeamMatchID); ?>&ring=<?php htmlout($_GET['ring']) ?>">
        <div class="row text-center"><p>
          <div class="col-xs-12"><?php htmlout($homeTeamStage); ?></div>
        </p></div>
        <small>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($homeTeamHomeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeHomeFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($homeTeamHomeTeam); ?></div>
            <div class="col-xs-3 text-left"><?php htmlout($homeTeamHomeTeamGoals); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($homeTeamAwayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeAwayFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($homeTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamAwayTeamGoals); ?></div>
          </p></div>
        </small>
        </a>
        </div>
      </div>
    </div>
    <div class="col-sm-5 col-sm-offset-2">
      <div id="awayOrigin" class="panel panel-default" style="display: none;">
        <div class="panel-body">
        <a href="../match/?id=<?php htmlout($awayTeamMatchID); ?>&ring=<?php htmlout($_GET['ring']) ?>">
        <div class="row text-center"><p>
          <div class="col-xs-12"><?php htmlout($awayTeamStage); ?></div>
        </p></div>
        <small>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($awayTeamHomeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayHomeFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($awayTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamHomeTeamGoals); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($awayTeamAwayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayAwayFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($awayTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamAwayTeamGoals); ?></div>
          </p></div>
        </small>
        </a>
        </div>
      </div>
    </div>
  </div>
  <!-- Layout for phones -->
  <div class="row visible-xs text-left">
    <div class="col-xs-2">
      <img alt="<?php htmlout($homeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeFlag); ?>.png">
    </div>
    <div class="col-xs-6">
      <?php htmlout($homeTeam); ?>
    </div>
    <div class="col-xs-4" id="homeTeamGoalsXS">
      <?php htmlout($homeTeamGoals); ?>
    </div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-2">
      <button id="btnHomeOriginXS" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-12">
      <div id="homeOriginXS" class="panel panel-default" style="display: none;">
        <div class="panel-body">
        <a href="../match/?id=<?php htmlout($homeTeamMatchID); ?>&ring=<?php htmlout($_GET['ring']) ?>">
        <div class="row text-center"><p>
          <div class="col-xs-12"><?php htmlout($homeTeamStage); ?></div>
        </p></div>
        <small>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($homeTeamHomeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeHomeFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($homeTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamHomeTeamGoals); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($homeTeamAwayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($homeAwayFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($homeTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamAwayTeamGoals); ?></div>
          </p></div>
        </small>
        </a>
        </div>
      </div>
    </div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-6 col-xs-offset-2"><small>vs.</small></div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-2">
      <img alt="<?php htmlout($awayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayFlag); ?>.png">
    </div>
    <div class="col-xs-6">
      <?php htmlout($awayTeam); ?>
    </div>
    <div class="col-xs-4" id="awayTeamGoalsXS">
      <?php htmlout($awayTeamGoals); ?>
    </div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-2">
      <button id="btnAwayOriginXS" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
  </div>
  <div class="row visible-xs text-left">
    <div class="col-xs-12">
      <div id="awayOriginXS" class="panel panel-default" style="display: none;">
        <div class="panel-body">
        <a href="../match/?id=<?php htmlout($awayTeamMatchID); ?>&ring=<?php htmlout($_GET['ring']) ?>">
        <div class="row text-center"><p>
          <div class="col-xs-12"><?php htmlout($awayTeamStage); ?></div>
        </p></div>
        <small>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($awayTeamHomeTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayHomeFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($awayTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamHomeTeamGoals); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><img alt="<?php htmlout($awayTeamAwayTeam); ?>" class="flag" src="../assets/img/flags/<?php htmlout($awayAwayFlag); ?>.png"></div>
            <div class="col-xs-6"><?php htmlout($awayTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamAwayTeamGoals); ?></div>
          </div>
        </small>
        </a>
        </div>
      </div>
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
<?php if($lockedDown) echo('<p><i>Match locked down. No more updates to predictions possible</i></p>'); ?>
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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/scoringSystemForm.html.php'; ?>
<hr>
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
        echo(' win</b><br/>');
        htmlout($result['HomeTeamPrediction']);
        echo(' - ');
        htmlout($result['AwayTeamPrediction']);
      } elseif ($result['HomeTeamPrediction'] < $result['AwayTeamPrediction']) {
        htmlout($result['AwayTeam']);
        echo(' win</b><br/>');
        htmlout($result['AwayTeamPrediction']);
        echo(' - ');
        htmlout($result['HomeTeamPrediction']);
      } else {
        echo('Draw</b><br/>');
        htmlout($result['HomeTeamPrediction']);
        echo(' - ');
        htmlout($result['AwayTeamPrediction']);
      } ?>
      </td>
      <td><?php if($result['TotalPoints'] == 0) {
          htmlout('-');
        } else {
          $out = (int($result['TotalPoints'])) ? round($result['TotalPoints']) : $result['TotalPoints'];
          htmlout($out);
        } ?></td>
      <?php if ($result['HomeTeamPrediction'] == 'No prediction') { echo('</i>'); }; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
<p><i>Match not yet locked down. Come back when it is...</i></p>
<?php endif; ?>
<div class="row">
  <div class="col-xs-6 text-left"><a href="<?php echo($prev); ?>">&lt; Previous Match</a></div>
  <div class="col-xs-6 text-right"><a href="<?php echo($next); ?>">Next Match &gt;</a></div>
</div>