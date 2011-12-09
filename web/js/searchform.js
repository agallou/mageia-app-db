$(document).ready(function() {
  $("form.searchform").submit(function(e){
    e.preventDefault();
    safe = false;
    myform = $(this);
    var url = myform.attr('action');
    myform.find('input:text').each(function() {
      myinput = $(this);
      if (myinput.val()) {
        url = url + '/' + myinput.attr('name') + '/'+ myinput.val();
        safe = true;
      }
    });
    if(safe) {
      window.location = 'http://' + window.location.host + url;
    }
  });
});