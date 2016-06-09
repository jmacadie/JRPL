<!-- TODO: check for Admin -->
<div class="panel-group" id="accordionTournamentRoles">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse"
           data-parent="#accordionTournamentRoles"
           href="#collapseTournamentRoles">
          Set Tournament Roles
        </a>
      </h4>
    </div>
    <div id="collapseTournamentRoles" class="panel-collapse collapse">
      <div class="panel-body">
        <?php
          $stage = 'Group Stages';
          include 'stage.html.php';
        ?>
        <?php
          $stage = 'Round of 16';
          include 'stage.html.php';
        ?>
        <?php
          $stage = 'Quarter Finals';
          include 'stage.html.php';
        ?>
        <?php
          $stage = 'Semi Finals';
          include 'stage.html.php';
        ?>
        <?php
          $stage = 'Final';
          include 'stage.html.php';
        ?>
      </div>
    </div>
  </div>
</div>
<div id="matchesMessage"></div>
