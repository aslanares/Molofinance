<?php
if( ! defined('ABSPATH') ) die( 'No direct access!' );

if( !class_exists( 'Molo_Astra_Hooks' ) ) {
	/**
	 * Class Molo_Astra_Hooks
	 * @author Ainal
	 * @version 1.0.0
	 */
	class Molo_Astra_Hooks{

		/**
		 * Molo_Astra_Hooks constructor.
		 */
		public function __construct() {
			// Actions
			add_action( 'ast_footer_sml_layout', [ $this, 'footer_logo' ] );
			add_action( 'after_setup_theme', [ $this, 'register_nav_menu' ], 0 );
			add_action( 'astra_masthead_content', [ $this, 'header_right_menu' ] );
			add_action( 'astra_masthead_content', [ $this, 'mobile_menu_icon' ] );

			// Filters
			add_filter( 'astra_google_fonts_selected', [ $this, 'google_fonts' ] );
			add_filter( 'astra_header_break_point', [ $this, 'header_breakpoint' ] );
		}

		/**
		 * Markup for Footer Logo.
		 */
		public function footer_logo() {
			$site_url           = site_url();
			$molo_footer_logo     = get_theme_mod( 'footer_logo' );
			$molo_footer_text     = get_theme_mod( 'footer_text' );
			$molo_footer_text_extra     = get_theme_mod( 'footer_text_extra' );
			$molo_footer_text_alt = __( "Mono Finance", 'molo');

			printf (
				'<div class="footer-logo-text-section"><div class ="ast-container"><div class="footer-logo-and-address"><a href="%s" class="footer-logo"><img src="%s" alt="%s" class="footer-logo-img"></a><span class="footer-title">%s</span><a href="/about-molo/register-for-updates" class="elementor-button-link elementor-button elementor-size-sm" role="button"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Subscribe</span></span></a><p>%s</p></div></div></div>',
				$site_url, $molo_footer_logo, $molo_footer_text_alt, $molo_footer_text, $molo_footer_text_extra
			);

		} // footer_logo

		/**
		 * Register nav menu for header right side.
		 */
		public function register_nav_menu() {
			register_nav_menus( array(
				'header_right_menu' => __( 'Header Right Menu', 'molo' ),
			) );
		}

		/**
		 * Show the Header Right Side Menu.
		 */
		public function header_right_menu() {
			wp_nav_menu( array(
				'theme_location' => 'header_right_menu',
				'container_class'=> 'ie-header-right-menu-container',
				'menu_class'     => 'ie-header-right-menu',
				'fallback_cb'    => false
			) );
		} // header_right_menu

		/**
		 * Turn off google fonts.
		 *
		 * @param array $fonts
		 *
		 * @return array
		 */
		public function google_fonts( $fonts ) {
			return [];
		}

		/**
		 * Astra header breakpoint.
		 * @return int
		 */
		public function header_breakpoint() {
			return 799;
		}

		public function mobile_menu_icon() {
			$facebook_url = get_theme_mod( 'facebook_url' );
			$linkedin_url = get_theme_mod( 'linkedin_url' );
			$twitter_url  = get_theme_mod( 'twitter_url' );
			if(!empty($facebook_url) && !empty($linkedin_url) && !empty($twitter_url)) {
				printf(
					'<div class="ie-social-area-wrap ie-mobile-menu"><div class="ie-facebook"><a href="%s"><i class="fa fa-facebook"></i></a></div><div class="ie-linkedin"><a href="%s"><i class="fa fa-linkedin"></i></a></div><div class="ie-twitter"><a href="%s"><i class="fa fa-twitter"></i></a></div></div>',
					$facebook_url, $linkedin_url, $twitter_url
				);
			}
		}
	}

	// Run the Hooks customization
	function molo_run_astra_hooks(){
		new Molo_Astra_Hooks();
	}
	molo_run_astra_hooks();
}