<?php
if( ! defined( 'ABSPATH') ) die( 'No direct access!' );

/**
 * Load the parent and child styles and scripts
 */
if ( ! function_exists( 'molo_enqueue_scripts' ) ) {
	function molo_enqueue_scripts() {
		$child_dir = get_stylesheet_directory_uri();
		$child_ver = '1.0.0';
		wp_enqueue_style( 'astra-parent', get_template_directory_uri() . '/style.css' );
		//custom css
		wp_enqueue_style( 'owl-css', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', null, '2.3.4', 'all' );
		wp_enqueue_style( 'child-styles', $child_dir . '/inc/css/style.css', null, $child_ver, 'all' );
		//custom js
		wp_enqueue_script( 'owl-js', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
		if ( is_home() ) {
			wp_enqueue_script( 'trustpilot-js', '//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js', array( 'jquery' ), '5.0.0', true );
		};
		wp_enqueue_script( 'molo-js', $child_dir . '/inc/js/molo.js', array( 'jquery' ), $child_ver, true );
		wp_localize_script( 'molo-js', 'ajaxObj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );
	}
	add_action( 'wp_enqueue_scripts', 'molo_enqueue_scripts' );
}

/**
 * Social Share icons html.
 *
 * @param string $url
 *
 * @return string
 */
function molo_social_share_markup( $url = '' ) {
	if( empty( $url ) ) {
		global $post;
		$url = get_permalink( $post->ID );
	}
	$url = urlencode( esc_url( $url ) );
	ob_start(); ?>
	<div class="news-social">
		<a target="_black" href="https://www.facebook.com/sharer/sharer.php?u'=<?php echo $url; ?>"><i class="fa fa-facebook"></i></a>
		<a target="_black" href="https://twitter.com/home?status='<?php echo $url; ?>"><i class="fa fa-twitter"></i></a>
		<a target="_black" href="https://www.linkedin.com/shareArticle?mini=true&url='<?php echo $url; ?>&title=&summary=&source="><i class="fa fa-linkedin"></i></a>
	</div>
	<?php
	return ob_get_clean();
}



// Including the other files
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/short_code.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/custom_widget.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/customizer.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/astra-hooks.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/register_cpt.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/ajax-endpoints.php' );

function ie_header_script(){
  ?>


<style>
		#loading-spinner {
			display: flex;
			position: fixed;
			z-index: 99999999;
			width: 100%;
			height: 100%;
			background: rgba(255,255,255,1);
			top: 0px;
			left: 0px;
		}
		#loading-spinner .spin-icon {
			margin: auto;
			width: 40px;
			height: 40px;

			border: solid 3px transparent;
			border-top-color:  #2da9e4;
			border-left-color: #2da9e4;
			border-radius: 80px;

			-webkit-animation: loading-spinner 500ms linear infinite;
			-moz-animation:    loading-spinner 500ms linear infinite;
			-ms-animation:     loading-spinner 500ms linear infinite;
			-o-animation:      loading-spinner 500ms linear infinite;
			animation:         loading-spinner 500ms linear infinite;
		}
		@-webkit-keyframes loading-spinner {
			0%   { -webkit-transform: rotate(0deg);   transform: rotate(0deg); }
			100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
		}
		@-moz-keyframes loading-spinner {
			0%   { -moz-transform: rotate(0deg);   transform: rotate(0deg); }
			100% { -moz-transform: rotate(360deg); transform: rotate(360deg); }
		}
		@-o-keyframes loading-spinner {
			0%   { -o-transform: rotate(0deg);   transform: rotate(0deg); }
			100% { -o-transform: rotate(360deg); transform: rotate(360deg); }
		}
		@-ms-keyframes loading-spinner {
			0%   { -ms-transform: rotate(0deg);   transform: rotate(0deg); }
			100% { -ms-transform: rotate(360deg); transform: rotate(360deg); }
		}
		@keyframes loading-spinner {
			0%   { transform: rotate(0deg);   transform: rotate(0deg); }
			100% { transform: rotate(360deg); transform: rotate(360deg); }
		}
	</style>

  <?php
}
add_action( 'wp_head', 'ie_header_script' );



function ie_footer_tag(){
  ?>
  <script>
setTimeout(function() {
    var headID = document.getElementsByTagName("body")[0];        
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = 'https://static.zdassets.com/ekr/snippet.js?key=de82e384-cd7c-42fb-b21d-dc0f6772ec68';
	newScript.id = 'ze-snippet';
    headID.appendChild(newScript);
}, 7000);
</script>

<?php if( !is_front_page() ) : ?>
    <div id=loading-spinner>
        <div class=spin-icon></div>
    </div>
<?php endif; ?>
<script>
	jQuery(window).on('load', function () {
		if (jQuery("#loading-spinner").length > 0) {
		jQuery("#loading-spinner").fadeOut();
		}
	});
</script>
  <?php
}

add_action( 'wp_footer', 'ie_footer_tag' );



function get_parameter_from_url() {

    //https://molofinance.com/?utm_source=google&utm_medium=cpc&utm_campaign=hmo&utm_keyword=refresh&utm_content=longform

    $url_params = [];
    if (isset($_GET['utm_campaign'])) {
        $url_params['utm_campaign'] = $_GET['utm_campaign'];
    }
    if (isset($_GET['utm_source'])) {
        $url_params['utm_source'] = $_GET['utm_source'];
    }
    if (isset($_GET['utm_medium'])) {
        $url_params['utm_medium'] = $_GET['utm_medium'];
    }
    if (isset($_GET['utm_keyword'])) {
        $url_params['utm_keyword'] = $_GET['utm_keyword'];
    }
    if (isset($_GET['utm_content'])) {
        $url_params['utm_content'] = $_GET['utm_content'];
    }
    if (isset($_GET['gclid'])) {
        $url_params['gclid'] = $_GET['gclid'];
    }

    return $url_params;

}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

function add_async_attribute($tag, $handle)
{
    if(!is_admin()){
        if ('jquery-core' == $handle) {
            return $tag;
        }
        return str_replace(' src', ' defer src', $tag);
    }else{
        return $tag;
    }

}
