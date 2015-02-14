$(document).ready(function() {
  'use strict';

  $('#search-user').submit(function() {

    var username = $('input#username').val().trim();
    var $results = $('#query-results');

    $results.html('<img src="img/loadingBeer.gif" id="loading" alt="Loading..." />');

    $.ajax({
      type: 'POST',
      url: 'includes/app.php',
      data: 'username=' + username,
      cache: false,
      success: function(result) {
        $results.html(result);
        $('table').stupidtable();
      }
    });

    return false;
  });

});
