/*
 * @file app.js
 * Form field handling.
*/

$(document).ready(function() {
  'use strict';

  // Just for illustration, show the results
  // table when the form is submitted.
  // Show an error if the username isn't found.
  $('#search-user').submit(function() {
    var value = $('input[type=text]', this).val().trim();
    if (value === 'hey_germano') {
      $('#query-results').load('includes/app.php');
    }
    else {
      alert('nope');
    }

  });

});
