$(function() {
    var vid = document.getElementById("myVideo");
     vid.autoplay = true;
     vid.load();
     $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
           $("header").addClass("changeColor");
        } else {
           $("header").removeClass("changeColor");
        }
     });
  });
  