<?php
if( ! defined( 'ABSPATH') ) die( 'No direct access!' );
/**
 * The template for displaying all single posts and attachments
 */
  
get_header(); ?>
  
    <main id="main" class="site-main news-single-post" role="main">
    <?php while ( have_posts() ) : the_post(); ?>

        <div class="news-single-top">
            <div class="news-single-meta">
                <h1><?php the_title(); ?></h1>
	            <?php echo molo_social_share_markup( get_permalink( get_the_ID() ) ); ?>
            </div>
            <div class="molo-news-bottom">
                <p><?php _e('Posted by ','molo');?><strong><?php the_author(); ?></strong>, <?php echo get_the_date('F j, Y'); ?></p>
            </div>
            <div class="news-thumbnail">
				<?php if(has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
				<?php endif; ?>
            </div>
        </div>
        <div class="news-single-content">
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
        <div class="news-single-bottom">
            <h2><?php _e( 'Recent articles', 'molo' ); ?></h2>
            <div class="news-single-recent-articles">
                <?php 
                $args = array(
                    'post_type' => 'post',
                    'post__not_in' => array( get_the_ID() ),
                    'post_status'    => 'publish',
                    'order'          => 'DESC',
                    'posts_per_page' => 3,
                );

                $news = new WP_Query( $args );

                if ( $news->have_posts() ) : ?>
                    <div class="molo-news-filter-wrapper">

                        <div id="molo-news-post-wrap">
                            <div class="molo-news-post-search">
                                <?php
                                while ( $news->have_posts() ) : $news->the_post(); ?>
                                    <div class="molo-news-item">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="news-thumbnail">
												<?php if(has_post_thumbnail()): ?>
                                                <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
												<?php endif; ?>
                                            </div>
                                        </a>
                                        <div class="molo-news-meta">
                                            <div class="news-category">
                                                <?php
                                                $all_categories = get_the_terms( $post->ID, 'category' );
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
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div> <!-- .molo-news-post-search -->
                        </div> <!-- .molo-news-post-wrap -->
                    </div> <!-- .molo-news-filter-wrapper -->
                <?php endif; ?>
            </div> <!-- .news-single-recent-articles -->
        </div> <!-- .news-single-bottom -->
    </main>
  
<?php get_footer(); ?>