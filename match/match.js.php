<script src="match.js"></script>
<?php if ($lockedDown): ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});

  // Variables to hold the data for the three charts
  var dataPoints;
  var maxScale;

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(function (){

    // Load the data - only need do this once
    var tmp = initDataPoints();
    dataPoints = tmp.data;
    maxScale = tmp.maxScale;

    // Draw the charts
    drawChart(dataPoints, maxScale);
  });

  // Add click handler to all user checkboxes
  $(document).ready(function() {
    $('#collapseUsers').find('[type=checkbox]').click(function(e) {
      drawChart(dataPoints);
    });
  });

  // Create trigger to resizeEnd event
  $(window).resize(function() {
    if(this.resizeTo) clearTimeout(this.resizeTo);
    this.resizeTo = setTimeout(function() {
      $(this).trigger('resizeEnd');
    }, 500);
  });

  // Redraw graph when window resize is completed
  $(window).on('resizeEnd', function() {
    drawChart(dataPoints, maxScale);
  });

  // A function to initialise the points data
  function initDataPoints() {

    var data = new google.visualization.DataTable();

    var predictions = [
      <?php foreach ($arrPredictions as $result): ?>
      <?php $ht = ($result['HomeTeamPrediction'] == 'No prediction') ?
                  0 : $result['HomeTeamPrediction']; ?>
      <?php $at = ($result['AwayTeamPrediction'] == 'No prediction') ?
                  0 : $result['AwayTeamPrediction']; ?>
      {name: '<?php htmlout($result['DisplayName']); ?>'
      ,home: <?php htmlout($ht); ?>
      ,away: <?php htmlout($at); ?> },
      <?php endforeach; ?>
    ];

    <?php if ($homeTeamPoints != null): ?>
    var result = { home: <?php htmlout($homeTeamPoints); ?>
                  ,away: <?php htmlout($awayTeamPoints); ?> };
    <?php endif; ?>

    var l = predictions.length;

    // Add columns
    data.addColumn('number');
    for (var i = 0; i < l; i++) {
      data.addColumn('number', predictions[i].name);
    }
    <?php if ($homeTeamPoints != null): ?>
    data.addColumn('number', 'Result');
    <?php endif; ?>
    data.addColumn('number', 'Win Line');
    data.addColumn({ type:'string', role:'tooltip' });

    // Add data
    var maxScore = 0;
    for (var i = 0; i < l; i++) {
      data.addRow();
      data.setCell(i, 0, predictions[i].home);
      data.setCell(i, i + 1, predictions[i].away);
      <?php if ($homeTeamPoints != null): ?>
      data.setCell(i, l + 3, predictions[i].name);
      <?php else: ?>
      data.setCell(i, l + 2, predictions[i].name);
      <?php endif; ?>
      maxScore = (predictions[i].home > maxScore) ? predictions[i].home : maxScore;
      maxScore = (predictions[i].away > maxScore) ? predictions[i].away : maxScore;
    }

    <?php if ($homeTeamPoints != null): ?>
    // Add result to max score
    maxScore = (result.home > maxScore) ? result.home : maxScore;
    maxScore = (result.away > maxScore) ? result.away : maxScore;
    <?php endif; ?>

    maxScore = (Math.floor((maxScore - 1) / 5) + 1) * 5;

    <?php if ($homeTeamPoints != null): ?>
    // Add result
    data.addRow();
    data.setCell(l, 0, result.home);
    data.setCell(l, l + 1, result.away);
    data.setCell(l, l + 3, 'Result');
    <?php endif; ?>

    // Add win line
    data.addRow();
    <?php if ($homeTeamPoints != null): ?>
    data.setCell(l + 1, 0, 0);
    data.setCell(l + 1, l + 2, 0);
    data.setCell(l + 1, l + 3, '');
    data.addRow();
    data.setCell(l + 2, 0, maxScore);
    data.setCell(l + 2, l + 2, maxScore);
    data.setCell(l + 2, l + 3, '');
    <?php else: ?>
    data.setCell(l, 0, 0);
    data.setCell(l, l + 1, 0);
    data.setCell(l, l + 2, '');
    data.addRow();
    data.setCell(l + 1, 0, maxScore);
    data.setCell(l + 1, l + 1, maxScore);
    data.setCell(l + 1, l + 2, '');
    <?php endif; ?>

    return { data: data, maxScale: maxScore };
  }

  // Build up series array for
  function getSeries() {
    // get all elements in the form
    var series = [];
    var $ckb;
    var j;
    var max = 0;
    // loop through the elements
    // grab colour if checked or grey if not
    // make sure they're sorted right!
    $('#collapseUsers').find('[type=checkbox]').each(function (index) {
      $ckb = $(this);
      j = $ckb.attr('value') * 1;
      max = (j > max) ? j : max;
      if ($ckb.is(':checked')) {
        series[j] = { visibleInLegend: true, pointSize: 6 };
      } else {
        series[j] = { color: '#888', visibleInLegend: false, pointSize: 2 };
      }
    });
    // Add styling for win line and result
    <?php if ($homeTeamPoints != null): ?>
    series[max + 1] = { color: '#bd162d', visibleInLegend: true, pointSize: 20, pointShape: { type: 'star', sides: 4, rotation: 45, dent: 0.2 } };
    series[max + 2] = { color: '#dddddd', visibleInLegend: false, pointSize: 0, lineWidth: 2};
    <?php else: ?>
    series[max + 1] = { color: '#dddddd', visibleInLegend: false, pointSize: 0, lineWidth: 2};
    <?php endif; ?>
    return series;
  }

  // Callback that creates the options for the three charts and then draws them
  function drawChart(data, scale) {

    // Determine the dimensions
    var h = $(window).height();
    var w = $(window).width();
    // Max width
    w = Math.min(w, 700);
    // Padding
    h -= 90;
    w -= 30;
    // Keep 9 x 5 dimensions
    if (h > w) {
      h = w;
    } else {
      w = h;
    }

    // Set the options
    var lines = (scale / 5) + 1;
    var options = {
      height: h,
      width: w,
      lineWidth: 0,
      pointSize: 4,
      legend: { position: 'top' },
      hAxis: { title: '<?php htmlout($homeTeam); ?>', textPosition: 'out', baselineColor: 'transparent', gridlines: { color: '#f4f4f4', count: lines }, maxValue: scale, minValue: 0 },
      vAxis: { title: '<?php htmlout($awayTeam); ?>', textPosition: 'out', baselineColor: 'transparent', gridlines: { color: '#f4f4f4', count: lines }, maxValue: scale, minValue: 0} ,
      crosshair: { trigger: 'both', orientation: 'both' },
      series: getSeries()
    };

    // Draw the chart
    var chart = new google.visualization.LineChart(document.getElementById('graph'));
    chart.draw(data, options);
  }

</script>
<?php endif; ?>
