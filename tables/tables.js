// Do stuff when page is ready
$(document).ready(function() {

  // Hide the three sub-stage tables
  // They need to be open on page load so the
  // responsive tables can set up the sticky headers properly
  $('#tGSCont').collapse('hide');
  $('#tL16Cont').collapse('hide');
  $('#tRCont').collapse('hide');

  // Make buttons lose focus after being clicked
  $("#btnOverallCont").click(function(e) {
    $(this).blur();
  });

  $("#btnGSCont").click(function(e) {
    $(this).blur();
  });

  $("#btnL16Cont").click(function(e) {
    $(this).blur();
  });

  $("#btnRCont").click(function(e) {
    $(this).blur();
  });

});
