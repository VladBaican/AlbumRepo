$(document).ready(function() {
  $('.SelectPicker').selectpicker();
  $(document).on('change', '.SelectPicker', function(event) {
    var value = $(this).val();
    jQuery.ajax({
      type: "POST",
      url: 'Application/Services/TranslatorService.php',
      dataType: 'json',
      data: {functionname: 'setLocale', arguments: [value]},

      success: function (obj, textstatus) {
                    if( !('error' in obj) ) {
                      window.location.reload()
                    }
                    else {
                        console.log(obj.error);
                    };
              }
    });
  });
});
