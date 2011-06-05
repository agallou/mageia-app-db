/*$(document).ready(function(){
  $('div#content a').flyout({
    inOpacity:0,
    fullSizeImage:false,
    inSpeed:300,
    outSpeed:300
  });
});
*/
$(document).ready(function(){
  $('#subscribeForm').dialog({
    autoOpen: false,
    width: 500,
    height: 400,
    modal: true,
    buttons: {
      "Subscribe": function() {
        $( this ).dialog( "close" );
      },
      Cancel: function() {
        $( this ).dialog( "close" );
      }
    },
    close: function() {
    }
  });
  $('a#packageSubscribe').click(function(event){
    $('#subscribeForm').dialog('open');
    event.preventDefault();
  });
});