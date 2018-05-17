<?php if (isset($stage)) : ?>
  <?php
    switch($stage) {
      case 'Group Stages' : $shortStage = "Group"; break;
      case 'Round of 16' : $shortStage = "R16"; break;
      case 'Quarter Finals' : $shortStage = "QuarterFinal"; break;
      case 'Semi Finals' : $shortStage = "SemiFinal"; break;
	  case 'Third Fourth Place Play-off' : $shortStage = "34PlayOff"; break;
      case 'Final' : $shortStage = "Final"; break;
    }
  ?>
        <div class="panel-group" id="accordionTR<?php echo($shortStage); ?>">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse"
                   data-parent="#accordionTR<?php echo($shortStage); ?>"
                   href="#collapseTR<?php echo($shortStage); ?>">
                  <?php echo($stage); ?>
                </a>
              </h4>
            </div>
            <div id="collapseTR<?php echo($shortStage); ?>"
                 class="panel-collapse collapse">
              <div class="panel-body">
  <?php if (isset($arrTournamentRoles)) : ?>
    <?php foreach ($arrTournamentRoles as $row) : ?>
      <?php if($row['stage'] == $stage) : ?>
                <div class="row">
                <form class="form-inline" role="form">
                  <div class="col-sm-5 text-left">
                    <label for="tr-<?php echo($row['tournamentRoleID']); ?>">
                      <?php echo($row['tournamentRole']); ?>:
                    </label>
        <?php $flag = ($row['teamS'] === NULL) ? 'tmp' : strtolower($row['teamS']); ?>
                    <img width="80" hieght="40" alt="<?php echo($row['team']); ?>"
                         class="flag"
                         src="../assets/img/flags/<?php echo($flag); ?>.png">
                    <span class="tr-team"><?php echo($row['team']); ?></span>
                  </div>
                  <div class="col-sm-5 text-left">
                    <select class="form-control"
                            id="tr-<?php echo($row['tournamentRoleID']); ?>">
                      <option value="0"
                              <?php if($row['teamID'] === NULL) echo('selected'); ?>>
                        - - -
                      </option>
        <?php foreach ($row['selectTeam'] as $team) : ?>
          <?php if($team['id'] != NULL) : ?>
                      <option value = "<?php echo($team['id']); ?>"
                              <?php if($team['id'] === $row['teamID'])
                                      echo('selected'); ?>>
                        <?php echo($team['name']); ?>
                      </option>
          <?php endif; ?>
        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-sm-2 text-center">
                    <button type="submit" class="btn btn-primary">
                      Update
                    </button>
                  </div>
                </form>
                </div>
                <div class="row">
                  <div class="messageTR col-sm-12"></div>
                </div>
                <hr>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>
