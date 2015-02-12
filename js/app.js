$(document).ready(function() {
  'use strict';

  $('#search-user').submit(function() {
    var value = $('input[type=text]', this).val().trim();

    $('#query-results').load('includes/app.php', function() {
      // Load the Stupid Table plugin.
      $('table', this).stupidtable();
    });

    return false;
  });

});
