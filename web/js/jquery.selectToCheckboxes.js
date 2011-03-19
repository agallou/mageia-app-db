(function($){
  $.fn.selectToCheckboxes = function(options) {
    var settings = {
      apply: function(){},
      defaults: [],
      searchfield: true,
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

      var global = $('<span>', {id : 'global_' + selectId, });
      select.after(global);

      var spangroup = $('<span>', {
        id      : 'span' + selectId,
        'class' : 'span',
        text    : label.text(),
      });
      $('<span>', { 'class' : 'fleche', html: '&darr;', }).appendTo(spangroup);
      spangroup.appendTo(global);

      spangroup.click(function(){
        document.getElementById('new' + selectId + '1').style.left = spangroup.position().left + 'px';
        $('#new' + selectId + '1').toggle();
      });

      var ng1 = $('<div>', { id : 'new' + selectId + '1', 'class' : 'new1', });
      var div = $('<span>', { id: 'new' + selectId, 'class' : 'new' });
      ng1.append(div);
      global.append(ng1);
      var recherche = $('<input>', { type: 'text', id: 'recherche_' + selectId});
      if (settings.searchfield)
      {
        div.append(recherche);
      }
      div.append('<br>');
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

      var jApply = $('<div>', {
        id      : 'apply' + selectId,
        'class' : 'apply',
        text    : 'Apply',
      });
      jApply.appendTo(div);

      jApply.click(function(){
        ng1.hide();
        settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
      });
      $.each(foo, function(key, value)
      {
        var jSpan = $('<span>', { id: 'span_' + value[0], });

        $("<input>", {
          type    : "checkbox",
          name    : selectId,
          val     : value[0],
          checked : (jQuery.inArray(value[0], settings.defaults) > -1),
          id      : 'inp_' + selectId + '_' + value[0],
         }).appendTo(jSpan);
        var label = $('<label>', {
          'for' : 'inp_' + selectId + '_' + value[0],
          text   : value[1],
        });
        label.appendTo(jSpan);
        label.click(function(){
          //TODO only to that if option auto_something to true (default)
          //TODO same as jApply, factorize that ???
          ng1.hide();
          $('input[name=' + selectId + ']:checked').removeAttr('checked')
          $('input[id=' + $(this).attr('for') + ']').attr("checked", "checked");
          settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
        });
        $('<br>').appendTo(jSpan);

        div.append(jSpan);
      });
      ng1.toggle();
      select.remove();
      label.remove();
    });
  };
})(jQuery);

