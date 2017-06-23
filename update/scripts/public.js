function notification(msg, notif) {
  $('body').append("<div class='notification'>" + msg + "</div>");
  if (notif == "success") {
    color = "rgba(5, 255, 128, 0.76)";
  }else {
    color = "rgba(238, 36, 109, 0.76)";
  }
  $('.notification').css("background-color", color);
  $('.notification').fadeIn(800);
  $('.notification').click(function() {
    $(this).fadeOut('slow', function() {
      $(this).remove();
    });
  });
}

function ajaxrequest(url, target, time) {
  setInterval(function() {
    $.ajax({
      url: url,
      type: "POST",
      success: function(data) {
        $(target).html(data);
        console.log('ajax success');
      },
      error: function() {
        console.error('ajax error');
      }
    });
  }, time);
}
$.ajaxSetup({
  timeout: 10000,
  type: "POST",
  statusCode: {
    404: function() {
      alert('page not found');
      console.error("Page was not found");
    }
  },
  error: function() {
    console.error('ajax resquest error');
    swal("Error","Conexion Error","error");
  },
  success: function() {
    console.log('ajax request recieved seccess');
  }
});
$(document).ready(function() {

});
$(window).load(function() {

});
