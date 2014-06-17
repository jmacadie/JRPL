<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});
	
	// Varaibles to hold the data for the three charts
	var dataPoints;
	var dataRel;
	var dataPos;
	
	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(function (){
		// Load the data - only need do this once
		dataPoints = initDataPoints();
		dataRel = initDataRelPoints();
		dataPos = initDataPosition();
		// Draw the charts
		drawChart(dataPoints,dataRel,dataPos);
	});
	
	// Add click handler to all user checkboxes
	$(document).ready(function() {
		
		$('#collapseUsers').find('[type=checkbox]').click(function(e) {
			drawChart(dataPoints,dataRel,dataPos);
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
		drawChart(dataPoints,dataRel,dataPos);
	});
	
	// A function to initialise the points data
	function initDataPoints() {

		var tmp = new google.visualization.DataTable();
		
		// Add columns
		tmp.addColumn('string', 'Match');
		<?php for($i=0; $i<=$numUsers-1; $i++): ?>
		tmp.addColumn('number', '<?php htmlout($data[$i]['name']); ?>');
		<?php endfor; ?>

		// Add empty rows
		tmp.addRows(<?php htmlout($numMatches); ?>);
		
		// Add the data
		<?php for($i=0; $i<=$numMatches-1; $i++): ?>
		tmp.setCell(<?php htmlout($i); ?>, 0, '<?php htmlout($data[($i*$numUsers)]['match']); ?>');
		<?php for($j=0; $j<=$numUsers-1; $j++): ?>
		tmp.setCell(<?php htmlout($i); ?>, <?php htmlout($j + 1); ?>, '<?php htmlout($data[(($i*$numUsers) + $j)]['points']); ?>');
		<?php endfor; ?>
		<?php endfor; ?>
		
		return tmp;
	}
	
	// A function to initialise the points data
	function initDataRelPoints() {

		var tmp = new google.visualization.DataTable();
		
		// Add columns
		tmp.addColumn('string', 'Match');
		<?php for($i=0; $i<=$numUsers-1; $i++): ?>
		tmp.addColumn('number', '<?php htmlout($data[$i]['name']); ?>');
		<?php endfor; ?>

		// Add empty rows
		tmp.addRows(<?php htmlout($numMatches); ?>);
		
		// Add the data
		<?php for($i=0; $i<=$numMatches-1; $i++): ?>
		tmp.setCell(<?php htmlout($i); ?>, 0, '<?php htmlout($data[($i*$numUsers)]['match']); ?>');
		<?php $max = 0;
		for($k=0; $k<=$numUsers-1; $k++) {
			$max = max($max, $data[(($i*$numUsers) + $k)]['points']);
		} ?>
		<?php for($j=0; $j<=$numUsers-1; $j++): ?>
		tmp.setCell(<?php htmlout($i); ?>, <?php htmlout($j + 1); ?>, '<?php htmlout($max - $data[(($i*$numUsers) + $j)]['points']); ?>');
		<?php endfor; ?>
		<?php endfor; ?>
		
		return tmp;
	}
	
	// A function to initialise the position data
	function initDataPosition() {

		var tmp = new google.visualization.DataTable();
		
		// Add columns
		tmp.addColumn('string', 'Match');
		<?php for($i=0; $i<=$numUsers-1; $i++): ?>
		tmp.addColumn('number', '<?php htmlout($data[$i]['name']); ?>');
		<?php endfor; ?>

		// Add empty rows
		tmp.addRows(<?php htmlout($numMatches); ?>);
		
		// Add the data
		<?php for($i=0; $i<=$numMatches-1; $i++): ?>
		tmp.setCell(<?php htmlout($i); ?>, 0, '<?php htmlout($data[($i*$numUsers)]['match']); ?>');
		<?php for($j=0; $j<=$numUsers-1; $j++): ?>
		tmp.setCell(<?php htmlout($i); ?>, <?php htmlout($j + 1); ?>, '<?php htmlout($data[(($i*$numUsers) + $j)]['rank']); ?>');
		<?php endfor; ?>
		<?php endfor; ?>
		
		return tmp;
	}
	
	// Build up series array for 
	function getSeries() {

	// get all elements in the form
	var series =[];
	var $ckb;
	var j;

	// loop through the elements
	// grab clour if checked or grey if not
	// make sure they're sorted right!
	$('#collapseUsers').find('[type=checkbox]').each(function( index ) {
		$ckb = $(this);
		j = $ckb.attr('value')*1 - 1;
		if ($ckb.is(':checked')) {
			series[j] = {visibleInLegend: true, pointSize: 2, lineWidth: 2};
		} else {
			series[j] = {color: '#dddddd', visibleInLegend: false, pointSize: 0, lineWidth: 1};
		}
	});

	return series;
		
	}
	
	// Callback that creates the options for the three charts and then draws them
	function drawChart(dataPoints,dataRel,dataPos) {
		
		// Determine the dimensions
		var h = $(window).height();
		var w = $(window).width();
		
		// Max width
		w = Math.min(w,700);
		
		// Padding
		h -= 90;
		w -= 30;
		
		// Keep 9 x 5 dimensions
		if ((h / 5 * 9) > w) {
			h = w / 9 * 5;
		} else {
			w = h / 5 * 9;
		}
		
		// Set the options
		var options = {
			chartArea: {width:'100%', height:'100%'},
			height: h,
			width: w,
			legend: {position: 'in'},
			hAxis: {textPosition: 'none'},
			vAxis: {textPosition: 'none'},
			series: getSeries()};
		
		// Draw the chart
        var chart = new google.visualization.LineChart(document.getElementById('cPoints'));
        chart.draw(dataPoints, options);
		
		// Draw the chart
        var chart = new google.visualization.LineChart(document.getElementById('cRelPoints'));
        chart.draw(dataRel, options);
		
		// Set the options
		options = {
			chartArea: {width:'100%', height:'100%'},
			height: h,
			width: w,
			legend: {position: 'in'},
			hAxis: {textPosition: 'none'},
			vAxis: {textPosition: 'none', direction: -1},
			series: getSeries()};
		
		// Draw the chart
        chart = new google.visualization.LineChart(document.getElementById('cPosition'));
        chart.draw(dataPos, options);
		
	}
	
</script>