(function ($) {
    $(document).ready(function () {
        if (jQuery(window).width() <= 767) {
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
        }
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

        });
        // News Ajax Filter

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
        //if (jQuery(window).width() <= 999) {
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
                owlm.trigger('to.owl.carousel', [jQuery(this).index(), 800]);
            });

        //}
        
		
        var clone1 = $( ".site-branding, .ast-mobile-menu-buttons" ).clone();
		var clone2 = $( ".ie-header-right-menu-container, .ie-social-area-wrap.ie-mobile-menu, .ast-main-header-bar-alignment" ).clone();
		$(".main-header-container").append($(clone1).wrapAll( '<div class="ie-mobile-top"></div>' ).parent());
		$(".main-header-container").append($(clone2).wrapAll( '<div class="ie-mobile-bottom"></div>' ).parent());
		
		// Mobile Menu Toggle
        $(".ie-mobile-top button.menu-toggle").on("click", function (e) {
            e.preventDefault();

            $(this).toggleClass("toggled");
			$("body").toggleClass("ast-main-header-nav-open");

        });
		
		
//         if (jQuery(window).width() <= 799) {
//             jQuery( ".site-branding, .ast-mobile-menu-buttons" ).one().wrapAll( '<div class="ie-mobile-top"></div>' );
//             jQuery( ".ie-header-right-menu-container, .ie-social-area-wrap.ie-mobile-menu, .ast-main-header-bar-alignment" ).one().wrapAll( '<div class="ie-mobile-bottom"></div>' );
//         }
//         else{
//             jQuery(window).one('resize', function () {
//                 if (jQuery(window).width() <= 799) {
//                     jQuery( ".site-branding, .ast-mobile-menu-buttons" ).one().wrapAll( '<div class="ie-mobile-top"></div>' );
//                     jQuery( ".ie-header-right-menu-container, .ie-social-area-wrap.ie-mobile-menu, .ast-main-header-bar-alignment" ).one().wrapAll( '<div class="ie-mobile-bottom"></div>' );
//                 }
//             });
//         }
		
    }); //Document Ready
    // Add offset to Elementor
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addFilter('frontend/handlers/menu_anchor/scroll_top_distance', function (scrollTop) {
            return scrollTop - 100;
        });
    });
})(jQuery);