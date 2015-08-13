$(document).ready(function() {

  // Add click handler to log out menu
    $("#logOut").click(function(e) {

        e.preventDefault();

        // Send request
        $.post("../includes/login.php",

            {action: "logout"},

            function() {
                //Reload the page
                location.reload(true);
            });
    });

});
