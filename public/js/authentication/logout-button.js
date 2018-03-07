$(document).ready(function() {
  $(document).on('click', '.logoutButton',function() {
    $.ajax({
      type: 'GET',
      url: "authentication/logout"
  }).done(function() {
      url = "authentication";
      $(location).attr("href", url);
  })
  });
});
