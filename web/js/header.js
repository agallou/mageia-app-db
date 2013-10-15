$(document).ready(function() {

  $('#appname').click(function(e) {
    if (e.target.tagName != 'A') {
      window.location = $('a:first', '#appname').attr('href');
    }
  });

});

