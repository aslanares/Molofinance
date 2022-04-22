(function ($) {
    $(document).ready(function () {      
      
      var owl = jQuery('.timeline-slider-container').owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        dotsContainer: '.timeline-slider-dot-container .timeline-slider-dot-wrapper',
        pagination: true,
        smartSpeed: 800,
        
      });
  
      jQuery('.timeline-slider-dot-wrapper').on('click', 'div', function (e) {
        //owl.trigger('next.owl.carousel', [500]);
        owl.trigger('to.owl.carousel', [jQuery(this).index(), 800]);       
      });   

      
      if (jQuery(window).width() <= 999) {  
      //mobile slider

      //var stylesheetDir = '<?= site_url(); ?>';
      var owlm = jQuery('.timeline-slider-container-mobile').owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        nav : true,
        navText:["<img src=/wp-content/themes/ChildTheme/inc/images/left-arrow.svg')>","<img src='wp-content/themes/ChildTheme/inc/images/right-arrow.svg'>"],
        dotsContainer: '.timeline-slider-dot-container-mobile .timeline-slider-dot-wrapper-mobile',
        pagination: true,
        smartSpeed: 800,
        
      });
  
      jQuery('.timeline-slider-dot-wrapper-mobile').on('click', 'div', function (e) {
        //owl.trigger('next.owl.carousel', [500]);
        owlm.trigger('to.owl.carousel', [jQuery(this).index(), 800]);
      });

      };  
      
      if (jQuery(window).width() <= 799) {      
        jQuery( ".site-branding, .ast-mobile-menu-buttons" ).on().wrapAll( '<div class="ie-mobile-top"></div>' );
        jQuery( ".ie-header-right-menu-container, .ie-social-area-wrap.ie-mobile-menu, .ast-main-header-bar-alignment" ).on().wrapAll( '<div class="ie-mobile-bottom"></div>' );
      }
      else{
        jQuery(window).on('resize', function () {
            if (jQuery(window).width() <= 799) {      
              jQuery( ".site-branding, .ast-mobile-menu-buttons" ).on().wrapAll( '<div class="ie-mobile-top"></div>' );
              jQuery( ".ie-header-right-menu-container, .ie-social-area-wrap.ie-mobile-menu, .ast-main-header-bar-alignment" ).on().wrapAll( '<div class="ie-mobile-bottom"></div>' );

            }
            
          });
      }
		
  
    
    }); //Document Ready
  
    // Add offset to Elementor
    
  })(jQuery);
  