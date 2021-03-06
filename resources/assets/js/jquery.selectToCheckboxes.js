(function($){
  $.fn.selectToCheckboxes = function(params) {
    var settings = {
      apply: function(){},
      defaults: [],
      searchfield: true,
      multi: true,
      active: true,
      namespace: 'selectToCheckboxes_'
    };
    if (params)
    {
      $.extend(settings, params);
    }
    this.each(function() {
      var select = $(this);
      var prefix = settings.namespace + select.attr('id');
      var options = [];
      $('option', select).each(function(i, selected){
        var option = [];
        option[0]  = $(selected).val();
        option[1]  = $(selected).text(); 
        options[i]   = option;
      });
      var selectId = select.attr('id');
      var label = $('label[for=' + selectId + ']');

      var widget = $('<div>', {id : 'global_' + selectId, 'class' : 'filterwidget'});
      if (!settings.active) {
        widget.addClass('disabled_filter');
      }
      select.after(widget);

      var button = $('<div>', {id : 'button' + selectId, 'class' : 'button'});
      
      button.appendTo(widget);
      
      var buttontext = $('<span>', {
        id : 'buttontext' + selectId,
        'class' : 'buttontext',
        text    : label.text()
      });
      buttontext.appendTo(button);
      $('<span>', { id : 'buttonarrow' + selectId,'class' : 'arrow', html: '<i class="icon-chevron-down"></i>' }).appendTo(button);

      var ng1 = $('<div>', { id: 'widgetcontent_' + selectId + '1', 'class' : 'widgetcontent1' });

      button.click(function() {
        if (!widget.hasClass('disabled_filter') && settings.active) {
          document.getElementById('widgetcontent_' + selectId + '1').style.left = button.position().left+ 'px';
          $('#widgetcontent_' + selectId + '1').toggle({
            duration: 0,
            complete: function() {
              ng1.trigger('toggle')
            }
          });
        }
      });

      ng1.bind('toggle', function() {
          if (ng1.css('display') == 'block') {
            ng1.trigger('appear');
          } else {
            ng1.trigger('disappear');
          }
      });

      ng1.bind('appear', function() {
          $('#button' + selectId).addClass('button-clicked');
      });
      ng1.bind('disappear', function() {
          $('#button' + selectId).removeClass('button-clicked');
      });

      if (settings.multi)
      {
        ng1.addClass('multi');
      }
      var div = $('<div>', { id: 'widgetcontent_' + selectId, 'class' : 'widgetcontent' });
      widget.append(ng1);
      var recherche = $('<input>', { type: 'text', id: 'recherche_' + selectId});
      if (settings.searchfield)
      {
        ng1.append('<i class="icon-search"></i>');
        ng1.append(recherche);
        ng1.append('<br>');
      }
      ng1.append(div);

      recherche.keyup(function(e){
        var letext = $(e.target).val();
        var regepx = new RegExp('/.*' + letext + '.*/'); // regepx is unused
        $.each(options, function(key, row)
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
          text    : 'Apply'
        });
        jApply.appendTo(ng1);
        jApply.click(function(){
          ng1.hide();
          settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
        });
      }

      $.each(options, function(key, value)
      {
        var jSpan = $('<div>', { id: prefix + 'span_' + value[0] });
        var checked = (jQuery.inArray(value[0], settings.defaults) > -1);
        var input = $("<input>", {
            type    : "checkbox",
            name    : selectId,
            val     : value[0],
            checked : checked,
            id      : 'inp_' + selectId + '_' + value[0]
           });
        input.appendTo(jSpan);
        if (!settings.multi)
        {
          input.hide();
        }
        if (settings.multi) {
          if (checked) {
            var icon = $('<i class="icon-check"></i>');
          } else {
            var icon = $('<i class="icon-check-empty"></i>');
          }
          icon.appendTo(jSpan);
        }
        var label = $('<label>', {
          'for' : 'inp_' + selectId + '_' + value[0],
          text   : value[1]
        });
        label.appendTo(jSpan);
        if (settings.multi) {
          var clickable = label;
        } else {
          clickable = jSpan; //clickable all ready declared no need to redeclare
        }

        $(clickable).click(function(event){
          if (!settings.multi) {
            $('input[name=' + selectId + ']:checked').parent().removeClass('selected');
            $('input[name=' + selectId + ']:checked').removeAttr('checked');
            $('input[id=\'' + $(label).attr('for') + '\']').attr("checked", "checked");
            $('.filterwidget div.widgetcontent input:checked').parent().addClass('selected');
            ng1.hide();
            settings.apply.apply(label, [$('input[name=' + selectId + ']:checked')]);
            event.preventDefault();
          }
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
          && target.parents('#' + 'button' + selectId).length == 0
        )
        {
          ng1.hide();
          ng1.trigger('disappear');
          settings.apply.apply(this, [$('input[name=' + selectId + ']:checked')]);
        }
      });
      ng1.trigger('disappear');
      ng1.hide();

      $('div.widgetcontent input:checked', widget).parent().addClass('selected');

      $('div.widgetcontent div', widget).click(function(event) {
        if (event.target.nodeName == 'DIV' || event.target.nodeName == 'I') {
          $('input', this).click().change();
        }
      });

      $('div.widgetcontent div input', widget).change(function(event) {
        if ($(event.target).attr('checked')) {
          $('i', $(event.target).parent()).addClass('icon-check');
          $('i', $(event.target).parent()).removeClass('icon-check-empty');
          $(event.target).parent().addClass('selected');
        } else {
          $('i', $(event.target).parent()).removeClass('icon-check');
          $('i', $(event.target).parent()).addClass('icon-check-empty');
          $(event.target).parent().removeClass('selected');
        }
      });


    });


  };
})(jQuery);
