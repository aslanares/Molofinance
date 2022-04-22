<?php
if( ! defined( 'ABSPATH') ) die('No direct access!');

/**
 * Sanitize the Text
 * @param string $text
 *
 * @return mixed
 */
function molo_sanitize_text( $text ){
	return filter_var( $text, FILTER_SANITIZE_STRING );
};

/**
 * Sanitize the URL.
 *
 * @param string $url String URL.
 *
 * @return mixed
 */
function molo_sanitize_img( $url ){
	return filter_var( $url, FILTER_SANITIZE_URL );
};

if ( ! function_exists( 'molo_add_customizer_fields' ) ) {
	/**
	 * Add new fields on the Customizer.
	 *
	 * @param object $molo_customize
	 */
	function molo_add_customizer_fields( $molo_customize ) {

		$molo_customize->add_section( 'section-footer-logo' , array(
			'title'      => __( 'Footer Logo', 'astra' ),
			'priority'   => 56,

		) );

		$molo_customize->add_setting( 'footer_logo' , array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'molo_sanitize_img',

		) );

		$molo_customize->add_setting( 'footer_text' , array(
			'default'           => '84 Eccleston Square, Pimlico, London SW1V 1PX',
			'transport'         => 'refresh',
			'sanitize_callback' => 'molo_sanitize_text',
		) );


		$molo_customize->add_control(
			new WP_Customize_Image_Control(
				$molo_customize,
				'footer_logo',
				array(
					'label'      => __( 'Upload a Footer logo', 'astra' ),
					'section'    => 'section-footer-logo',
					'settings'   => 'footer_logo',
					'width'      => '130'
				)
			)
		);

		$molo_customize->add_control( 'footer_text', array(
			'label'      => __( 'Footer Text', 'astra' ),
			'section'    => 'section-footer-logo',
			'type'       => 'text',
			'settings'   => 'footer_text',
		) ) ;
		
		
		$molo_customize->add_setting( 'footer_text_extra' , array(
			'default'           => '84 Eccleston Square, Pimlico, London SW1V 1PX',
			'transport'         => 'refresh',
		) );

		$molo_customize->add_control( 'footer_text_extra', array(
			'label'      => __( 'Footer Text Extra', 'astra' ),
			'section'    => 'section-footer-logo',
			'type'       => 'textarea',
			'settings'   => 'footer_text_extra',
		) ) ;

		$molo_customize->add_section( 'ie-social-link' , array(
			'title'      => __( 'Social Profile Link', 'astra' ),
			'priority'   => 58,


		) );

		$molo_customize->add_setting( 'facebook_url' , array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'molo_sanitize_img',

		) );
		$molo_customize->add_setting( 'linkedin_url' , array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'molo_sanitize_img',

		) );
		$molo_customize->add_setting( 'twitter_url' , array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'molo_sanitize_img',

		) );
		$molo_customize->add_control( 'facebook_url', array(
			'label'      => __( 'Facebook Url', 'astra' ),
			'section'    => 'ie-social-link',
			'type'       => 'url',
			'settings'   => 'facebook_url',
		) ) ;
		$molo_customize->add_control( 'linkedin_url', array(
			'label'      => __( 'Linkedin Url', 'astra' ),
			'section'    => 'ie-social-link',
			'type'       => 'url',
			'settings'   => 'linkedin_url',
		) ) ;
		$molo_customize->add_control( 'twitter_url', array(
			'label'      => __( 'Twitter Url', 'astra' ),
			'section'    => 'ie-social-link',
			'type'       => 'url',
			'settings'   => 'twitter_url',
		) ) ;


	}
	add_action( 'customize_register', 'molo_add_customizer_fields' );
}