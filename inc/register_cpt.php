<?php
if( ! defined( 'ABSPATH') ) die( 'No direct access!' );

if( ! class_exists( 'Molo_CPT_Register') ) {
	/**
	 * Class Molo_CPT_Register
	 * @author Ainal
	 * @version 1.0.0
	 */
    class Molo_CPT_Register{

	    /**
	     * @var string $cpt_name
	     */
    	public $cpt_name;

	    /**
	     * @var string|void $cpt_plural_name
	     */
	    public $cpt_plural_name;

	    /**
	     * @var string $cpt_slug
	     */
	    public $cpt_slug;

	    /**
	     * Molo_CPT_Register constructor.
	     * We can register any post type with this,
	     * but here we are register only timeline slider post type.
	     */
    	public function __construct() {
    		$this->cpt_slug = 'timelineslider';
    		$this->cpt_name = 'Timeline Slider';
    		$this->cpt_plural_name = 'Timeline Sliders';

		    add_action( 'init', [ $this, 'register_post_type' ], 0 );
	    }

	    public function register_post_type() {
		    register_post_type( $this->cpt_slug, $this->timeline_arguments() );
	    }

	    /**
	     * Timeline slider post type arguments.
	     *
	     * @return array
	     */
	    private function timeline_arguments() {
    		return array(
			    'label' => __( $this->cpt_name, 'molo'),
			    'description' => __( 'Timeline post type', 'molo' ),
			    'labels' => $this->timeline_labels(),
			    'menu_icon' => 'dashicons-editor-video',
			    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'page-attributes', 'post-formats', 'custom-fields'),
			    'taxonomies' => array(),
			    'public' => true,
			    'show_ui' => true,
			    'show_in_menu' => true,
			    'menu_position' => 20,
			    'show_in_admin_bar' => true,
			    'show_in_nav_menus' => true,
			    'can_export' => true,
			    'has_archive' => true,
			    'hierarchical' => true,
			    'exclude_from_search' => true,
			    'show_in_rest' => true,
			    'publicly_queryable' => true,
			    'capability_type' => 'post',
		    );
	    }

	    /**
	     * Timeline slider post type labels.
	     *
	     * @return array
	     */
	    private function timeline_labels() {
	    	return array(
			    'name' => _x( $this->cpt_plural_name, 'Post Type General Name', 'molo' ),
			    'singular_name' => _x( $this->cpt_name, 'Post Type Singular Name', 'molo' ),
			    'menu_name' => _x( $this->cpt_plural_name, 'Admin Menu text', 'molo' ),
			    'name_admin_bar' => _x( $this->cpt_name, 'Add New on Toolbar', 'molo' ),
			    'archives' => __( $this->cpt_name .' Archives', 'molo' ),
			    'attributes' => __( $this->cpt_name .' Attributes', 'molo' ),
			    'parent_item_colon' => __( 'Parent '. $this->cpt_name .':', 'molo' ),
			    'all_items' => __( 'All ' . $this->cpt_plural_name, 'molo' ),
			    'add_new_item' => __( 'Add New ' . $this->cpt_name, 'molo' ),
			    'add_new' => __( 'Add New', 'molo' ),
			    'new_item' => __( 'New ' . $this->cpt_name, 'molo' ),
			    'edit_item' => __( 'Edit ' . $this->cpt_name, 'molo' ),
			    'update_item' => __( 'Update ' . $this->cpt_name, 'molo' ),
			    'view_item' => __( 'View ' . $this->cpt_name, 'molo' ),
			    'view_items' => __( 'View ' . $this->cpt_plural_name, 'molo' ),
			    'search_items' => __( 'Search ' . $this->cpt_name, 'molo' ),
			    'not_found' => __( 'Not found', 'molo' ),
			    'not_found_in_trash' => __( 'Not found in Trash', 'molo' ),
			    'featured_image' => __( 'Featured Image', 'molo' ),
			    'set_featured_image' => __( 'Set featured image', 'molo' ),
			    'remove_featured_image' => __( 'Remove featured image', 'molo' ),
			    'use_featured_image' => __( 'Use as featured image', 'molo' ),
			    'insert_into_item' => __( 'Insert into ' . $this->cpt_name, 'molo' ),
			    'uploaded_to_this_item' => __( 'Uploaded to this ' . $this->cpt_name, 'molo' ),
			    'items_list' => __( $this->cpt_plural_name . ' list', 'molo' ),
			    'items_list_navigation' => __( $this->cpt_plural_name . ' list navigation', 'molo' ),
			    'filter_items_list' => __( 'Filter ' . $this->cpt_plural_name .' list', 'molo' ),
		    );
	    }
    }

    function molo_run_cpt_register(){
    	new Molo_CPT_Register();
    }
    molo_run_cpt_register();
}