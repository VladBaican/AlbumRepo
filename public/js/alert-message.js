$(document).ready(function() {
  $(document).on('click', '.alertMessageCloseButton', function() {
    $(this).parent().remove();
  });
});
