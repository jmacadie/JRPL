<h1>Graphs</h1>
<hr>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/scoringSystemForm.html.php'; ?>
<hr>
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
        <?php $j=0; ?>
        <?php if (isset($numUsers) && isset ($data)) : ?>
        <?php for($i=0; $i<=$numUsers-1; $i++): ?>
        <?php if($j==0): ?>
        <div class="row">
          <?php endif; ?>
          <?php $j++; ?>
          <div class="col-xs-6 col-sm-3">
            <div class="checkbox">
              <label>
                <input
                type="checkbox"
                value="<?php htmlout($i); ?>"
                <?php
                  if (isset($_SESSION['loggedIn']) &&
                      $_SESSION['loggedIn'] == TRUE &&
                      isset($_SESSION['userID']) &&
                      $_SESSION['userID'] == $data[$i]['userID'])
                    { echo('checked'); }?>>
                <?php htmlout($data[$i]['name']); ?>
              </label>
            </div>
          </div>
          <?php if($j==4): ?>
          <?php $j=0; ?>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<hr>
<h3>Overall Points</h3>
<div id="cPoints"></div>
<hr>
<h3>Relative Points</h3>
<div id="cRelPoints"></div>
<hr>
<h3>Position</h3>
<div id="cPosition"></div>
