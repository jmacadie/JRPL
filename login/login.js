$(document).ready(function() {

	// Add click handler to log in button
	$("#logInBtn").click(function(e) {

		e.preventDefault();
        doLogIn();

    });

	// Set a handler to process return key press as form submit
	$(document).keydown(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			doLogIn();
		};
	});

});

function doLogIn() {

    // Send request
    $.post("../includes/login.php",

        {action: "login",
            email: $("#logInEmail").val(),
            password: $("#logInPassword").val(),
			rememberMe: $("#logInRemeberMe").is(':checked')},

        function(xml) {
            var result;
            if (xml.logInResult == "No") {

                // Build HTML for error message
                result = [
                    '<div class="alert alert-danger alert-dismissable">',
					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
                    '<h4>Log In Error</h4>',
                    xml.logInMessage,
                    '</div>',
                ];

                // Output error message to modal form
                $("#logInMessage").html(result.join(''));

            } else if (xml.logInResult == "Yes") {
				
				// Remove enter key over-ride
                $(document).off('keydown');
				
				// Load details page once done
                location="http://julianrimet.com/details";

            }
        });

}
