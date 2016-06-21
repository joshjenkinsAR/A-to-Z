<?php 
/*
Plugin Name: A to Z Index
Description: Creates an Index system with a custom item post type and shortcodes for display
Plugin URI: https://github.com/joshjenkinsAR/A-to-Z
Author: Josh Jenkins and John Wilson Impson
License: GPL
Version: 1.0.1
GitHub Plugin URI: https://github.com/joshjenkinsAR/A-to-Z
GitHub Branch: master
*/

/*** Include class and intialize metaboxes   ***/
require plugin_dir_path( __FILE__ ) . 'includes/class-post-type-metaboxes.php';

$post_type_metaboxes = new Item_Post_Type_Metaboxes;
$post_type_metaboxes->init();

//require plugin_dir_path( __FILE__ ) . 'includes/class-related-items.php';
require plugin_dir_path( __FILE__ ) . 'includes/az-alpha.php';
require plugin_dir_path( __FILE__ ) . 'includes/az-shortcode.php';

/*** Create custom post type for items   ***/

add_action('init', 'az_register_items');

function az_register_items() {
register_post_type('item', array(
		'label' => 'Item',
		'description' => 'Items for inclusion in A to Z index',
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'item', 'with_front' => true),
		'query_var' => true,
		'has_archive' => false,
		'supports' => array('title','revisions','thumbnail','genesis-seo', 'genesis-cpt-archives-settings' ),
		'taxonomies' => array('department','group'),
		'yarpp_support' => true,
			'labels' => array (
			  'name' => 'Items',
			  'singular_name' => 'Item',
			  'menu_name' => 'Index',
			  'add_new' => 'Add Item',
			  'add_new_item' => 'Add New Item',
			  'edit' => 'Edit',
			  'edit_item' => 'Edit Item',
			  'new_item' => 'New Item',
			  'view' => 'View Item',
			  'view_item' => 'View Item',
			  'search_items' => 'Search Items',
			  'not_found' => 'No Items Found',
			  'not_found_in_trash' => 'No Items Found in Trash',
			  'parent' => 'Parent Item',
			)
		)); 
}

/*** Create taxonomies for items ***/

add_action('init', 'az_register_department');
function az_register_department() {
	register_taxonomy( 'department',array (
		0 => 'item',
	),
		array( 'hierarchical' => true,
			'label' => 'Departments',
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
			'yarpp_support' => true,
			'labels' => array (
				'search_items' => 'Department',
				'popular_items' => '',
				'all_items' => 'All Departments',
				'parent_item' => 'Parent',
				'parent_item_colon' => '',
				'edit_item' => 'Edit',
				'update_item' => 'Update',
				'add_new_item' => 'Add Department',
				'new_item_name' => 'Department',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			)
	)); 
}

add_action('init', 'az_register_group');
function az_register_group() {
	register_taxonomy( 'group',array (
		0 => 'item',
	),
		array( 'hierarchical' => true,
			'label' => 'Groups',
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
			'yarpp_support' => true,
			'labels' => array (
				'search_items' => 'Group',
				'popular_items' => '',
				'all_items' => 'All Groups',
				'parent_item' => 'Parent Group',
				'parent_item_colon' => '',
				'edit_item' => 'Edit',
				'update_item' => 'Update',
				'add_new_item' => 'Add Group',
				'new_item_name' => 'Group',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			)
	)); 
}

/*** Add hidden alphabetical index taxonomy ***/

function alphaindex_alpha_tax() {
	register_taxonomy( 'alpha',array (
		0 => 'item',
	),
	array( 'hierarchical' => false,
		'label' => 'Alpha',
		'show_ui' => false,
		'query_var' => true,
		'show_admin_column' => false,
	) );
}
add_action('init', 'alphaindex_alpha_tax');