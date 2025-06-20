<?php

//
// Register Custom Post Types
//
function vsgkugelberg_register_department_post_type()
{
	register_post_type('department', array(
		'labels' => array(
			'name' => __('Departments', 'vsgkugelberg'),
			'singular_name' => __('Department', 'vsgkugelberg'),
			'add_new' => __('Add New', 'vsgkugelberg'),
			'add_new_item' => __('Add New Department', 'vsgkugelberg'),
			'edit_item' => __('Edit Department', 'vsgkugelberg'),
			'new_item' => __('New Department', 'vsgkugelberg'),
			'view_item' => __('View Department', 'vsgkugelberg'),
			'search_items' => __('Search Departments', 'vsgkugelberg'),
			'not_found' => __('No departments found', 'vsgkugelberg'),
			'not_found_in_trash' => __('No departments found in Trash', 'vsgkugelberg'),
			'all_items' => __('All Departments', 'vsgkugelberg'),
			'menu_name' => __('Departments', 'vsgkugelberg'),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'departments'),
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
		'menu_icon' => 'dashicons-calendar',
	));
}
add_action('init', 'vsgkugelberg_register_department_post_type');

//
// Register Custom Block Pattern Categories
//
function vsgkugelberg_register_pattern_categories()
{
	register_block_pattern_category('vsgkugelberg/queries', array(
		'label'       => __('VSG Kugelberg: Queries', 'vsgkugelberg'),
		'description' => __('Custom queries for VSG Kugelberg.', 'vsgkugelberg')
	));
	register_block_pattern_category('vsgkugelberg/sections', array(
		'label'       => __('VSG Kugelberg: Sections', 'vsgkugelberg'),
		'description' => __('Custom sections for VSG Kugelberg.', 'vsgkugelberg')
	));
}
add_action('init', 'vsgkugelberg_register_pattern_categories');

//
// Enqueue Block Styles And Scripts
//
function vsgkugelberg_styles()
{
	wp_enqueue_style(
		'vsgkugelberg-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'vsgkugelberg_styles');

//
// Load Text Domain For Translations
//
add_action('after_setup_theme', function () {
	load_theme_textdomain('vsgkugelberg', get_template_directory() . '/languages');
});

//
// Enable SVG Support
// 
function vsgkugelberg_check_filetype_and_ext($data, $file, $filename, $mimes)
{
	global $wp_version;

	if ($wp_version !== '4.7.1') {
		return $data;
	}

	$filetype = wp_check_filetype($filename, $mimes);

	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	];
}
add_filter('wp_check_filetype_and_ext', 'vsgkugelberg_check_filetype_and_ext', 10, 4);

function vsgkugelberg_upload_mimes($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'vsgkugelberg_upload_mimes');
