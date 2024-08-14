// Header Scroll Fixed animation

jQuery(window).scroll(function () {
  if (jQuery(this).scrollTop() > 50) {
    jQuery(".header").addClass("affix");
  } else {
    jQuery(".header").removeClass("affix");
  }
});


/*-------------------------------------
recommended banner
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".recommend-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 30,
    stagePadding: 15,
    nav: true,
    loop: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 2,
      },
    },
  });
});

/*-------------------------------------
category banner
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".category-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 30,
    stagePadding: 15,
    nav: true,
    loop: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3.5,
      },
    },
  });
});

/*-------------------------------------
explore banner
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".explore-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 30,
    stagePadding: 15,
    nav: true,
    loop: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 2,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 4,
      },
    },
  });
});

/*-------------------------------------
testimonial-slider
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".testimonial-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 10,
    nav: true,
    loop: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      },
    },
  });
});


/*-------------------------------------
image-slider
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".image-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 10,
    nav: true,
    loop: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 4,
      },
    },
  });
});

/*-------------------------------------
video-slider
-------------------------------------*/
$(document).ready(function () {
  var owl = $(".video-slider.owl-carousel");
  owl.owlCarousel({
    rtl: false,
    margin: 10,
    nav: true,
    loop: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 4,
      },
    },
  });
});






function showHide(elem) {
  if (elem.selectedIndex !== 0) {
    //hide the divs
    for (var i = 0; i < divsO.length; i++) {
      divsO[i].style.display = "none";
    }
    //unhide the selected div
    document.getElementById(elem.value).style.display = "block";
  }
}

window.onload = function () {
  //get the divs to show/hide
  divsO = document
    .getElementById("duration")
    .getElementsByClassName("show-hide");
};




// upload image


$(document).ready(function () {
  $(document).on('change', '.file-upload input[type="file"]', function () {
    var filename = $(this).val();
    if (/^\s*$/.test(filename)) {
      $(this).parents(".file-upload").removeClass('active');
      $(this).parents(".file-upload").find(".file-select-name").text("No file chosen...");
    } else {
      $(this).parents(".file-upload").addClass('active');
      $(this).parents(".file-upload").find(".file-select-name").text(filename.substring(filename.lastIndexOf("\\") + 1, filename.length));
    }
    var uploadFile = $(this);
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test(files[0].type)) { // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function () { // set image data as background of div
        uploadFile.closest(".file-upload").find('.imagePreview').css({ "background-image": "url(" + this.result + ")", "z-index": "2" });
      }
    }
  });
});




