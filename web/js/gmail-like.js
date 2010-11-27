$(document).ready(function(){

   foo = []; 
  $('#group option').each(function(i, selected){
    var toto = [];
    toto[0] = $(selected).val();
    toto[1] = $(selected).text(); 
    foo[i] = toto;
  });

  var select = $('#group');
  var label = $('label[for=group]');
  select.after('<span id="global_group"></span>');
  var global = $('#global_group');

  global.append('<span id="spangroup">Group&darr;</span>');

  var spangroup = $('#spangroup');

  $('#spangroup').click(function(){
    $('#newgroup1').toggle();
  });
 global.append('<div id="newgroup1"><p id="newgroup"></p></div>');
  var ng1 = $('#newgroup1');

  var div = $('#newgroup');

  div.append('<input type="text" id="recherche" /><br />');
  var recherche = $('#recherche');
  recherche.keyup(function(e){
    var letext = $(e.target).val();
    var regepx = new RegExp('/.*' + letext + '.*/');
    for each (var row in foo)
    {
      //if (regepx.test(row[1])) {
      if (row[1].toLowerCase().match('.*' + letext.toLowerCase() + '.*')) {
        $('#span_' + row[0]).show();
      } else {
        $('#span_' + row[0]).hide();
      }
    }
  });
  for each (var value in foo)
  {
    div.append('<span id="span_' + value[0] + '"><input type="checkbox" name="group" value="' + value[0] + '" id="inp_'+ value[0] + '" /><label for="inp_' + value[0] + '">' + value[1] + '</label><br /></span>');
  }

  ng1.append('<input type="submit" />')

  ng1.toggle();
  //div.toggle();
  select.remove();
  label.remove();
  document.getElementById('newgroup1').style.left = spangroup.position().left + 'px';
});
