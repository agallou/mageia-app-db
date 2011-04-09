(function($){
  $.fn.selectToCheckboxes = function(options) {
    var settings = {
      apply: function(){},
      defaults: [],
      searchfield: true,
      multi: true,
      namespace: 'selectToCheckboxes_',
    }
    if (options)
    {
      $.extend(settings, options);
    }
    this.each(function() {
      var select = $(this);
      var prefix = settings.namespace + select.attr('id');
      var foo = [];
      $('option', select).each(function(i, selected){
        var toto = [];
        toto[0]  = $(selected).val();
        toto[1]  = $(selected).text(); 
        foo[i]   = toto;
      });
      var selectId = select.attr('id');
      var label = $('label[for=' + selectId + ']');

      var widget = $('<div>', {id : 'global_' + selectId, 'class' : 'filterwidget'});
      select.after(widget);

      var button = $('<div>', {id : 'button' + selectId, 'class' : 'button'});
      
      button.appendTo(widget);
      
      var buttontext = $('<span>', {
        id : 'buttontext' + selectId,
        'class' : 'buttontext',
        text    : label.text(),
      });
      buttontext.appendTo(button);
      $('<span>', { id : 'buttonarrow' + selectId,'class' : 'arrow', html: '&darr;', }).appendTo(button);

      button.click(function(){
        document.getElementById('widgetcontent_' + selectId + '1').style.left = buttontext.position().left + 'px';
        $('#widgetcontent_' + selectId + '1').show();
      });

      var ng1 = $('<div>', { id: 'widgetcontent_' + selectId + '1', 'class' : 'widgetcontent1', });
      if (settings.multi)
      {
        ng1.addClass('multi');
      }
      var div = $('<div>', { id: 'widgetcontent_' + selectId, 'class' : 'widgetcontent' });
      ng1.append(div);
      widget.append(ng1);
      var recherche = $('<input>', { type: 'text', id: 'recherche_' + selectId});
      if (settings.searchfield)
      {
        div.append(recherche);
        div.append('<br>');
      }
      recherche.keyup(function(e){
        var letext = $(e.target).val();
        var regepx = new RegExp('/.*' + letext + '.*/');
        $.each(foo, function(key, row)
        {
          if (row[1].toLowerCase().lastIndexOf(letext.toLowerCase()) != -1) {
            $('#' + prefix + 'span_' + row[0]).show();
          } else {
            $('#' + prefix + 'span_' + row[0]).hide();
          }
        });
      });

      if (settings.multi)
      {
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
      }

      $.each(foo, function(key, value)
      {
        var jSpan = $('<div>', { id: prefix + 'span_' + value[0], });
        var input = $("<input>", {
            type    : "checkbox",
            name    : selectId,
            val     : value[0],
            checked : (jQuery.inArray(value[0], settings.defaults) > -1),
            id      : 'inp_' + selectId + '_' + value[0],
           });
        input.appendTo(jSpan);
        if (!settings.multi)
        {
          input.hide();
        }
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
      $(document).mousedown(function(event){
        var target = $(event.target);
        if ($('#' + 'widgetcontent_' + selectId + '1').css('display') != 'none'
          && target[0].id != 'widgetcontent_' + selectId + '1'
          && target[0].id != 'button' + selectId
          && target[0].id != 'buttontext' + selectId
          && target[0].id != 'buttonarrow' + selectId
          && target.parents('#' + 'widgetcontent_' + selectId + '1').length == 0
        )
        {
          ng1.hide();
          settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
        }
      });
      ng1.hide();
    });
    $('.filterwidget div.widgetcontent input:checked').parent().addClass('selected');
  };
})(jQuery);

