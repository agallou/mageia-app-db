(function($){
  $.fn.selectToCheckboxes = function(options) {
    var settings = {
      apply: function(){},
      defaults: [],
    }
    if (options)
    {
      $.extend(settings, options);
    }
    this.each(function() {
      var select = $(this);
      var foo = [];
      $('option', select).each(function(i, selected){
        var toto = [];
        toto[0]  = $(selected).val();
        toto[1]  = $(selected).text(); 
        foo[i]   = toto;
      });
      var selectId = select.attr('id');
      var label = $('label[for=' + selectId + ']');
      select.after('<span id="global_' + selectId + '"></span>');
      var global = $('#global_' + selectId);
      global.append('<span id="span' + selectId + '" class="span">' + label.text() + '<span class="fleche">&darr;</span></span>');
      var spangroup = $('#span' + selectId);
      $('#span' + selectId).click(function(){
        document.getElementById('new' + selectId + '1').style.left = spangroup.position().left + 'px';
        $('#new' + selectId + '1').toggle();
      });
      global.append('<div id="new' + selectId + '1" class="new1"><span id="new' + selectId  +  '" class="new"></span></div>');
      var ng1 = $('#new' + selectId + '1');
      var div = $('#new' + selectId);
      div.append('<input type="text" id="recherche_' + selectId +  '" /><br />');
      var recherche = $('#recherche_' + selectId);
      recherche.keyup(function(e){
        var letext = $(e.target).val();
        var regepx = new RegExp('/.*' + letext + '.*/');
        $.each(foo, function(key, row)
        {
          if (row[1].toLowerCase().match('.*' + letext.toLowerCase() + '.*')) {
            $('#span_' + row[0]).show();
          } else {
            $('#span_' + row[0]).hide();
          }
        });
      });
      div.append('<div id="apply' + selectId + '" class="apply">Apply</div>');
      var app = $('#apply' + selectId);
      app.click(function(){
        ng1.hide();
        settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
      });
      $.each(foo, function(key, value)
      {
        var checked = '';
        if (jQuery.inArray(value[0], settings.defaults) > -1)
        {
          checked = 'checked="checked"'
        }
        div.append('<span id="span_' + value[0] + '"><input type="checkbox" name="' + selectId+  '" value="' + value[0] + '" ' + checked  + ' id="inp_'+ value[0] + '" /><label for="inp_' + value[0] + '">' + value[1] + '</label><br /></span>');
      });
      ng1.toggle();
      select.remove();
      label.remove();
    });
  };
})(jQuery);

