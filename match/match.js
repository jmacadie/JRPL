// Do stuff when page is ready
$(document).ready(function() {

	// Add click handler to submit prediction button
	$("#btnSubmitPrediction").click(function(e) {
		e.preventDefault();
		submitPrediction($("#matchIDXS").val(), $("#homeScore").val(), $("#awayScore").val());
	});
	
	// Add click handler to submit prediction button for mobile
	$("#btnSubmitPredictionXS").click(function(e) {
		e.preventDefault();
		submitPrediction($("#matchIDXS").val(), $("#homeScoreXS").val(), $("#awayScoreXS").val());
	});

});

// Function to handle getting session data
function submitPrediction(matchID, homeTeamScore, awayTeamScore) {

    // Build HTML for warning message
    var result = [
        '<div class="alert alert-info alert-dismissable">',
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
        'Submitting prediction to database...',
        '</div>'];

    // Output warning message
    $("#updatePrediction").html(result.join(''));
	
	// Make the AJAX call
	$.ajax({
		url: 'submitPrediction.php',
		type: 'POST',
		data: 
			{action: "submitPrediction",
			matchID: matchID,
			homeTeamScore: homeTeamScore,
			awayTeamScore: awayTeamScore},
		dataType: 'json',
		success: function(data) {
			//alert ('Success');
			processSubmitReturn (data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert ('AJAX callback error: ' + textStatus + ', ' + errorThrown); 
		}
	});

}

// Callback function to process the returned data after the prediction has been submitted
function processSubmitReturn (data) {

    var result;
	
	if (data.result === "No") {
	// If result returned no then something went wrong so build and display an error message
		
		// Build HTML for error message
		result = [
			'<div class="alert alert-danger alert-dismissable">',
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
			'<h4>Submit Prediction Error</h4>',
			data.message,
			'</div>'];
				
		// Output error message
		$("#updatePrediction").html(result.join(''));

	} else { // Data came back OK so build and display a success message
		
		// Build HTML for success message
		result = [
			'<div class="alert alert-success alert-dismissable">',
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
			'Prediction successfully submitted',
			'</div>'];
				
		// Output success message
		$("#updatePrediction").html(result.join(''));
		
	}
	
}