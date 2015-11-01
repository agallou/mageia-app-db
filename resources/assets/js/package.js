$(document).ready(function(){
  var subscribe_dialog = $('#subscribeForm');

    $('.cancel', subscribe_dialog).click(function(e) {
        $.colorbox.close();
        e.preventDefault();
        return false;
    });

    $('.subscribe', subscribe_dialog).click(function(e) {
        var params = getSubscriptionParams();
        $.post($('#subscribeForm form:first').attr('action'), {
                'real_action' : 'add',
                'package_id': $('#subscribe_package_id').attr('value'),
                'params': params
            },
            function(data){
                $.colorbox.close();
        });
        e.preventDefault();
        return false;
    });

    $('.unsubscribe', subscribe_dialog).click(function(e) {
        $.post($('#subscribeForm form:first').attr('action'), {
                'real_action': 'remove',
                'package_id': $('#subscribe_package_id').attr('value')
            },
            function(data){
                $.colorbox.close();
        });
        e.preventDefault();
        return false;
    });

  $('a#packageSubscribe').click(function(event){

      $.colorbox({
          html: subscribe_dialog,
          onOpen: function() {
              subscribe_dialog.show();
          },
          onClosed: function() {
              window.location.reload();
          },
          width: 660,
          height: 550,
          className: "colorbox-modal"
      });

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


$(document).ready(function(){
  $('.install_link').click(function(event) {
    var tag = $("<div></div>");
    $.ajax({
      url: $(event.target).attr('href'),
      success: function(data) {

        $.colorbox({
            html: tag.html(data),
            width: 660,
            height: 550,
            className: "colorbox-modal"
        });
      }
    });
    return false;
  });
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

$(document).ready(function() {
  if ($('.package-details').length > 0) {
    $('#global_filtering_application').addClass('disabled_filter');
    $('#global_filtering_group').addClass('disabled_filter');
    $('#global_filtering_group').next().next().next('a').remove();
    $('#global_filtering_source').addClass('disabled_filter');
    $('#global_filtering_source').next().next().next('a').remove();
    $('#global_filtering_maint').addClass('disabled_filter');
    $('#global_filtering_maint').next().next().next('a').remove();
  }
});
