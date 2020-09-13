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
    $("#collapseTeam").collapse('hide'); // collapse the filters section
    $("#collapseWeek").collapse('hide'); // collapse the filters section
    window.scrollTo(0, 0);
    getMatchesData();
  });

  // Add click handler to select / unselect all the teams button
  $("#btnSelectTeam").click(function(e) {
    e.preventDefault();
    toggleSelect($(this).attr('data-mode'), $('#collapseTeam'), $(this));
  });

  // Add click handler to select / unselect all game weeks button
  $("#btnSelectWeek").click(function(e) {
    e.preventDefault();
    toggleSelect($(this).attr('data-mode'), $('#collapseWeek'), $(this));
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

  // Make the AJAX call
  $.ajax({
    url: 'getMatches.php',
    type: 'POST',
    data:
      {action: "updateMatches",
      excPlayed: $("#ckbPlayedMatches").is(':checked'),
      excPredicted: $("#ckbPredictedMatches").is(':checked'),
      t1: $('#ckbT1').is(':checked'),
      t2: $('#ckbT2').is(':checked'),
      t3: $('#ckbT3').is(':checked'),
      t4: $('#ckbT4').is(':checked'),
      t5: $('#ckbT5').is(':checked'),
      t6: $('#ckbT6').is(':checked'),
      t7: $('#ckbT7').is(':checked'),
      t8: $('#ckbT8').is(':checked'),
      t9: $('#ckbT9').is(':checked'),
      t10: $('#ckbT10').is(':checked'),
      t11: $('#ckbT11').is(':checked'),
      t12: $('#ckbT12').is(':checked'),
      t13: $('#ckbT13').is(':checked'),
      t14: $('#ckbT14').is(':checked'),
      t15: $('#ckbT15').is(':checked'),
      t16: $('#ckbT16').is(':checked'),
      t17: $('#ckbT17').is(':checked'),
      t18: $('#ckbT18').is(':checked'),
      t19: $('#ckbT19').is(':checked'),
      t20: $('#ckbT20').is(':checked'),
      gw1: $('#ckbGW1').is(':checked'),
      gw2: $('#ckbGW2').is(':checked'),
      gw3: $('#ckbGW3').is(':checked'),
      gw4: $('#ckbGW4').is(':checked'),
      gw5: $('#ckbGW5').is(':checked'),
      gw6: $('#ckbGW6').is(':checked'),
      gw7: $('#ckbGW7').is(':checked'),
      gw8: $('#ckbGW8').is(':checked'),
      gw9: $('#ckbGW9').is(':checked'),
      gw10: $('#ckbGW10').is(':checked'),
      gw11: $('#ckbGW11').is(':checked'),
      gw12: $('#ckbGW12').is(':checked'),
      gw13: $('#ckbGW13').is(':checked'),
      gw14: $('#ckbGW14').is(':checked'),
      gw15: $('#ckbGW15').is(':checked'),
      gw16: $('#ckbGW16').is(':checked'),
      gw17: $('#ckbGW17').is(':checked'),
      gw18: $('#ckbGW18').is(':checked'),
      gw19: $('#ckbGW19').is(':checked'),
      gw20: $('#ckbGW20').is(':checked'),
      gw21: $('#ckbGW21').is(':checked'),
      gw22: $('#ckbGW22').is(':checked'),
      gw23: $('#ckbGW23').is(':checked'),
      gw24: $('#ckbGW24').is(':checked'),
      gw25: $('#ckbGW25').is(':checked'),
      gw26: $('#ckbGW26').is(':checked'),
      gw27: $('#ckbGW27').is(':checked'),
      gw28: $('#ckbGW28').is(':checked'),
      gw29: $('#ckbGW29').is(':checked'),
      gw30: $('#ckbGW30').is(':checked'),
      gw31: $('#ckbGW31').is(':checked'),
      gw32: $('#ckbGW32').is(':checked'),
      gw33: $('#ckbGW33').is(':checked'),
      gw34: $('#ckbGW34').is(':checked'),
      gw35: $('#ckbGW35').is(':checked'),
      gw36: $('#ckbGW36').is(':checked'),
      gw37: $('#ckbGW37').is(':checked'),
      gw38: $('#ckbGW38').is(':checked')},
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
      homeFlag = (entry['HomeTeamS'] == '') ? 'tmp' : entry['HomeTeamS'].toLowerCase();
      awayFlag = (entry['AwayTeamS'] == '') ? 'tmp' : entry['AwayTeamS'].toLowerCase();

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
      result.push('<div class="col-xs-4 text-center"><img width="80" hieght="40" alt="' + entry['HomeTeam'] + '" class="flag" src="../assets/img/flags/' + homeFlag + '.png"></div>');
      result.push('<div class="col-xs-4 col-xs-offset-4 text-center"><img width="80" hieght="40" alt="' + entry['AwayTeam'] + '" class="flag" src="../assets/img/flags/' + awayFlag + '.png"></div>');
      result.push('</div>');

      // Main row with team names, flags and result on
      result.push('<div class="row matchRowDetails">');
      result.push('<div class="col-sm-2 hidden-xs text-center"><img width="80" hieght="40" alt="' + entry['HomeTeam'] + '" class="flag" src="../assets/img/flags/' + homeFlag + '.png"></div>'); // in-line flag for devices bigger than a phone
      result.push('<div class="col-xs-4 visible-xs text-center matchText">' + entry['HomeTeam'] + '</div>'); // Centred name for phones
      result.push('<div class="col-sm-2 hidden-xs text-right lead matchText">' + entry['HomeTeam'] + '</div>'); // Full name for tablets & desktops
      result.push('<div class="col-xs-1 text-center lead matchText"><b>' + ((entry['HomeTeamPoints'] === null) ? '' : entry['HomeTeamPoints']) + '</b></div>'); // Score
      result.push('<div class="col-xs-2 text-center matchText">vs.</div>'); // Divider
      result.push('<div class="col-xs-1 text-center lead matchText"><b>' + ((entry['AwayTeamPoints'] === null) ? '' : entry['AwayTeamPoints']) + '</b></div>'); // Score
      result.push('<div class="col-sm-2 hidden-xs text-left lead matchText">' + entry['AwayTeam'] + '</div>'); // Full name for tablets & desktops
      result.push('<div class="col-xs-4 visible-xs text-center matchText">' + entry['AwayTeam'] + '</div>');  // Centred name for phones
      result.push('<div class="col-sm-2 hidden-xs text-center"><img width="80" hieght="40" alt="' + entry['AwayTeam'] + '" class="flag" src="../assets/img/flags/' + awayFlag + '.png"></div>'); // in-line flag for devices bigger than a phone
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

function toggleSelect (mode, section, button) {

  // see if we're selecting or unselecting
  if (mode === 'unselect') {
    // Change all the checkbox states to unchecked
    section.find('[type=checkbox]').prop('checked',false);
    // Change button text back to select all
    button.text('Select All').attr('data-mode','select');
  } else {
    // Change all the checkbox states to checked
    section.find('[type=checkbox]').prop('checked',true);
    // Change button text back to unselect all
    button.text('Unselect All').attr('data-mode','unselect');
  }

}
