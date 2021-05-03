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
      $(".home-noticias").owlCarousel({
        loop: false,
        dots: false,
        nav: false,
        autoplay: false,
        responsive:{
          0:{
            loop: false,
            items:2,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 10,
          },
          1000:{
            items:4,
            margin: 10,
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
            items:2,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 10,
          },
          1000:{
            items:3,
            margin: 10,
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
            items:2,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:4,
            margin: 10,
          },
          1000:{
            items:4,
            margin: 10,
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
            items:2,
            stagePadding: 50,
            autoplay: false,
            margin: 10,
          },
          600:{
            items:3,
            margin: 10,
          },
          1000:{
            items:3,
            margin: 10,
          }
        }
      });
    }
  };

})(jQuery, Drupal);
