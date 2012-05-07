$(document).ready(function(){
  var subscribe_dialog = $('#subscribeForm');
  subscribe_dialog.dialog({
    autoOpen: false,
    width: 600,
    height: 650,
    modal: true,
    buttons: {
      "Subscribe": function() {
        var params = getSubscriptionParams();
        $.post($('#subscribeForm form:first').attr('action'), {
          'real_action' : 'add',
          'package_id': $('#subscribe_package_id').attr('value'),
          'params': params
        },
        function(data){
          subscribe_dialog.dialog( "close" );
        });
      },
      "Remove subscription": function() {
        $.post($('#subscribeForm form:first').attr('action'), {
          'real_action': 'remove',
          'package_id': $('#subscribe_package_id').attr('value')
        },
        function(data){
          subscribe_dialog.dialog( "close" );
        });
      },
      Cancel: function() {
        subscribe_dialog.dialog( "close" );
      }
    },
    close: function() {
     window.location.reload();
    }
  });
  $('a#packageSubscribe').click(function(event){
    $('#subscribeForm').dialog('open');
    event.preventDefault();
  });
});

$(document).ready(function(){

  $('#subscribe_release').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d, 'release');},
    defaults: getAllVals_subscribeForm($('#subscribe_release option[selected=selected]')),
    searchfield: false,
    multi: true
  });
  $('#subscribe_arch').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d, 'arch');},
    defaults: getAllVals_subscribeForm($('#subscribe_arch option[selected=selected]')),
    searchfield: false,
    multi: true
  });
  $('#subscribe_media').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d, 'media');},
    defaults: getAllVals_subscribeForm($('#subscribe_media option[selected=selected]')),
    searchfield: true,
    multi: true
  });
  $('#subscribe_type').selectToCheckboxes({
    apply: function(d){afterCheckboxChange_subscribeForm(d, 'type');},
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

function afterCheckboxChange_subscribeForm(checked_list, id)
{
  var values = new Array();
  $.each(checked_list, function(key, value) {
    values.push($('label[for=' + $(value).attr('id') + ']').text()); 
  });
  var text = values.join(', ');
  if (text == '')
  {
    text = 'All';
  }
  $('#global_subscribe_' + id).next('.filtervalues').text(text);
}

function getSubscriptionParams()
{
  var params = new Object;
  params['type'] = getValuesFromCheckboxes($('input[type=checkbox][name=subscribe_type]:checked'));
  params['release'] = getValuesFromCheckboxes($('input[type=checkbox][name=subscribe_release]:checked'));
  params['arch'] = getValuesFromCheckboxes($('input[type=checkbox][name=subscribe_arch]:checked'));
  params['media'] = getValuesFromCheckboxes($('input[type=checkbox][name=subscribe_media]:checked'));
  return params;
}

// FIXME : copy/paste from filtering.js, must be refactored
function getSubscriptionValuesFromCheckboxes(checkboxes)
{
 var vals = [];
 $.each(checkboxes, function(key, value) {
    vals[key] = $(value).attr('value');
  });
  return vals;
}