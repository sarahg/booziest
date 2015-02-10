$(document).ready(function() {
  'use strict';

  // Just for illustration, show the results
  // table when the form is submitted.
  $('#search-user').submit(function() {
    var value = $('input[type=text]', this).val().trim();
    if (value === 'hey_germano') {
      $('#query-results').load('includes/app.php', function() {
        // Load the Stupid Table plugin.
        $('table', this).stupidtable();
      });
    }
    else {
      // Show an error if the username isn't found.
      alert('nope');
    }

    return false;
  });

});
