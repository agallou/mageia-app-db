/*$(document).ready(function(){
  $('div#content a').flyout({
    inOpacity:0,
    fullSizeImage:false,
    inSpeed:300,
    outSpeed:300
  });
});
*/
$(document).ready(function(){
  $('#subscribeForm').dialog({
    autoOpen: false,
    width: 500,
    height: 600,
    modal: true,
    buttons: {
      "Subscribe": function() {
        $( this ).dialog( "close" );
      },
      Cancel: function() {
        $( this ).dialog( "close" );
      }
    },
    close: function() {
    }
  });
  $('a#packageSubscribe').click(function(event){
    $('#subscribeForm').dialog('open');
    event.preventDefault();
  });
});

$(document).ready(function(){

  $('#subscribe_distrelease').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d);},
    defaults: getAllVals_subscribeForm($('#subscribe_distrelease option[selected=selected]')),
    searchfield: false,
    multi: true
  });
  $('#subscribe_arch').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d);},
    defaults: getAllVals_subscribeForm($('#subscribe_arch option[selected=selected]')),
    searchfield: false,
    multi: true
  });
  $('#subscribe_media').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d);},
    defaults: getAllVals_subscribeForm($('#subscribe_media option[selected=selected]')),
    searchfield: true,
    multi: true
  });
  $('#subscribe_type').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d);},
    defaults: getAllVals_subscribeForm($('#subscribe_type option[selected=selected]')),
    searchfield: false,
    multi: true
  });
  $('div#subscribeForm form:first input[type=submit]').remove();

  $('.filters').removeAttr('style');
});


function getAllVals_subscribeForm(options)
{
  var vals = [];
  $.each(options, function(key, value) {
    vals[key] = $(value).val();
  });
  return vals;
}

function afterCheckboxChange_subscribeForm(checked_list)
{
  values = new Array();
  $.each(checked_list, function(key, value) {
    values.push($('label[for=' + $(value).attr('id') + ']').text()); 
  });
  text = values.join(', ');
  $(checked_list).first().parent().parent().parent().parent().next('.filtervalues').text(text);
}

