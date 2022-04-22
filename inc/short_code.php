<?php
if( ! defined('ABSPATH') ) die( 'No direct access!' );

if ( ! class_exists('Molo_Shortcodes') ) {

	/**
	 * Class Molo_Shortcodes
     * @author Ainal
     * @version 1.0.0
	 */
    class Molo_Shortcodes{

	    /**
	     * Molo_Shortcodes constructor.
	     */
        public function __construct() {
	        add_shortcode( 'molo_news_filter_shortcode', [ $this, 'news_filter_cb' ] );
	        add_shortcode( 'timeline_slider', [ $this, 'timeline_slider' ] );
	        add_shortcode( 'timeline_slider_mobile', [ $this, 'timeline_mobile_slider' ] );
        }

	    /**
         * [molo_news_filter_shortcode posts_per_page="-1"]
	     * @param array $atts
	     * @param string $content
	     *
	     * @return false|string
	     */
        public function news_filter_cb( $atts = array(), $content = '' ) {
	        $atts = shortcode_atts( array(
		        'posts_per_page' => '-1',
				'enable_search' => true,
	        ), $atts, 'molo_news_filter_shortcode' );

	        $args = array(
		        'post_type'      => 'post',
		        'post_status'    => 'publish',
		        'order'          => 'DESC',
		        'posts_per_page' => $atts['posts_per_page'],
		        'enable_search' => $atts['enable_search'],
	        );

	        $news = new WP_Query( $args );
	        ob_start();
	        if ( $news->have_posts() ) { ?>
		        <div class="molo-news-filter-wrapper">
			        <div class="molo-news-filter">
				        <div class="container">
					        <ul><?php
						        $all_categories = get_terms( 'category', array(
							        'hide_empty' => true,
						        ) );
						        ?>
						        <li class="molo-filter-item active" data-value="">
							        <span><?php _e( 'All', 'molo' ) ?></span>
						        </li>
						        <?php foreach ( $all_categories as $category ): ?>
							        <li class="molo-filter-item" data-value="<?php echo $category->slug; ?>">
								        <span><?php echo $category->name; ?></span>
							        </li>
						        <?php endforeach; ?>
					        </ul>
							
							<form id="search-wrap">
								<?php if($args['enable_search']): ?>
									<input type="search" placeholder="<?php _e( 'Search', 'molo' ); ?>..." name="search-field" id="search-field">
									<button type="submit"><?php _e( 'Search', 'molo' ); ?></button>
								<?php endif; ?>
								<input type="hidden" name="category-slug" id="category-slug">
							</form>
				        </div>
			        </div>

			        <div id="molo-news-post-wrap">
				        <div class="molo-news-post-search">
					        <?php
					        while ( $news->have_posts() ) : $news->the_post(); ?>
						        <div class="molo-news-item">
							        <a href="<?php the_permalink(); ?>">
								        <div class="news-thumbnail">
											<?php if(has_post_thumbnail()): ?>
									        <img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title(); ?>">
											<?php endif; ?>
								        </div>
							        </a>
							        <div class="molo-news-meta">
								        <div class="news-category">
									        <?php
									        $all_categories = get_the_terms( get_the_ID(), 'category' );
									        foreach ( $all_categories as $category ): ?>
										        <span><?php echo $category->name; ?></span>
									        <?php endforeach; ?>
								        </div>
								        <?php echo molo_social_share_markup( get_permalink( get_the_ID() ) ); ?>
							        </div>
							        <div class="molo-news-content">
								        <a href="<?php the_permalink(); ?>">
									        <h2><?php the_title(); ?></h2>
								        </a>
								        <?php 
											if ( has_excerpt() ) {
													echo wp_trim_words( get_the_excerpt(), 20, '<a class="read-link" href="'.get_the_permalink().'"> Read more »</a>' ) ;
												} else { 
													echo wp_trim_words( get_the_content(), 20, '<a class="read-link" href="'.get_the_permalink().'"> Read more »</a>' ) ;
												}
											
										?>
										
							        </div>
							        <div class="molo-news-bottom">
								        <p><?php _e( 'Posted by ', 'molo' ); ?>
									        <strong><?php the_author(); ?></strong>
								        </p>
								        <p><?php echo get_the_date( 'F j, Y' ); ?></p>
							        </div>
						        </div>
					        <?php
					        endwhile;
					        wp_reset_postdata();
					        wp_reset_query();
					        ?>
				        </div>
			        </div>
		        </div>
		        <?php
	        } else {
		        _e( 'Sorry, no posts found.', 'astra' );
	        }
	        return ob_get_clean();
        } // news_filter_cb

	    /**
	     * [timeline_slider show="-1"]
	     *
	     * @param array $atts
	     * @param string $content
	     *
	     * @return false|string
	     */
        public function timeline_slider( $atts = array(), $content = '' ) {
	        $atts = shortcode_atts( array(
		        'show'  => "1",
				'id'	=> "",
	        ), $atts, 'timeline_slider' );
	        $args = array(
		        'post_type'      => 'timelineslider',
		        'posts_per_page' => $atts['show'],
		        'post_status'    => 'publish',
		        'order'          => 'ASC',
				'p'				 => $atts['id'],
	        );
	        $timeline = new WP_Query( $args );
	        ob_start();
	        if ( $timeline->have_posts() ) { ?>
		        <div class="timeline-slider-section">
			        <div class="timeline-slider-dot-container">
				        <div class="timeline-slider-dot-wrapper">
							<?php while ( $timeline->have_posts() ) : $timeline->the_post();
							if( have_rows('time_line_slider') ):
							while( have_rows('time_line_slider') ): the_row();							
							$title = get_sub_field('title');
							$content = get_sub_field('content');					

							?>
						        <div class="timeline-slider-dots active">
							        <div class="timeline-left">
								        <div class="timeline-dot-line">
									        <div class="timeline-dot-line-dot"></div>
									        <div class="timeline-dot-line-line"></div>
								        </div>
							        </div>
							        <div class="timeline-right">
								        <div class="timeline-desk-title">
									        <p class="details-title"><?php echo $title; ?></p>
								        </div>
								        <div class="timeline-details">
									        <p class="details-title"><?php echo $title; ?></p>
									        <p class="details-content"><?php echo $content; ?></p>
								        </div>
							        </div>
						        </div>
							<?php 
							endwhile;
							endif;							
							 ?>
				        </div>
			        </div>

			        <div class="timeline-slider-container owl-carousel">
					
					<?php
						if( have_rows('time_line_slider') ):
							while( have_rows('time_line_slider') ): the_row();							
							$title = get_sub_field('title');
							$content = get_sub_field('content');
							$image = get_sub_field('slider_image');
						
						?>
					        <div class="timeline-slider-item">
						        <?php if ( !empty($image) ): ?>
							        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" class="carousel-image"/>
						        <?php
						        else:
							        _e( 'no image Found', 'astra' );
						        endif; ?>
					        </div>
						<?php
						endwhile;
						endif;
						endwhile;
							 ?>
			        </div>
		        </div>
		        <?php
	        } else {
		        _e( 'Sorry, no posts found.', 'astra' );
	        }
	        wp_reset_postdata();
	        wp_reset_query();
	        return ob_get_clean();
        } // timeline_slider

	    /**
	     * [timeline_slider_mobile show="-1"]
	     *
	     * @param array $atts
	     * @param string $content
	     *
	     * @return false|string
	     */
	    public function timeline_mobile_slider( $atts = array(), $content = '' ) {
		    $atts = shortcode_atts( array(
			    'show'  => "1",
				'id'	=> '',
		    ), $atts, 'timeline_slider_mobile' );

		    $args = array(
			    'post_type'      => 'timelineslider',
			    'posts_per_page' => $atts['show'],
			    'post_status'    => 'publish',
			    'order'          => 'ASC',
				'p'				 =>	$atts['id'],
		    );
		    $timeline_mobile = new WP_Query( $args );
		    ob_start();
		    if ( $timeline_mobile->have_posts() ) {
				while ( $timeline_mobile->have_posts() ) : $timeline_mobile->the_post();
				?>
			    <div class="timeline-slider-section-mobile">
				    <div class="timeline-slider-container-mobile owl-carousel">
						<?php
							if( have_rows('time_line_slider') ):
								while( have_rows('time_line_slider') ): the_row();							
									$image = get_sub_field('slider_image');
						?>
						    <div class="timeline-slider-item-mobile">
							    <?php if (!empty($image) ): ?>
								    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" class="carousel-image"/>
							    <?php
							    	else:
								    _e( 'no image Found', 'astra' );
									endif; 
								?>
						    </div>
						<?php
								endwhile;
							endif;
						 ?>
				    </div>
				    <div class="timeline-slider-dot-container-mobile">
					    <div class="timeline-slider-dot-wrapper-mobile">
							<?php
								if( have_rows('time_line_slider') ):
									while( have_rows('time_line_slider') ): the_row();							
									$title = get_sub_field('title');
									$content = get_sub_field('content');
							?>
							    <div class="timeline-slider-dots-mobile active">
								    <div class="timeline-details-mobile">
									    <p class="details-titles-mobile"><?php echo $title; ?></p>
									    <p class="details-contents-mobile"><?php echo $content; ?></p>
								    </div>
								    <div class="ie-dot"></div>
							    </div>
							<?php 
									endwhile;
								endif;
							?>
					    </div>
				    </div>
			    </div>
			    <?php
				endwhile;
		    } else {
			    _e( 'Sorry, no posts found.', 'astra' );
		    }
		    wp_reset_postdata();
		    wp_reset_query();
		    return ob_get_clean();
	    }

    }

    // Run our shortcodes
    function molo_run_all_shortcodes(){
        new Molo_Shortcodes();
    }
    molo_run_all_shortcodes();
}