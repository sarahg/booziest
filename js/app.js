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
          var table = $('table').stupidtable();
          table.bind('aftertablesort', function (event, data) {
            showSortIcon();
          });

          // @todo show a link to re-enable the form for searching another username
        });
      }
    });

    return false;
  });

    // Show the sort up/down arrows when the table sorts.
    var showSortIcon = function() {
      $('th i').remove();
      $('.sorting-asc').append('<i class="fa fa-sort-asc"></i>');
      $('.sorting-desc').append('<i class="fa fa-sort-desc"></i>');
    };


});
