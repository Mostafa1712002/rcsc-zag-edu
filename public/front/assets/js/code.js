// start coding
$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // upload img
  jQuery(($) => {
    $('.attachment input[type="file"]')
      .on('change', (event) => {
      let el = $(event.target).closest('.attachment').find('.btn-file');
      
      el
        .find('.btn-file__actions__item')
        .css({
          'padding': '135px'
        });
      
      el
        .find('.btn-file__preview')
        .css({
          'background-image': 'url(' + window.URL.createObjectURL(event.target.files[0]) + ')'
        });
    });
  });
  // list grid plugin
  $(function() {
    $('#showdiv1').click(function() {
        $('div[id^=div]').hide();
        $('#div1').show();
    });
    $('#showdiv2').click(function() {
        $('div[id^=div]').hide();
        $('#div2').show();
    });

})
  // list grid plugin
  $(function() {
    $('#showdiv11').click(function() {
        $('div[id^=div]').hide();
        $('#div11').show();
    });
    $('#showdiv22').click(function() {
        $('div[id^=div]').hide();
        $('#div22').show();
    });

})