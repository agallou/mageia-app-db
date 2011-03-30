$(document).ready(function(){

  $('#application').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d)},
    defaults: getAllVals($('#application option[selected=selected]')),
    searchfield: false,
  });
  $('#group').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d)},
    defaults: getAllVals($('#group option[selected=selected]')),
  });
  $('#distrelease').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d)},
    defaults: getAllVals($('#distrelease option[selected=selected]')),
  });
  $('#arch').selectToCheckboxes({
	    apply: function(d){afterCheckboxChange(d)},
	    defaults: getAllVals($('#arch option[selected=selected]')),
      searchfield: false,
	  });
  $('#media').selectToCheckboxes({
	    apply: function(d){afterCheckboxChange(d)},
	    defaults: getAllVals($('#media option[selected=selected]')),
	  });
  $('#source').selectToCheckboxes({
	    apply: function(d){afterCheckboxChange(d)},
	    defaults: getAllVals($('#source option[selected=selected]')),
	  });
  $('div#filtering form:first input[type=submit]').remove();

  $('div#otherFilters').toggle();
  $('span#linkmore').click(function(){
    $('div#otherFilters').toggle();
  });
  if (window.location.href.lastIndexOf('media') != -1 || window.location.href.lastIndexOf('media') != -1)
  {
    $('div#otherFilters').show();
  }
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
  filtering = getFiltering();
  updateResults(filtering);
}

function getFiltering()
{
  var filtering = new Object;
  filtering['distrelease'] = getValuesFromCheckboxes($('input[type=checkbox][name=distrelease]:checked'));
  filtering['application'] = getValuesFromCheckboxes($('input[type=checkbox][name=application]:checked'));
  filtering['group'] = getValuesFromCheckboxes($('input[type=checkbox][name=group]:checked'));
  filtering['arch'] = getValuesFromCheckboxes($('input[type=checkbox][name=arch]:checked'));
  filtering['media'] = getValuesFromCheckboxes($('input[type=checkbox][name=media]:checked'));
  filtering['source'] = getValuesFromCheckboxes($('input[type=checkbox][name=source]:checked'));
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
  var baseUri = window.location.href.substr(0, (window.location.href.lastIndexOf('.php') + 4));   
   $.post(baseUri + '/default/getUrl', { baseurl: $.base64.encode(window.location.href), extraParams: filtering},
   function(data){
     if (data.changed) {
       window.location = data.url;
     }
   });
}


