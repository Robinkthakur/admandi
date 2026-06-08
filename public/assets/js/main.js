$(document).ready(function(){
    $('.category-slider').slick({
      infinite: true,
      slidesToShow: 8,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      pauseOnHover:true,
      prevArrow: '<button type="button" class="slick-prev"><i class="bi bi-chevron-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="bi bi-chevron-right"></i></button>',

    });
    $('.ads-slider').slick({
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      pauseOnHover:true,
      prevArrow: '<button type="button" class="slick-prev"><i class="bi bi-chevron-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="bi bi-chevron-right"></i></button>',

    });

    $('.product-view-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="slick-prev"><i class="bi bi-chevron-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="bi bi-chevron-right"></i></button>',
      asNavFor: '.product-view-slider-thumb'
    });

    $('.product-view-slider-thumb').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: false,
      arrows: false,
      centerMode: false,
      focusOnSelect: true,
      asNavFor: '.product-view-slider'
    });
  
})

window.addEventListener('scroll', function () {

    const header = document.querySelector('.header');

    if (window.scrollY > 100) {
        header.classList.add('fixed');
    } else {
        header.classList.remove('fixed');
    }

});