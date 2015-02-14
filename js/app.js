$(document).ready(function() {
  'use strict';

  $('#search-user').submit(function() {

    var username = $('input#username').val().trim();
    var $results = $('#query-results');

    $('.search-form').html('<img src="img/loadingBeer.gif" id="loading" alt="Loading..." />');

    $.ajax({
      type: 'POST',
      url: 'includes/app.php',
      data: 'username=' + username,
      cache: false,
      success: function(result) {
        $('.search-form').fadeOut('fast', function() {
          $results.html(result);
          $('table').stupidtable();
        });
      }
    });

    return false;
  });

});
