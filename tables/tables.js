// Do stuff when page is ready
$(document).ready(function() {

  // Hide the game week sub-stage table
  // It needs to be open on page load so the
  // responsive tables can set up the sticky headers properly
  $('#tGWCont').collapse('hide');

  // Make buttons lose focus after being clicked
  $("#btnOverallCont").click(function(e) {
    $(this).blur();
  });

  $("#btnGWCont").click(function(e) {
    $(this).blur();
  });

  // Add click handler to submit prediction & move next button
  $("#gameWeek").on('change', function(e) {
    var valueSelected = this.value;
    submitChangeGameWeek(valueSelected);
  });
});

// Function to handle submitting prediction
function submitChangeGameWeek(gameWeek) {

  // Make the AJAX call
  $.ajax({
    url: 'changeGameWeek.php',
    type: 'POST',
    data: {
      gameWeek: gameWeek
    },
    dataType: 'json',
    success: function(data) {
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

  } else { // Data came back OK so build a new table

    // Find the attributes needed for each column
    var $head = $("#tGWCont").find("thead");
    var colAttributes = [];
    var colAttr;
    var e;
    $head.find("th").each(function() {
      e = $(this);
      // Reset for next column
      colAttr = [];
      // Pick class first
      if (e[0].hasAttribute("class")) colAttr.push('class="' + e.attr("class") + '"');
      // Then data-priority
      if (e[0].hasAttribute("data-priority")) colAttr.push('data-priority="' + e.attr("data-priority") + '"');
      // Then colspan: always 1
      colAttr.push('colspan="1"');
      // Then data-columns, set to be the ID of the matching header
      colAttr.push('data-columns="' + e.attr("id") + '"');
      // Finally build it into one string
      colAttributes.push(colAttr.join(' '));
    });

    // Wipe existing table
    var $body = $("#tGWCont").find("tbody");
    $body.empty();

    // Initialise the result variable as an empty array,
    // bits of HTML will be pushed onto it and finally the whole
    // thing will be joined to output
    result = [];

    // Loop through each row (player in the league table) of the returned data
    // and add oit as a row to result array
    $.each(data.data, function(entryIndex, entry){
      result.push('<tr>');

      // Rank
      result.push('<td ' + colAttributes[8] + '>');
      if (entry['rankCount'] > 1) {
        result.push(entry['rank'] + '=');
      } else {
        result.push(entry['rank']);
      }
      result.push('</td>');

      // Player Name
      result.push('<td ' + colAttributes[9] + '>');
      result.push(entry['name']);
      result.push('</td>');

      // Predictions submitted
      result.push('<td ' + colAttributes[10] + '">');
      if (entry['submitted'] == 0) {
        result.push('-');
      } else {
        result.push(entry['submitted']);
      }
      result.push('</td>');

      // Correct result points
      result.push('<td ' + colAttributes[11] + '>');
      if (entry['results'] == 0) {
        result.push('-');
      } else if (entry['results'] == Math.round(entry['results'])) {
        result.push(Math.round(entry['results']));
      } else {
        result.push(entry['results']);
      }
      result.push('</td>');

      // Correct score points
      result.push('<td ' + colAttributes[12] + '>');
      if (entry['scores'] == 0) {
        result.push('-');
      } else if (entry['scores'] == Math.round(entry['scores'])) {
        result.push(Math.round(entry['scores']));
      } else {
        result.push(entry['scores']);
      }
      result.push('</td>');

      // Total points
      result.push('<td ' + colAttributes[13] + '><strong>');
      if (entry['totalPoints'] == 0) {
        result.push('-');
      } else if (entry['totalPoints'] == Math.round(entry['totalPoints'])) {
        result.push(Math.round(entry['totalPoints']));
      } else {
        result.push(entry['totalPoints']);
      }
      result.push('</strong></td>');

      // Distance
      result.push('<td ' + colAttributes[14] + '><strong>');
      if (entry['distancePoints'] == 0) {
        result.push('-');
      } else if (entry['distancePoints'] == Math.round(entry['distancePoints'])) {
        result.push(Math.round(entry['distancePoints']));
      } else {
        result.push(entry['distancePoints']);
      }
      result.push('</strong></td>');

      // Points per prediction
      result.push('<td ' + colAttributes[15] + '>');
      if (entry['submitted'] == 0 || entry['totalPoints'] == 0) {
        result.push('-');
      } else {
        result.push(Math.round(entry['totalPoints'] / entry['submitted'] * 100) / 100);
      }
      result.push('</td>');

      result.push('</tr>');
    });

    // Finally replace table body with new table
    $body.html(result.join(''));
  }
}
