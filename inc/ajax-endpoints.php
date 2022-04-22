<?php
if( ! defined('ABSPATH') ) die( 'No direct access!' );

if( ! class_exists( 'Molo_Ajax_Endpoints') ) {
	/**
	 * Class Molo_Ajax_Endpoints
	 * @author Ainal
	 * @version 1.0.0
	 */
	class Molo_Ajax_Endpoints{

		/**
		 * Molo_Ajax_Endpoints constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_molo_news_filter', [ $this, 'molo_news_ajax_filter'] );
			add_action( 'wp_ajax_nopriv_molo_news_filter', [ $this, 'molo_news_ajax_filter' ] );
		}

		/**
		 * Markup for news filter.
		 */
		public function molo_news_ajax_filter() {
			$ajx_args = array(
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'order'            => 'DESC',
				'posts_per_page'   => - 1,
			);

			if ( isset( $_POST['category'] ) && $_POST['category'] != '' ) {
				$ajx_args['tax_query'][] = array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $_POST['category']
				);
			}
			if( isset( $_POST['search'] ) && $_POST['search'] != '' ) {
				$ajx_args['s'] = $_POST['search'];
			}

			$ajax_news = new WP_Query( $ajx_args );

			if ( $ajax_news->have_posts() ) : ?>
				<div class="molo-news-post-search">
					<?php while ( $ajax_news->have_posts() ): $ajax_news->the_post(); ?>
						<div class="molo-news-item">
							<a href="<?php the_permalink(); ?>">
								<div class="news-thumbnail">
									<img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
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
								<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
								<?php the_excerpt(); ?>
							</div>
							<div class="molo-news-bottom">
								<p><?php _e('Posted by ','astra');?><strong><?php the_author(); ?></strong></p>
								<p><?php echo get_the_date('F j, Y'); ?></p>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php
			else:
				_e( 'Sorry, no posts found.', 'astra' );
			endif;
			echo ob_get_clean();

			wp_die();
		}
	}

	// Run the endpoints
	function molo_run_ajax_endpoints() {
		new Molo_Ajax_Endpoints();
	}
	molo_run_ajax_endpoints();
}