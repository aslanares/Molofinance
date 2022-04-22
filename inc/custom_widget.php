<?php

/**
 * Class Molo_Social_Widget
 * @author Ainal
 * @version 1.0.0
 */
class Molo_Social_Widget extends WP_Widget {

	/**
	 * Molo_Social_Widget constructor.
	 */
	function __construct() {
		parent::__construct(
			'ie_social_widget',
			esc_html__( 'Social Widget', 'astra' )
		);
	}

	/**
     * List of fields to add.
     *
	 * @var array $widget_fields
	 */
	private $widget_fields = array(
		array(
			'label' => 'Facebook',
			'id' => 'facebook_url',
            'type' => 'url',
            'placeholder'=>'Enter facebook url',
		),
		array(
			'label' => 'LinkedIn',
			'id' => 'linkedin_url',
            'type' => 'url',
            'placeholder'=>'Enter linkedin url',
		),
		array(
			'label' => 'Twitter',
			'id' => 'twitter_url',
            'type' => 'url',
            'placeholder'=>'Enter twitter url',
		),
		array(
			'label' => 'Address',
			'id' => 'address_textarea',
            'type' => 'textarea',
            'placeholder'=>'Enter Address',
		),
	);

	/**
     * Widget output.
     *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
           
		}
        // Output generated fields
        echo '<div class="ie-social-area-wrap">';
		echo '<div class="ie-facebook"><a href="'.$instance['facebook_url'].'"><i class="fa fa-facebook"></i></a></div>';
		echo '<div class="ie-linkedin"><a href="'.$instance['linkedin_url'].'"><i class="fa fa-linkedin"></i></a></div>';
        echo '<div class="ie-twitter"><a href="'.$instance['twitter_url'].'"><i class="fa fa-twitter"></i></a></div>';
        echo '</div>';
		echo '<p class="ie-address">'.$instance['address_textarea'].'</p>';		
		echo $args['after_widget'];
	}

	/**
     * Generate Widget fields.
     *
	 * @param $instance
	 */
	public function field_generator( $instance ) {
		$output = ' ';
		foreach ( $this->widget_fields as $widget_field ) {
			$default = '';
			if ( isset($widget_field['default']) ) {
				$default = $widget_field['default'];
			}
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $default, 'molo' );

			switch ( $widget_field['type'] ) {
				case 'textarea':
					$output .= sprintf(
					        '<p><label for="%s">%s:</label><textarea class="widefat" id="%s" name="%s" rows="6" cols="6" placeholder="%s">%s</textarea></p>',
						esc_attr( $this->get_field_id( $widget_field['id'] ) ),
						esc_attr( $widget_field['label'], 'molo' ),
						esc_attr( $this->get_field_id( $widget_field['id'] ) ),
						esc_attr( $this->get_field_name( $widget_field['id'] ) ),
						esc_attr(($widget_field['placeholder'])),
						$widget_value
                    );
					break;
				default:
				    $output .= sprintf(
				            '<p><label for"%s">%s:</label><input class="widefat" id="%s" name="%s" type="%s" value="%s" placeholder="%s"></p>',
					        esc_attr( $this->get_field_id( $widget_field['id'] ) ),
					        esc_attr( $widget_field['label'], 'molo' ),
                            esc_attr( $this->get_field_id( $widget_field['id'] ) ),
                            esc_attr( $this->get_field_name( $widget_field['id'] ) ),
                            $widget_field['type'],
                            esc_attr( $widget_value ),
                            esc_attr(($widget_field['placeholder']))
                    );
			}
		}
		echo $output;
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'molo' );
		printf(
		        '<p><label for="%1$s">%2$s:</label><input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s"></p>',
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr__( 'Title', 'molo' ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $title )
        );
		$this->field_generator( $instance );
	}

	/**
     * Update the widget.
     *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
}

/**
 * Register our social widget.
 */
function register_ie_social_widget() {
	register_widget( 'Molo_Social_Widget' );
}
add_action( 'widgets_init', 'register_ie_social_widget' );

/**
 * Register footer sidebar
 */
if ( ! function_exists( 'molo_footer_fifth_sidebar' ) ) {
	function molo_footer_fifth_sidebar() {
		register_sidebar( array(
			'name'          => __( 'Footer Widget Area 5 ', 'molo' ),
			'id'            => 'advanced-footer-widget-5',
			'description'   => __( 'Add widget Area Five', 'molo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	add_action( 'widgets_init', 'molo_footer_fifth_sidebar', 14 );
}
