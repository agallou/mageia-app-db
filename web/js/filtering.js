$(document).ready(function(){

  $('#filtering_application').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_application option[selected=selected]')),
    searchfield: false,
    multi: false,
    active: $('#filtering_application').hasClass('disabled_filter') ? false : true
  });
  $('#filtering_group').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_group option[selected=selected]')),
    active: $('#filtering_group').hasClass('disabled_filter') ? false : true
  });
  $('#filtering_release').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_release option[selected=selected]')),
    searchfield: false,
    multi: false,
    active: $('#filtering_release').hasClass('disabled_filter') ? false : true
  });
  $('#filtering_arch').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_arch option[selected=selected]')),
    searchfield: false,
    multi: false,
    active: $('#filtering_arch').hasClass('disabled_filter') ? false : true
  });
  $('#filtering_media').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_media option[selected=selected]')),
    active: $('#filtering_media').hasClass('disabled_filter') ? false : true
  });
  $('#filtering_source').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d);},
    defaults: getAllVals($('#filtering_source option[selected=selected]')),
    searchfield: false,
    multi: false,
    active: $('#filtering_source').hasClass('disabled_filter') ? false : true
  });
  $('div#filtering form:first input[type=submit]').remove();

  $('div#otherFilters').hide();
  $('span#linkmore').click(function(){
    $('div#otherFilters').toggle();
  });
  if (window.location.href.lastIndexOf('/media/') != -1 
      || window.location.href.match('\/group\/[0-9](%2C[0-9]+)*') 
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
  filtering['release'] = getValuesFromCheckboxes($('input[type=checkbox][name=filtering_release]:checked'));
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
      $("body").css("cursor", "wait");
      window.location = data.url;
    }
  });
}


