<?php

  // Check for existence of prev variable
  if (!isset($prev)) {
    if (isset($_GET['id'])) {
      $prev = $_GET['id'] - 1;
    } elseif (isset($_SESSION['matchID'])) {
      $prev = $_SESSION['matchID'] - 1;
    } else {
      $prev = 1;
    }
    $prev = max($prev, 1);
  }

  // Check for existence of next variable
  if (!isset($next)) {
    if (isset($_GET['id'])) {
      $next = $_GET['id'] + 1;
    } elseif (isset($_SESSION['matchID'])) {
      $next = $_SESSION['matchID'] + 1;
    } else {
      $next = 1;
    }
    $next = min($prev, 64);
  }

  // Check for existence of stage variable
  if (!isset($stage))
    $stage = "";

  // Check for existence of date variable
  if (!isset($date))
    $date  = "";

  // Check for existence of kickOff variable
  if (!isset($kickOff))
    $kickOff= "";

  // Check for existence of venue variable
  if (!isset($venue))
    $venue= "";

  // Check for existence of broadcaster variable
  if (!isset($broadcaster))
    $broadcaster = "";

  // Check for existence of homeTeam variable
  if (!isset($homeTeam))
    $homeTeam = "";

  // Check for existence of homeFlag variable
  if (!isset($homeFlag))
    $homeFlag = "";

  // Check for existence of homeTeamMatchID variable
  if (!isset($homeTeamMatchID))
    $homeTeamMatchID = "";

  // Check for existence of homeTeamStage variable
  if (!isset($homeTeamStage))
    $homeTeamStage = "";

  // Check for existence of homeTeamPoints variable
  if (!isset($homeTeamPoints))
    $homeTeamPoints = "";

  // Check for existence of homeTeamHomeTeam variable
  if (!isset($homeTeamHomeTeam))
    $homeTeamHomeTeam = "";

  // Check for existence of homeTeamHomeTeamPoints variable
  if (!isset($homeTeamHomeTeamPoints))
    $homeTeamHomeTeamPoints = "";

  // Check for existence of homeHomeFlag variable
  if (!isset($homeHomeFlag))
    $homeHomeFlag = "";

  // Check for existence of homeTeamAwayTeam variable
  if (!isset($homeTeamAwayTeam))
    $homeTeamAwayTeam = "";

  // Check for existence of homeTeamAwayTeamPoints variable
  if (!isset($homeTeamAwayTeamPoints))
    $homeTeamAwayTeamPoints = "";

  // Check for existence of homeAwayFlag variable
  if (!isset($homeAwayFlag))
    $homeAwayFlag = "";

  // Check for existence of homeTeamPredPoints variable
  if (!isset($homeTeamPredPoints))
    $homeTeamPredPoints = "";

  // Check for existence of awayTeam variable
  if (!isset($awayTeam))
    $awayTeam = "";

  // Check for existence of awayFlag variable
  if (!isset($awayFlag))
    $awayFlag = "";

  // Check for existence of awayTeamMatchID variable
  if (!isset($awayTeamMatchID))
    $awayTeamMatchID = "";

  // Check for existence of awayTeamStage variable
  if (!isset($awayTeamStage))
    $awayTeamStage = "";

  // Check for existence of awayTeamPoints variable
  if (!isset($awayTeamPoints))
    $awayTeamPoints = "";

  // Check for existence of awayTeamHomeTeam variable
  if (!isset($awayTeamHomeTeam))
    $awayTeamHomeTeam = "";

  // Check for existence of awayTeamHomeTeamPoints variable
  if (!isset($awayTeamHomeTeamPoints))
    $awayTeamHomeTeamPoints = "";

  // Check for existence of awayHomeFlag variable
  if (!isset($awayHomeFlag))
    $awayHomeFlag = "";

  // Check for existence of awayTeamAwayTeam variable
  if (!isset($awayTeamAwayTeam))
    $awayTeamAwayTeam = "";

  // Check for existence of awayTeamAwayTeamPoints variable
  if (!isset($awayTeamAwayTeamPoints))
    $awayTeamAwayTeamPoints = "";

  // Check for existence of awayAwayFlag variable
  if (!isset($awayAwayFlag))
    $awayAwayFlag = "";

  // Check for existence of awayTeamPredPoints variable
  if (!isset($awayTeamPredPoints))
    $awayTeamPredPoints = "";

  // Check for existence of lockedDown variable
  if (!isset($lockedDown))
    $lockedDown = false;

  // Check for existence of matchID variable
  if (!isset($matchID))
    $matchID = 1;

?>
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
    <div class="col-sm-2 text-center"><span class="team-flag flag-<?php htmlout(strtoupper($homeFlag)); ?>"></span></div>
    <div class="col-sm-2 text-right">
      <span class="lead"><?php htmlout($homeTeam); ?></span>
      <br />
      <button id="btnHomeOrigin" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
    <div class="col-sm-1 text-center lead"><b><span id="homeTeamPoints"><?php htmlout($homeTeamPoints); ?></span></b></div>
    <div class="col-sm-2 text-center">vs.</div>
    <div class="col-sm-1 text-center lead"><b><span id="awayTeamPoints"><?php htmlout($awayTeamPoints); ?></span></b></div>
    <div class="col-sm-2 text-left lead">
      <span class="lead"><?php htmlout($awayTeam); ?></span>
      <br />
      <button id="btnAwayOrigin" type="button" class="btn btn-info btn-xs" data-state="show">Show Origin</button>
    </div>
    <div class="col-sm-2 text-center"><span class="team-flag flag-<?php htmlout(strtoupper($awayFlag)); ?>"></span></div>
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
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($homeHomeFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($homeTeamHomeTeam); ?></div>
            <div class="col-xs-3 text-left"><?php htmlout($homeTeamHomeTeamPoints); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($homeAwayFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($homeTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamAwayTeamPoints); ?></div>
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
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($awayHomeFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($awayTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamHomeTeamPoints); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($awayAwayFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($awayTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamAwayTeamPoints); ?></div>
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
      <span class="team-flag flag-<?php htmlout(strtoupper($homeFlag)); ?>"></span>
    </div>
    <div class="col-xs-6">
      <?php htmlout($homeTeam); ?>
    </div>
    <div class="col-xs-4" id="homeTeamPointsXS">
      <?php htmlout($homeTeamPoints); ?>
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
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($homeHomeFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($homeTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamHomeTeamPoints); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($homeAwayFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($homeTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($homeTeamAwayTeamPoints); ?></div>
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
      <span class="team-flag flag-<?php htmlout(strtoupper($awayFlag)); ?>"></span>
    </div>
    <div class="col-xs-6">
      <?php htmlout($awayTeam); ?>
    </div>
    <div class="col-xs-4" id="awayTeamPointsXS">
      <?php htmlout($awayTeamPoints); ?>
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
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($awayHomeFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($awayTeamHomeTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamHomeTeamPoints); ?></div>
          </p></div>
          <div class="row"><p>
            <div class="col-xs-3 text-right"><span class="team-flag flag-<?php htmlout(strtoupper($awayAwayFlag)); ?>"></span></div>
            <div class="col-xs-6"><?php htmlout($awayTeamAwayTeam); ?></div>
            <div class="col-xs-3"><?php htmlout($awayTeamAwayTeamPoints); ?></div>
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
      <input type="number" class="form-control" id="homeScoreRes" name="homeScore" value="<?php htmlout($homeTeamPoints); ?>">
    </div>
    <div class="col-sm-2">
      <input type="number" class="form-control" id="awayScoreRes" name="awayScore" value="<?php htmlout($awayTeamPoints); ?>">
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
      <input type="number" class="form-control" id="homeScoreResXS" name="homeScoreXS" value="<?php htmlout($homeTeamPoints); ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="awayScore" class="col-xs-8 control-label"><?php htmlout($awayTeam); ?></label>
    <div class="col-xs-4">
      <input type="number" class="form-control" id="awayScoreResXS" name="awayScoreXS" value="<?php htmlout($awayTeamPoints); ?>">
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
      <input type="number" class="form-control" id="homeScore" name="homeScore" value="<?php htmlout($homeTeamPredPoints); ?>">
    </div>
    <div class="col-sm-2">
      <input type="number" class="form-control" id="awayScore" name="awayScore" value="<?php htmlout($awayTeamPredPoints); ?>">
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
      <input type="number" class="form-control" id="homeScoreXS" name="homeScoreXS" value="<?php htmlout($homeTeamPredPoints); ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="awayScore" class="col-xs-8 control-label"><?php htmlout($awayTeam); ?></label>
    <div class="col-xs-4">
      <input type="number" class="form-control" id="awayScoreXS" name="awayScoreXS" value="<?php htmlout($awayTeamPredPoints); ?>">
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
<h5>Graph</h5>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseUsers">
          Select Users
        </a>
      </h4>
    </div>
    <div id="collapseUsers" class="panel-collapse collapse">
      <div class="panel-body">
        <?php $j=0; $i=0; ?>
        <?php foreach($arrPredictions as $result): ?>
        <?php if($j==0): ?>
        <div class="row">
          <?php endif; ?>
          <?php $j++; $i++; ?>
          <div class="col-xs-6 col-sm-3">
            <div class="checkbox">
              <label>
                <input
                type="checkbox"
                value="<?php htmlout($i - 1); ?>"
                <?php
                  if (isset($_SESSION['loggedIn']) &&
                      $_SESSION['loggedIn'] == TRUE &&
                      isset($_SESSION['displayName']) &&
                      $_SESSION['displayName'] == $result['DisplayName'])
                    { echo('checked'); }?>>
                <?php htmlout($result['DisplayName']); ?>
              </label>
            </div>
          </div>
          <?php if($j==4): ?>
          <?php $j=0; ?>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<div id="graph"></div>
<hr>
<h5>Table</h5>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Player</th>
      <th>Prediction</th>
      <th>Points</th>
    </tr>
  </thead>
  <tbody>
    <?php if (isset($arrPredictions)) :?>
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
    <?php endif; ?>
  </tbody>
</table>
<?php else: ?>
<p><i>Match not yet locked down. Come back when it is...</i></p>
<?php endif; ?>
<div class="row">
  <div class="col-xs-6 text-left"><a href="<?php echo($prev); ?>">&lt; Previous Match</a></div>
  <div class="col-xs-6 text-right"><a href="<?php echo($next); ?>">Next Match &gt;</a></div>
</div>
