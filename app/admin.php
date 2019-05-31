<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->selective_refresh->add_partial('blogname', [
		'selector' => '.brand',
		'render_callback' => function () {
			bloginfo('name');
		}
	]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
	wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

add_action('init', function(){
	register_post_type('salons', array(
		'labels'             => array(
			'name'               => 'Salons',
			'singular_name'      => 'salons'
		),
		'menu_icon'          => 'dashicons-excerpt-view',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		/*'taxonomies'		 => array( 'categories_salon' ),*/
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','comments')
	) );
	register_taxonomy('categories-salon', array('salons'), array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => array(
			'name'              => 'Salon category',
			'singular_name'     => 'Salon category',
			'search_items'      => 'Search Salons',
			'all_items'         => 'All Salons',
			'view_item '        => 'View Salon',
			'parent_item'       => 'Parent Salon',
			'parent_item_colon' => 'Parent Salon:',
			'edit_item'         => 'Edit Salon',
			'update_item'       => 'Update Salon',
			'add_new_item'      => 'Add New Salon Category',
			'new_item_name'     => 'New Salon Name',
			'menu_name'         => 'Salon categories',
		),
		'hierarchical'          => true,
		'show_admin_column'     => true,
	) );

	register_post_type('services', array(
		'labels'             => array(
			'name'               => 'Services',
			'singular_name'      => 'Services'
		),
		'menu_icon'          => 'dashicons-list-view',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		/*'taxonomies'		 => array( 'categories_salon' ),*/
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','comments')
	) );
	register_taxonomy('categories-service', array('services'), array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => array(
			'name'              => 'Service category',
			'singular_name'     => 'Service category',
			'search_items'      => 'Search Services',
			'all_items'         => 'All Services',
			'view_item '        => 'View Service',
			'parent_item'       => 'Parent Service',
			'parent_item_colon' => 'Parent Service:',
			'edit_item'         => 'Edit Service',
			'update_item'       => 'Update Service',
			'add_new_item'      => 'Add New Service Category',
			'new_item_name'     => 'New Service Name',
			'menu_name'         => 'Service categories',
		),
		'hierarchical'          => true,
		'show_admin_column'     => true,
	) );
	register_post_type('staff', array(
		'labels'             => array(
			'name'               => 'Staff',
			'singular_name'      => 'staff'
		),
		'menu_icon'          => 'dashicons-groups',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','comments')
	) );
});
