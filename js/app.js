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
        // @todo don't hide the form if no results were found
        $('.search-form').fadeOut('fast', function() {
          $results.html(result);
          $('table').stupidtable();

          // @todo show a link to re-enable the form for searching another username
        });
      }
    });

    return false;
  });

});
