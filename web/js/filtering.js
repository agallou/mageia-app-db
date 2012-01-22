$(document).ready(function(){

  $('#filtering_application').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_application option[selected=selected]')),
    searchfield: false,
    multi: false
  });
  $('#filtering_group').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_group option[selected=selected]'))
  });
  $('#filtering_distrelease').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_distrelease option[selected=selected]')),
    searchfield: false,
    multi: false
  });
  $('#filtering_arch').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_arch option[selected=selected]')),
    searchfield: false,
    multi: false
  });
  $('#filtering_media').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_media option[selected=selected]'))
  });
  $('#filtering_source').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_source option[selected=selected]')),
    searchfield: false,
    multi: false
  });
  $('div#filtering form:first input[type=submit]').remove();

  $('div#otherFilters').hide();
  $('span#linkmore').click(function(){
    $('div#otherFilters').toggle();
  });
  if (window.location.href.lastIndexOf('/media/') != -1 
      || window.location.href.match('\/group\/[0-9%2C]*') 
      || window.location.href.match('\/source\/[1-9]'))
  {
    $('div#otherFilters').show();
  }
  $('.filters').removeAttr('style');
});


function getAllVals(options)
{
  var vals = [];
  $.each(options, function(key, value) {
    vals[key] = $(value).val();
  });
  return vals;
}

function afterCheckboxChange(changed)
{
  var filtering = getFiltering();
  updateResults(filtering);
}

function getFiltering()
{
  var filtering = new Object;
  filtering['distrelease'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_distrelease]:checked'));
  filtering['application'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_application]:checked'));
  filtering['group'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_group]:checked'));
  filtering['arch'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_arch]:checked'));
  filtering['media'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_media]:checked'));
  filtering['source'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_source]:checked')); 
  return filtering;
}

function getValuesFromCheckboxes(checkboxes)
{
 var vals = [];
 $.each(checkboxes, function(key, value) {
    vals[key] = $(value).attr('value');
  });
  return vals;
}


function updateResults(filtering)
{
  var urlToGetUrlAction = $('div#filtering form').attr('uglyhack');
  $.post(urlToGetUrlAction, {
    baseurl: $.base64.encode($('div#filtering form').attr('uglyhack2')),
    extraParams: filtering
  },
  function(data){
    if (data.changed) {
      window.location = data.url;
    }
  });
}


