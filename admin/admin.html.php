<!-- TODO: check for Admin -->
<div id="matchesMessage"></div>
<div class="panel-group" id="accordionUsers">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse"
           data-parent="#accordionUsers"
           href="#collapseUsers">
          Reset User Password
        </a>
      </h4>
    </div>
    <div id="collapseUsers" class="panel-collapse collapse">
      <div class="panel-body">
      <?php if (isset($users)) : ?>
        <div class="row">
        <form class="form-inline" role="form">
          <div class="col-sm-5 text-left">
            <select class="form-control" id="userReset">
              <option value="0" selected>- - -</option>
            <?php foreach ($users as $row) : ?>
              <option value = "<?php echo($row['userID']); ?>">
                <?php echo($row['name']); ?>
              </option>
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
      <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div id="usersMessage"></div>
