$(document).ready(function(){

   foo = []; 
  $('#group option').each(function(i, selected){
    var toto = [];
    toto[0] = $(selected).val();
    toto[1] = $(selected).text(); 
    foo[i] = toto;
  });

  var select = $('#group');

  select.after('<span id="spangroup">Group</span>');
  $('#spangroup').click(function(){
    $('#newgroup').toggle();
  });
  var div = $('#newgroup');

  div.append('<input type="text" id="recherche" /><br />');
  var recherche = $('#recherche');
  recherche.keyup(function(e){
    var letext = $(e.target).val();
var regepx = new RegExp('/.*' + letext + '.*/');
    for each (var row in foo)
    {
      //if (regepx.test(row[1])) {
      if (row[1].match('.*' + letext + '.*')) {
        $('#span_' + row[0]).show();
      } else {
        $('#span_' + row[0]).hide();
      }
    }
  });
  for each (var value in foo)
  {
    div.append('<span id="span_' + value[0] + '"><input type="checkbox" name="group" value="' + value[0] + '"/>' + value[1] + '<br /></span>');
  }

  div.toggle();

});
