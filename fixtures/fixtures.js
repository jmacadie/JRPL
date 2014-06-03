var lCompetitors = [];
var lCompetitors2 = [];
var pEventID;

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
		getMatchesData();
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
	var groupOv = $("#ckbLockedMatches").is(':checked');
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
			excPredicted: $("#ckbLockedMatches").is(':checked'),
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
	
	if (data.result == "No") {
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

	} else { // User is logged in ok add results to table

        result = [
            '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tableSessionsContent">',
            '<thead>',
            '<th>Date</th>',
            '<th>Sport</th>',
            '<th>Event</th>',
            '<th>Session</th>',
            '<th>Venue</th>',
            '<th class="center">Closed</th>',
            '<th class="center">Lockdown</th>',
            '<th class="center">Medal</th>',
            '<th class="center">Predictions</th>',
            '<th class="center">WRJoker</th>',
            '</thead>',
            '<tbody>'];
		
		$.each(data.data, function(entryIndex, entry){
			
			// Add row data
            result.push('<tr>');
            result.push('<td>'+ entry['Date'] + ' ' + entry['Time'].slice(0,5) + '</td>');
            result.push('<td>'+ entry['Sport'] + '</td>');
            result.push('<td>'+ '<a href="#" data-eventID="' + entry['EventID'] + '" class="sessionTableLink">' + entry['Event'] + '</a>' + '</td>');
            result.push('<td>'+ entry['Session'] + '</td>');
            result.push('<td>'+ entry['Venue'] + '</td>');
            result.push('<td class="center">'+ entry['Closed'] + '</td>');
            result.push('<td class="center">'+ entry['Lockdown'] + '</td>');
            result.push('<td class="center">'+ entry['Medal'] + '</td>');
            result.push('<td class="center">'+ entry['Predictions'] + '</td>');
            result.push('<td class="center">'+ entry['WRJoker'] + '</td>');
            result.push('</tr>');
			
		});

        result.push('</tbody>');
        result.push('</table>');
		
		// Write the HTML
        $("#matches").html(result.join(''));
		
        // Close Alert
        $("#aGettingMatchData").alert('close');

	}
	
}

		
}