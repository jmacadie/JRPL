// Do stuff when page is ready
$(document).ready(function() {

  // Add click handler to all update tournament role buttons
  $("#accordionTournamentRoles").find('button').click(function(e) {
    e.preventDefault();
    var $sel = $(this).closest('form').find('select');
    updateTournamentRole(
      $sel.attr('id').substring(3),
      $sel.val(),
      $sel.closest('div.row').next('div.row').find('.messageTR'));
  });
  
  // Add click handler to the rest user password
  $("#accordionUsers").find('button').click(function(e) {
    e.preventDefault();
    var $sel = $(this).closest('form').find('select');
    resetPassword(
      $sel.val(),
      $sel.find(':selected').text(),
      $("#usersMessage"));
  });

});

// Function to handle updating tournament Roles
function updateTournamentRole(tournamentRoleID, teamID, $message) {

  // Build HTML for info message
  var result = [
    '<div class="alert alert-info alert-dismissable">',
    '<button type="button"',
    ' class="close"',
    ' data-dismiss="alert"',
    ' aria-hidden="true">&times;</button>',
    'Submitting update to database...',
    '</div>'];

  // Output message
  $message.html(result.join(''));

  // Make the AJAX call
  $.ajax({
    url: 'updateTournamentRole.php',
    type: 'POST',
    data:
      {action: "updateTournamentRole",
      tournamentRoleID: tournamentRoleID,
      teamID: teamID},
    dataType: 'json',
    success: function(data) {
      //alert ('Success');
      processUpdateTRReturn (data, $message);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert ('AJAX callback error: ' + textStatus + ', ' + errorThrown);
    }
  });

}

// Callback function to process the returned data when filters are updated (or
// page is first loaded)
function processUpdateTRReturn (data, $message) {

  if (data.result === "No") {
  // If result returned no then something went wrong so build and display an
  // error message

    // Build HTML for error message
    var result = [
      '<div class="alert alert-danger alert-dismissable">',
      '<button type="button"',
      ' class="close"',
      ' data-dismiss="alert"',
      ' aria-hidden="true">&times;</button>',
      '<h4>Update Tournament Role Error</h4>',
      data.message,
      '</div>'];

    // Output error message
    $message.html(result.join(''));

  } else {

    var $row = $message.closest('div.row').prev('div.row');

    // Set the flag
    var flag = (data.teamS == '') ? 'tmp' : data.teamS.toLowerCase();
    flag = '../assets/img/flags/' + flag + '.png';
    $row.find('img.flag').attr('src', flag);

    // Set the team name
    $row.find('span.tr-team').html(data.team);

    // Close "submitting data" alert
    $message.html('');

  }

}

// Function to handle resetting a user's password
function resetPassword(userID, name, $message) {
  
  // TODO: write a dialog box to confirm really want to reset this user's password
  if (window.confirm("Do you really want to reset " + name + "'s password?")) { 
  
    // Build HTML for info message
    var result = [
      '<div class="alert alert-info alert-dismissable">',
      '<button type="button"',
      ' class="close"',
      ' data-dismiss="alert"',
      ' aria-hidden="true">&times;</button>',
      'Submitting update to database...',
      '</div>'];
  
    // Output message
    $message.html(result.join(''));
  
    // Make the AJAX call
    $.ajax({
      url: 'resetPassword.php',
      type: 'POST',
      data:
        {action: "resetPassword",
        userID: userID},
      dataType: 'json',
      success: function(data) {
        //alert ('Success');
        processResetPasswordReturn (data, $message);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert ('AJAX callback error: ' + textStatus + ', ' + errorThrown);
      }
    });
  
  }

}

// Callback function to process the returned data when filters are updated (or
// page is first loaded)
function processResetPasswordReturn (data, $message) {

  if (data.result === "No") {
  // If result returned no then something went wrong so build and display an
  // error message

    // Build HTML for error message
    var result = [
      '<div class="alert alert-danger alert-dismissable">',
      '<button type="button"',
      ' class="close"',
      ' data-dismiss="alert"',
      ' aria-hidden="true">&times;</button>',
      '<h4>Reset Password Error</h4>',
      data.message,
      '</div>'];

    // Output error message
    $message.html(result.join(''));

  } else {

    // Build HTML for success message
    var result = [
      '<div class="alert alert-success alert-dismissable">',
      '<button type="button"',
      ' class="close"',
      ' data-dismiss="alert"',
      ' aria-hidden="true">&times;</button>',
      'Password successfully reset!',
      '</div>'];

    // Output error message
    $message.html(result.join(''));

  }

}
