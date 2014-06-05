// Do stuff when page is ready
$(document).ready(function() {

    // Initial call to pull in match data
    // do it asynchronously so page loads quicker
    // check table exists first
    if ($("#matches").length) {
        getMatchesData();
    }

	// Add click handler to update filter button
	$("#btnUpdateMatches").click(function(e) {
		e.preventDefault();
		$("#collapseFilters").collapse('hide'); // collapse the filters section
		$("#collapseGroup").collapse('hide'); // collapse the filters section
		getMatchesData();
	});
	
	// Add click handler to select / unselect all group stages button
	$("#btnSelectGroup").click(function(e) {
		e.preventDefault();
		selectAllGroups($(this).attr('data-mode'));
	});
	
	// Add click handler to all group stages checkbox
	$("#ckbGroupStage").click(function(e) {
		e.preventDefault();
		disableAllGroups($(this).is(':checked'));
	});

});

// Function to handle getting session data
function getMatchesData() {

    // Build HTML for warning message
    var result = [
        '<div class="alert alert-info alert-dismissable" id="aGettingMatchData">',
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
        'Getting data fom database...',
        '</div>'];

    // Output warning message
    $("#matchesMessage").html(result.join(''));
	
	// Sort out the group stage filters
	var groupOv = $("#ckbGroupStage").is(':checked');
	var groupA = groupOv && $("#ckbGroupA").is(':checked');
	var groupB = groupOv && $("#ckbGroupB").is(':checked');
	var groupC = groupOv && $("#ckbGroupC").is(':checked');
	var groupD = groupOv && $("#ckbGroupD").is(':checked');
	var groupE = groupOv && $("#ckbGroupE").is(':checked');
	var groupF = groupOv && $("#ckbGroupF").is(':checked');
	var groupG = groupOv && $("#ckbGroupG").is(':checked');
	var groupH = groupOv && $("#ckbGroupH").is(':checked');
	
	// Make the AJAX call
	$.ajax({
		url: 'getMatches.php',
		type: 'POST',
		data: 
			{action: "updateMatches",
			excLocked: $("#ckbLockedMatches").is(':checked'),
			excPredicted: $("#ckbPredictedMatches").is(':checked'),
			groupA: groupA,
			groupB: groupB,
			groupC: groupC,
			groupD: groupD,
			groupE: groupE,
			groupF: groupF,
			groupG: groupG,
			groupH: groupH,
			last16: $("#ckbLast16").is(':checked'),
			quarterFinals: $("#ckbQuarterFinals").is(':checked'),
			semiFinals: $("#ckbSemiFinals").is(':checked'),
			final: $("#ckbFinal").is(':checked')},
		dataType: 'json',
		success: function(data) {
			//alert ('Success');
			processMatchesReturn (data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert ('AJAX callback error: ' + textStatus + ', ' + errorThrown); 
		}
	});

}

// Callback function to process the returned data when filters are updated (or page is first loaded)
function processMatchesReturn (data) {

    var result;
	
	if (data.result === "No") {
	// If result returned no then something went wrong so build and display an error message
		
		// Build HTML for error message
		result = [
			'<div class="alert alert-danger alert-dismissable">',
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
			'<h4>Match Data Error</h4>',
			data.message,
			'</div>'];
				
		// Output error message
		$("#matchesMessage").html(result.join(''));

	} else { // Data came back OK so build HTML and then display it
		
		var date = '';
		var time = '';
		
		// Initialise the result variable as an empty array, 
		// bits of HTML will be pushed onto it and finally the whole
		// thing will be joined to output
        result = [];
		
		$.each(data.data, function(entryIndex, entry){
			
			// Display Date Header if the first Match or date has changed
			if ((entryIndex === 0) || (entry['Date'] != date)) {
				date = entry['Date'];
				result.push('<h3>' + date + '</h3>');
			}
			
			// Display Time Header if the first Match or kick-off has changed
			if ((entryIndex === 0) || (entry['KickOff'] != time)) {
				time = entry['KickOff'];
				result.push('<h4>' + time.slice(0,5) + '</h4>');
			}
			
			// Add mark-up for a single match
			
			// Wrap whole row in a link to the relevant match page
			result.push('<div class="matchRow">');
            result.push('<a href="../match?id=' + entry['MatchID'] + '">');
			
			// Have own row to show flags on phones, in-line on anything bigger
            result.push('<div class="row visible-xs">');
			result.push('<div class="col-xs-4 text-center"><img alt="' + entry['HomeTeam'] + '" class="flag" src="../assets/img/flags/' + entry['HomeTeamS'].toLowerCase() + '.png"></div>');
			result.push('<div class="col-xs-4 col-xs-offset-4 text-center"><img alt="' + entry['AwayTeam'] + '" class="flag" src="../assets/img/flags/' + entry['AwayTeamS'].toLowerCase() + '.png"></div>');
			result.push('</div>');
			
			// Main row with team names, flags and result on
			result.push('<div class="row">');
			result.push('<div class="col-sm-2 hidden-xs text-center"><img alt="' + entry['HomeTeam'] + '" class="flag" src="../assets/img/flags/' + entry['HomeTeamS'].toLowerCase() + '.png"></div>'); // in-line flag for devices bigger than a phone
			result.push('<div class="col-xs-4 visible-xs text-center">' + entry['HomeTeam'] + '</div>'); // Centred name for phones
			result.push('<div class="col-sm-2 hidden-xs text-right">' + entry['HomeTeam'] + '</div>'); // Full name for tablets & desktops
			result.push('<div class="col-xs-1 text-center">' + ((entry['HomeTeamGoals'] === null) ? '' : entry['HomeTeamGoals']) + '</div>'); // Score
			result.push('<div class="col-xs-2 text-center">vs.</div>'); // Divider
			result.push('<div class="col-xs-1 text-center">' + ((entry['AwayTeamGoals'] === null) ? '' : entry['AwayTeamGoals']) + '</div>'); // Score
			result.push('<div class="col-sm-2 hidden-xs text-left">' + entry['AwayTeam'] + '</div>'); // Full name for tablets & desktops
			result.push('<div class="col-xs-4 visible-xs text-center">' + entry['AwayTeam'] + '</div>');  // Centred name for phones
			result.push('<div class="col-sm-2 hidden-xs text-center"><img alt="' + entry['AwayTeam'] + '" class="flag" src="../assets/img/flags/' + entry['AwayTeamS'].toLowerCase() + '.png"></div>'); // in-line flag for devices bigger than a phone
			result.push('</div>');
			
			// Row for prediction, if logged in
			if (data.loggedIn === 1) {
				result.push('<div class="row">');
				if (entry['HomeTeamPoints'] === null) {
					result.push('Not yet predicted');
				} else {
					result.push('Predicted: ' + entry['HomeTeamPoints'] + ' - ' + entry['AwayTeamPoints']);
				}
				result.push('</div>');
			}
			
			// Row for locked down status
			if (entry['LockedDown'] === 1) {
				result.push('<div class="row">');
				result.push('Locked Down');
				result.push('</div>');
			}
			
			// Close link and wrapping div
            result.push('</a>');
			result.push('</div>');
			
		});
		
		// Write the HTML
        $("#matches").html(result.join(''));
		
        // Close "Getting data" alert
        $("#aGettingMatchData").alert('close');

	}
	
}

function selectAllGroups (mode) {
	
	// see if we're selecting or unselecting
	if (mode === 'unselect') {
		// Change all the checkbox states to unchecked
		$('#collapseGroup').find('[type=checkbox]').prop('checked',false);
		// Change button text back to select all
		$("#btnSelectGroup").text('Select All').attr('data-mode','select');
	} else {
		// Change all the checkbox states to checked
		$('#collapseGroup').find('[type=checkbox]').prop('checked',true);
		// Change button text back to unselect all
		$("#btnSelectGroup").text('Unselect All').attr('data-mode','unselect');
	}
	
}

function disableAllGroups (mode) {
	
	// see if we're disabling or enabling
	if (mode === true) {
		// Enable all the checkboxes
		$('#collapseGroup').find('[type=checkbox]').prop('disabled', false);
	} else {
		// Disable all the checkboxes
		$("#btnSelectGroup").text('Unselect All').prop('disabled', true);
	}
	
}