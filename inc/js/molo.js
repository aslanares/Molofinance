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
                navText:["<img src='../wp-content/themes/ChildTheme/inc/images/left-arrow.svg'>","<img src='../wp-content/themes/ChildTheme/inc/images/right-arrow.svg'>"],
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

    $(document).ready(function(){
      $(".toggle-section").hide();
            // $(e.target)
      $(".toggle-btn .elementor-button").click(function(e){
        let getCurrentToggleSection = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
        console.log(getCurrentToggleSection);
        $(getCurrentToggleSection).slideToggle( "slow", function() {
          $(".toggle-btn .elementor-button-icon").toggleClass( "rotate-btn-icon" );
        });
      });
    })

    $(document).ready(function(){
      let $searchTrigger = $('[data-ic-class="search-trigger"]'),
          $searchInput = $('[data-ic-class="search-input"]'),
          $getFirstTabName = $('.filter-block .elementor-tabs-wrapper div:first-child').text().toLowerCase().replace(/\s/g, '-'),
          $articles = $(`.main-blog-posts.${$getFirstTabName ? $getFirstTabName : 'category-archive'} .elementor-posts-container article`),
          $loadPostsBtn = $('.load-more-posts.helper-class a'),
          $textArea = $('.text-posts-stat.helper-class .elementor-text-editor'),
          $postsResults = $('.posts-result .elementor-text-editor');
          
      let getBreadCrumbsLink = $('#breadcrumbs a').attr('href');
      let getButtonBackToArt = $('.back-to-art a').attr('href', getBreadCrumbsLink);
      if($(window).width() > 767)  {
        $searchTrigger.click(function() {
          let $this = $('[data-ic-class="search-trigger"]');
          $this.addClass('active');
          $searchInput.focus();
        });

        $searchInput.blur(function() {
          if($searchInput.val().length > 0){
            return false;
          } else {
            $searchTrigger.removeClass('active'); 
            $('.filter-block .elementor-tabs-wrapper')[0].classList.remove('filter-hide');
          }
        });

        $searchInput.focus(function() {
          $searchTrigger.addClass('active');
          $('.filter-block .elementor-tabs-wrapper')[0].classList.add('filter-hide');
        });
      } else {
        let $this = $('[data-ic-class="search-trigger"]');
        $this.addClass('active');
        $searchInput.focus();
      }

      if($(window).width() < 768) {
        console.log($('.filter-block .elementor-tabs-wrapper'))
        $('.filter-block .elementor-tabs-wrapper .elementor-tab-title').slideUp();
        $('.mobile-cat-dropdown > .elementor-container')[0].classList.add('mobile-filter-border');
        $('.dropdown-trigger .elementor-icon').click(function() {
          $('.filter-block .elementor-tabs-wrapper .elementor-tab-title').slideToggle();
          $('.mobile-cat-dropdown > .elementor-container')[0].classList.toggle('mobile-filter-border');
          $(this)[0].classList.toggle('rotate-arrow');
        });
      }

      function carouselPagination() {
        let defineRecentArt = $('.recent-art-section .posts-sidebar .elementor-posts-container article');
        let getPagContainer = $('.container-pagination')[0];
        const dotElem = document.createElement("div");
        dotElem.className = "car-dot";
        
        for (dots = 0; dots < defineRecentArt.length; dots++) {
          if (dots === 0) {
            dotElem.className = "car-dot active";
            getPagContainer.appendChild(dotElem.cloneNode(true));
          } else {
            dotElem.className = "car-dot";
            getPagContainer.appendChild(dotElem.cloneNode(true));
          }
        }

        let pos = 0;
        let posJump = 310;
        $(".car-dot").click(function(){
          if( $(this).hasClass("active") ){
            return;
          } else {
            function getCurrentPointNumber() {
              let getPagContainer = $('.container-pagination .car-dot');
              let pointNumber = 0;
              for (dotNum = 0; dotNum < defineRecentArt.length; dotNum++) {
                if (getPagContainer[dotNum].className === "car-dot active") {
                  pointNumber += dotNum + 1;
                }
              }

              return pointNumber;
            }

            let oldPointNumber = getCurrentPointNumber();

            $(".car-dot").removeClass("active");
            $(this).addClass("active");

            let newPointNumber = getCurrentPointNumber();
            if (oldPointNumber < newPointNumber) {
              pos = (newPointNumber - 1) * posJump;
              console.log(pos)
            } else if (oldPointNumber > newPointNumber) {
              pos = (newPointNumber - 1) * posJump;
              console.log(pos)
            }

            $(".posts-sidebar .elementor-posts-container").css({'right': pos + 'px'})
          }
        });
      }

      carouselPagination();
      elasticSearch($getFirstTabName);

      function postCounter(artLength, hidArtLength) {
        let showCounter = `Showing ${artLength - hidArtLength} of ${artLength}`;
        return $textArea.text(showCounter);
      }

      function elasticSearch(tabClassName) {
        $('#elastic').on('input', function () {
          let val = this.value.trim();
          let elasticItems = $(`.main-blog-posts.${tabClassName ? tabClassName : 'category-archive'} .elementor-post__card .elementor-post__title`);
          let $searchClear = $('[data-ic-class="search-clear"]');
          let recentArticlesList = $('.recent-articles-list');

          $searchClear.click(function() {
            $searchInput.val('');
            $postsResults.text('');
            Array.prototype.forEach.call(elasticItems, el => {
              el.parentNode.parentNode.parentNode.classList.remove('hide-elastic');
              recentArticlesList.show();
              $('.load-more-section').show();
              $('.first-time-section').show();
            });
          });

          if (val != '') {
            Array.prototype.forEach.call(elasticItems, el => {
              if (el.innerText.search(val) == -1) {
                el.parentNode.parentNode.parentNode.classList.add('hide-elastic');
                recentArticlesList.hide();
                let curPostsItems = $(`.main-blog-posts.${tabClassName ? tabClassName : 'category-archive'} .elementor-posts-container article:not(".hide-article"):not(".hide-elastic")`).length;
                if (curPostsItems === 0) {
                  $postsResults.text(`No result for: ${$searchInput.val()}`)
                  $postsResults[0].style.textAlign = 'center';
                } else {
                  $postsResults.text(`${curPostsItems} result for: ${$searchInput.val()}`)
                }
              } else {
                el.parentNode.parentNode.parentNode.classList.remove('hide-elastic');
                $('.load-more-section').hide();
                $('.first-time-section').hide();
              }
            });
          } else {
            Array.prototype.forEach.call(elasticItems, el => {
              el.parentNode.parentNode.parentNode.classList.remove('hide-elastic');
              recentArticlesList.show();
              $('.load-more-section').show();
              $('.first-time-section').show();
              $postsResults.text('');
            });
          }
        });
      }

      for (let art = 4; art < $articles.length; art++) {
        $articles[art].classList.add('hide-article');
      }

      function refactorHiderArt() {
        return $(`.main-blog-posts.${$getFirstTabName ? $getFirstTabName : 'category-archive'} .elementor-posts-container .hide-article`);
      }

      function postsResult(posts, searchStr) {
        let showPostsResult = `${posts} results of: ${searchStr}`;
        return showPostsResult;
      }


      postCounter($articles.length, refactorHiderArt().length);

      $loadPostsBtn.click(function(e) {
        let getHidenArt = refactorHiderArt();
        if (getHidenArt.length >= 4) {
          e.preventDefault();
          for (let hart = 0; hart < 4; hart++) {
            getHidenArt[hart].classList.remove('hide-article');
          }
        } else if (getHidenArt.length < 4) {
          e.preventDefault();
          let last;
          for (last = 0; last < getHidenArt.length; last++) {
            getHidenArt[last].classList.remove('hide-article');
          }
          postCounter($articles.length, getHidenArt.length - last);
        } 

        if (refactorHiderArt().length == 0) {
          $loadPostsBtn[0].style.cursor = 'not-allowed';
        }

        postCounter($articles.length, refactorHiderArt().length);
      });



      $('.filter-block .elementor-tabs-wrapper .elementor-tab-title').click(function(e) {
        let getTabName = $(e.target).text().toLowerCase().replace(/\s/g, '-');
        elasticSearch(getTabName);

        if (getTabName === 'all') {
          postCounter($articles.length, refactorHiderArt().length);
        } else {
          let $certainArticles = $(`.main-blog-posts.${getTabName} .elementor-posts-container article`);
          let $certainLoadPostsBtn = $(`.load-more-posts.${getTabName} a`);
          let $certainTextArea = $(`.text-posts-stat.${getTabName} .elementor-text-editor`);
          for (let art = 0; art < $certainArticles.length; art++) {
            $certainArticles[art].classList.remove('hide-article');
          }
          for (let art = 4; art < $certainArticles.length; art++) {
            $certainArticles[art].classList.add('hide-article');
          }

          function refactorCertainArt() {
            return $(`.main-blog-posts.${getTabName} .elementor-posts-container .hide-article`);
          }

          function CertainPostCounter(artLength, hidArtLength) {
            let showCounter = `Showing ${artLength - hidArtLength} of ${artLength}`;
            return $certainTextArea.text(showCounter);
          }

          CertainPostCounter($certainArticles.length, refactorCertainArt().length);
          
          $certainLoadPostsBtn.click(function(e) {
            let getHidenArt = refactorCertainArt();
            if (getHidenArt.length >= 4) {
              e.preventDefault();
              for (let hart = 0; hart < 4; hart++) {
                getHidenArt[hart].classList.remove('hide-article');
              }
            } else if (getHidenArt.length < 4) {
              e.preventDefault();
              let last;
              for (last = 0; last < getHidenArt.length; last++) {
                getHidenArt[last].classList.remove('hide-article');
              }
              CertainPostCounter($certainArticles.length, getHidenArt.length - last);
            } 

            if (refactorCertainArt().length == 0) {
              $certainLoadPostsBtn[0].style.cursor = 'not-allowed';
            }

            CertainPostCounter($certainArticles.length, refactorCertainArt().length);
            e.stopImmediatePropagation();
          });
        }

      });
    });
})(jQuery);