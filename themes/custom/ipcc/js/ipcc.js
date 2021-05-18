/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

  /**
   * Use this behavior as a template for custom Javascript.
   */
  Drupal.behaviors.exampleBehavior = {
    attach: function (context, settings) {
      $(".home-slider").owlCarousel({
        loop: true,
        dots: true,
        nav: false,
        items: 1,
        margin: 0,
        autoplay: true,
        autoHeight:true,
      });
      $(".home-noticias").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        autoplay: false,
        responsive:{
          0:{
            loop: false,
            items:1,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 30,
          },
          1000:{
            items:4,
            margin: 30,
          }
        }
      });
      $(".home-videos").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        autoplay: false,
        responsive:{
          0:{
            loop: false,
            items:1,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 30,
          },
          1000:{
            items:3,
            margin: 30,
          }
        }
      });
      $(".home-eventos").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        autoplay: false,
        responsive:{
          0:{
            loop: false,
            items:1,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:4,
            margin: 30,
          },
          1000:{
            items:4,
            margin: 30,
          }
        }
      });
      $(".home-convocatorias").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        autoplay: false,
        responsive:{
          0:{
            loop: false,
            items:1,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 30,
          },
          1000:{
            items:3,
            margin: 30,
          }
        }
      });
    }
  };

})(jQuery, Drupal);
