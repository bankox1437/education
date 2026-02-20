window.onload = function () {
  setTimeout(() => {
    var preloader = $(".preloader");
    preloader[0].style.display = "none";
    $("#section_content").fadeIn("slow");
  }, 500);
};
