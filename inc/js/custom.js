(function ($) {
  $(document).ready(function () {
    
      if (jQuery(window).width() <= 767) {
        // jQuery(window).on('resize', function () {
          jQuery('.p-startup-mentality .elementor-widget-wrap').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            autoplay: true,
            dots: false,
            smartSpeed: 1000,
            items: 1,
            autoHeight: false,
            responsive: {
              0: {
                stagePadding: 50,
              },
              380: {
                stagePadding: 80,
              },
              480: {
                stagePadding: 150,
              },
            },
          });
        // });
      }
    

    // var owl = jQuery('.timeline-slider-container').owlCarousel({
    //   items: 1,
    //   loop: true,
    //   dots: true,
    //   dotsContainer: '.timeline-slider-dot-container .timeline-slider-dot-wrapper',
    //   pagination: true,
    //   smartSpeed: 800,
    // });

    // jQuery('.timeline-slider-dot-wrapper').on('click', 'div', function (e) {
    //   //owl.trigger('next.owl.carousel', [500]);
    //   owl.trigger('to.owl.carousel', [jQuery(this).index(), 800]);
    // });
    
    // jQuery('.timeline-slider-dot-wrapper').on('click', 'div', function(e) {
    //   owl.on('changed.owl.carousel', function() {
    //       $('.timeline-slider-dots .details-content').slideUp( 300 );
    //       $('.timeline-slider-dots.active .details-content').slideDown( 300 );
    //   })

    // });

    // $(window).scroll(function() {
    //     var scroll = $(window).scrollTop();

    //     if (scroll >= 390) {
    //         $(".collapse.navbar-collapse").addClass("darkHeader");
    //     } else {
    //         $(".collapse.navbar-collapse").removeClass("darkHeader");
    //     }
    // });

    // $( "#target" ).scroll(function() {
    //     $( "#log" ).append( "<div>Handler for .scroll() called.</div>" );
    //   });

    // $('#ie_fname, #ie_lname, #ie_email').on('keyup', function() {
    //     if (allFilled()) $('#ie_reg_btn').removeAttr('disabled');
    // });

    // function allFilled() {
    //     var filled = true;

    //     $('.form-main-wrapper input').each(function() {
    //       if ($(this).val() == '' && $('#checkbox').prop('checked') == false)  filled = false;
    //     });
    //     return filled
    // };

    //$( '#ie_reg_btn' ).prop( 'disabled', true );

    // $('#ie_fname, #ie_lname, #ie_email').keyup(function() {
    // 	var empty = false;
    // 	$('#ie_fname, #ie_lname, #ie_email').each(function() {
    // 		if ($(this).val() == '') {
    // 			empty = true;
    // 		}
    // 	});

    // 	if (empty) {
    // 		$('#ie_reg_btn').attr('disabled', 'disabled');
    // 	} else {
    // 		$('#ie_reg_btn').removeAttr('disabled');
    // 	}
    // });
   // $('.ie-navbar-nav li:first-child a').addClass('current');
    if ($('#ie_fname').length > 0) {
      function checkNotEmpty() {
        let checked = $('.checkbox-input-wrapper input[type=checkbox]:checked').length > 0;
        input1 = $('#ie_fname').val().length > 0;
        input2 = $('#ie_lname').val().length > 0;
        input3 = $('#ie_email').val().length > 0;

        if (checked && input1 && input2 && input3) {
          $('#ie_reg_btn').attr('disabled', false);
        } else {
          $('#ie_reg_btn').attr('disabled', true);
        }
      }

      checkNotEmpty();

      $('#ie_fname, #ie_lname, #ie_email').on('keyup', function (e) {
        checkNotEmpty();
      });

      $('.checkbox-input-wrapper input[type=checkbox]').on('change', function (e) {
        checkNotEmpty();
      });
    }
    
    // Smooth Scroll with scrollspy
    var sections = [],
      id = false,
      $navbara = $('.ie-navbar-nav a');

    $navbara.first().addClass('current');

    $navbara.on('click', function (e) {
      e.preventDefault();
      hash($(this).attr('href'));
    });

    $navbara.each(function () {
      sections.push($($(this).attr('href')));
    });

    $(window).scroll(function (e) {
      
      var scrollTop = $(this).scrollTop() + 160;
      

     // console.log(scrollTop);

      for (var i in sections) {
        var section = sections[i];
        if (scrollTop > section.offset().top) {
          var scrolled_id = section.attr('id');
        }
      }
      if (scrolled_id !== id) {
        id = scrolled_id;
       
        $($navbara).removeClass('current');
        $('.ie-navbar-nav a[href="#' + id + '"]').addClass('current');
      }
     
      
    });

    hash = function (h) {
      if (history.pushState) {
        history.pushState(null, null, h);
      } else {
        location.hash = h;
      }
    };


    // News Ajax Filter
    $(".molo-filter-item").on("click", function (e) {
      e.preventDefault();

      $(".molo-filter-item").removeClass("active");
      $(this).addClass('active');

      $('#category-slug').val( $(this).data('value') );
      $('#search-field').val('');
      $('#search-wrap').submit();

    });

    $('#search-wrap').on('submit', function(e) {
      e.preventDefault();

      var value_search = $('#search-field').val();
      if(value_search) {
        $('#category-slug').val('');
        $(".molo-filter-item").removeClass("active");
      }

      $.ajax({
        method: "POST",
        url: ajaxObj.ajax_url,
        data: {
          action: "molo_news_filter",
          category: $('#category-slug').val(),
          search: value_search,
        },
        beforeSend: function () {
          $("body").append(
            '<div id="loader-wrapper"><div class="loader"></div></div>'
          );
        },
        success: function (response) {
          $("#molo-news-post-wrap").html(response);
          $("#loader-wrapper").remove();
        },
        error: function (error) {
          $("#loader-wrapper").remove();
          console.log(error);
        },
      });

    })
    // News Ajax Filter

  }); //Document Ready

  // Add offset to Elementor
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addFilter('frontend/handlers/menu_anchor/scroll_top_distance', function (scrollTop) {
      return scrollTop - 100;
    });
  });
})(jQuery);
