$(document).ready(function(){

  filtering = hashToFiltering(document.location.hash);
  $('#application').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d)},
    defaults: filtering.application,
  });
  $('#group').selectToCheckboxes({
    apply: function(d){afterCheckboxChange(d)},
    defaults: filtering.group,
  });
  $('form input[type=submit]').remove();
  updateResults(filtering);
});


function afterCheckboxChange(changed)
{
  var filtering = hashToFiltering(document.location.hash);
  var vals = [];
  var tmp = '';
  $.each(changed, function(key, value) {
    vals[key] = $(value).attr('value');
    tmp = $(value).attr('name');
  });
  filtering[tmp] = vals;
  document.location.hash = filteringToHash(filtering);
  updateResults(filtering);
}

function hashToFiltering(hash)
{
  var filtering = new Object;
  hash = hash.substring(1);
  var str = $.base64.decode(hash);
  var tab = str.split('§');
  $.each(tab, function(key, value) {
    if (value.length) {
      var tab2 = value.split('|');
      var name = tab2[0];
      if (tab2[1])
      {
        var tab3 = tab2[1].split(',');
        var letab = [];
        $.each(tab3, function(key2, value2) {
          if (value2.length) {
            letab[key2] = value2;
          }
        });
        filtering[name] = letab;
      }
    }
  });
  return filtering;
}

function filteringToHash(obj)
{
  var str = '';
  $.each(obj, function(key, value){
    str += key + '|';
    $.each(value, function(key2, val2){
      str += val2 + ','
    });
    str += '§';
  });
  return $.base64.encode(str);
}


function filteringToLink(filtering)
{
  var link = '';
  $.each(filtering, function (key, value){
    if (value.length) {
      link += '/' + key + '/' + encodeURIComponent(value.join(','));
    }
  });
  var baseUri = window.location.href.substr(0, (window.location.href.lastIndexOf('.php') + 4));
  return baseUri + '/package/dolist' + link;
}

function updateResults(filtering)
{
  $.ajax({
    url: filteringToLink(filtering),
    dataType: 'json',
    success: function(datas){
      updateFilteringInfos(filtering);
      $('#results').empty();
      $('#count').text(datas.total);
      $.each(datas.results, function (key, value){
        $('#results').append('<li><a href="' + value.link + '">' + value.name +  '</a></li>');
      });
    }
  });
}


function updateFilteringInfos(filtering)
{
  $('#filtersInfo').empty();
  $.each(filtering, function (key, value) {
    var val = [];
    $.each(value, function (key2, value2) {
      var id = $('input:checkbox[name=' + key + '][value=' + value2 + ']').attr('id');
      val[key2] = $('label[for="' + id + '"]').text();
    });
    $('#filtersInfo').append(
      key + ' : ' + val.join(', ') + '<br />'
    );
  });
}
