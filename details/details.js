$(document).ready(function() {

  // Add click handler to log in button
  $("#updateBtn").click(function(e) {

    e.preventDefault();
        doUpdate();

    });

  // Set a handler to process return key press as form submit
  $(document).keydown(function(event) {
    if (event.which == 13) {
      event.preventDefault();
      doUpdate();
    };
  });

});

function doUpdate() {

    // Send request
    $.post("../includes/login.php",

        {action: "update",
            firstName: $("#firstName").val(),
      lastName: $("#lastName").val(),
      displayName: $("#displayName").val(),
      email: $("#email").val(),
      pwd: $("#tPassord").val(),
            pwd2: $("#tPassord2").val()},

        function(xml) {
            var result;
            if (xml.result == "No") {

                // Build HTML for error message
                result = [
                    '<div class="alert alert-danger alert-dismissable">',
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
                    '<h4>Update Error</h4>',
                    xml.message,
                    '</div>',
                ];

                // Output error message to page
                $("#updateMessage").html(result.join(''));

            } else if (xml.result == "Yes") {

        // Build HTML for return message
                result = [
                    '<div class="alert alert-success alert-dismissable">',
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
                    'Details updated',
                    '</div>',
                ];

                // Output success message to page
                $("#updateMessage").html(result.join(''));

            }
        });

}
