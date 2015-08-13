<form class="form-inline" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="scoringSystem">Scoring System:</label>
    <select class="form-control" name="scoringSystem">
      <?php foreach ($arrSS as $row): ?>
        <option value = "<?php htmlout($row['ScoringSystemID']); ?>"
        <?php if($row['ScoringSystemID'] === $_SESSION['scoringSystem']) echo('selected'); ?>>
          <?php htmlout($row['Name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-default">Change</button>
  <input type="hidden" name="_submit_check" value="1"/>
</form>
