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
    window.scrollTo(0, 0);
    getMatchesData();
  });

  // Add click handler to select / unselect all group stages button
  $("#btnSelectGroup").click(function(e) {
    e.preventDefault();
    selectAllGroups($(this).attr('data-mode'));
  });

  // Add click handler to all group stages checkbox
  $("#ckbGroupStage").click(function(e) {
    disableAllGroups($(this).is(':checked'));
  });

});

// Function to handle getting session data
function getMatchesData() {

  // Build HTML for warning message
  var result = [
    '<div class="alert alert-info alert-dismissable" id="aGettingMatchData">',
    '<button type="button"',
    ' class="close"',
    ' data-dismiss="alert"',
    ' aria-hidden="true">',
    '&times;',
    '</button>',
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

  // Make the AJAX call
  $.ajax({
    url: 'getMatches.php',
    type: 'POST',
    data:
      {action: "updateMatches",
      excPlayed: $("#ckbPlayedMatches").is(':checked'),
      excPredicted: $("#ckbPredictedMatches").is(':checked'),
      groupA: groupA,
      groupB: groupB,
      groupC: groupC,
      groupD: groupD,
      groupE: groupE,
      groupF: groupF,
      r16: $("#ckbR16").is(':checked'),
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

    var homeFlag = '';
    var awayFlag = '';
    var date = '';
    var time = '';

    // Initialise the result variable as an empty array,
    // bits of HTML will be pushed onto it and finally the whole
    // thing will be joined to output
    result = [];

    $.each(data.data, function(entryIndex, entry){

      // Sort out flag links
      homeFlag = (entry['HomeTeamS'] == '') ? 'TMP' : entry['HomeTeamS'].toUpperCase();
      awayFlag = (entry['AwayTeamS'] == '') ? 'TMP' : entry['AwayTeamS'].toUpperCase();

      // Display Date Header if the first Match or date has changed
      if ((entryIndex === 0) || (entry['Date'] != date)) {
        date = entry['Date'];
        result.push('<hr />');
        result.push('<h3>' + date + '</h3>');
        time = entry['KickOff'];
        result.push('<h4>' + time.slice(0,5) + '</h4>');
      } else if (entry['KickOff'] != time) {
      // Display Time Header if the first Match or kick-off has changed
        time = entry['KickOff'];
        result.push('<h4>' + time.slice(0,5) + '</h4>');
      }

      // Add mark-up for a single match

      // Wrap whole row in a link to the relevant match page
      result.push('<div class="matchRow">');
      result.push('<a href="../match?id=' + entry['MatchID'] + '">');

      // Have own row to show flags on phones, in-line on anything bigger
      result.push('<div class="row visible-xs">');
      result.push('<div class="col-xs-4 text-center"><span class="team-flag flag-' + homeFlag + '"></span></div>');
      result.push('<div class="col-xs-4 col-xs-offset-4 text-center"><span class="team-flag flag-' + awayFlag + '"></span></div>');
      result.push('</div>');

      // Main row with team names, flags and result on
      result.push('<div class="row">');
      result.push('<div class="col-sm-2 hidden-xs text-center"><span class="team-flag flag-' + homeFlag + '"></span></div>'); // in-line flag for devices bigger than a phone
      result.push('<div class="col-xs-4 visible-xs text-center matchText">' + entry['HomeTeam'] + '</div>'); // Centred name for phones
      result.push('<div class="col-sm-2 hidden-xs text-right lead matchText">' + entry['HomeTeam'] + '</div>'); // Full name for tablets & desktops
      result.push('<div class="col-xs-1 text-center lead matchText"><b>' + ((entry['HomeTeamPoints'] === null) ? '' : entry['HomeTeamPoints']) + '</b></div>'); // Score
      result.push('<div class="col-xs-2 text-center matchText">vs.</div>'); // Divider
      result.push('<div class="col-xs-1 text-center lead matchText"><b>' + ((entry['AwayTeamPoints'] === null) ? '' : entry['AwayTeamPoints']) + '</b></div>'); // Score
      result.push('<div class="col-sm-2 hidden-xs text-left lead matchText">' + entry['AwayTeam'] + '</div>'); // Full name for tablets & desktops
      result.push('<div class="col-xs-4 visible-xs text-center matchText">' + entry['AwayTeam'] + '</div>');  // Centred name for phones
      result.push('<div class="col-sm-2 hidden-xs text-center"><span class="team-flag flag-' + awayFlag + '"></span></div>'); // in-line flag for devices bigger than a phone
      result.push('</div>');

      // Row for prediction, if logged in
      if (data.loggedIn == 1) {
        if (entry['HomeTeamPrediction'] === null) {
          result.push('<div class="alert alert-danger">');
          result.push('<div class="row">');
          result.push('<div class="col-xs-12 text-left">');
          result.push('<i>Not yet predicted</i>');
          result.push('</div>');
        } else {
          result.push('<div class="alert alert-success">');
          result.push('<div class="row">');
          htp = Math.round(entry['HomeTeamPrediction']);
          atp = Math.round(entry['AwayTeamPrediction']);
          // Prediction for phones
          result.push('<div class="col-xs-3 visible-xs text-left"><i>Predicted:</i></div>');
          result.push('<div class="col-xs-6 visible-xs text-center">');
          if (htp > atp) {
            result.push('<b>' + entry['HomeTeam'] + ' Win</b>');
          } else if (htp < atp) {
            result.push('<b>' + entry['AwayTeam'] + ' Win</b>');
          } else {
            result.push('<b>Draw</b>');
          }
          result.push('</div>'); // Close prediction
          // Prediction for tabets and desktops
          result.push('<div class="col-sm-2 hidden-xs text-left"><i>Predicted:</i></div>'); // Head up prediction row
          result.push('<div class="col-sm-8 hidden-xs text-center">'); // prediction
          if (htp > atp) {
            result.push('<b>' + entry['HomeTeam'] + ' Win</b>');
          } else if (htp < atp) {
            result.push('<b>' + entry['AwayTeam'] + ' Win</b>');
          } else {
            result.push('<b>Draw</b>');
          }
          result.push('</div>'); // Close prediction
          result.push('</div>'); // Close row
          result.push('<div class="row">');
          result.push('<div class="col-xs-1 col-xs-offset-4 text-center">' + entry['HomeTeamPrediction'] + '</div>'); // Score
          result.push('<div class="col-xs-2 text-center">-</div>'); // Divider
          result.push('<div class="col-xs-1 text-center">' + entry['AwayTeamPrediction'] + '</div>'); // Score
        }
        result.push('</div>'); // Close row
        result.push('</div>'); // Close alert
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
    // Enable all the checkboxes + the button
    $('#collapseGroup').find('[type=checkbox]').prop('disabled', false);
    $('#btnSelectGroup').prop('disabled', false);
  } else {
    // Disable all the checkboxes + the button
    $('#collapseGroup').find('[type=checkbox]').prop('disabled', true);
    $('#btnSelectGroup').prop('disabled', true);
  }

}
