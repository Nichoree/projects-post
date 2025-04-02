<?php
/**
 * Plugin Name:       Wordpress Portfolio By Nichoree
 * Plugin URI:        https://github.com/Nichoree/wordpress-posts-plugin
 * Description:       A WordPress plugin that allows users to create portfolios using a custom post type called projects.
 * Version:           0.1
 * Author:            Nichoree Designs <https://nichoree.com>, Nancy Victor <https://github.com/navish>
 * Author URI:        https://nichoree.com
 * Tags: wordpress, custom post type, portfolio, projects, work
 */

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


// Include other files if needed
require_once plugin_dir_path(__FILE__) . 'includes/portfolio-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/w3.css';


// Plugin activation/deactivation hooks (if needed)
// register_activation_hook(__FILE__, 'my_project_plugin_activate');
// register_deactivation_hook(__FILE__, 'my_project_plugin_deactivate');


/** Creates a custom post type called projects */
add_image_size('portfolio-image', 800, 600, true);

//add custom post type projects
function create_posttype()
{
    $labels = array(
        'name' => __('Projects'),
        'singular_name' => __('Project'),
        'add_new_item' => __('Add New Project'),
        'edit_item' => __('Edit Project'),
        'new_item' => __('New Project'),
        'view_item' => __('View Project'),
        'view_items' => __('View Items'),
        'all_items' => __('All Projects'),
        'archives' => __('Archived Projects'),
        'featured_image' => __('Project Cover'),
        'set_featured_image' => __('Set project cover'),
        'remove_featured_image' => __('Remove project cover'),
        'use_featured_image' => __('Use as project cover'),
        'item_published' => __('Project published'),
        'item_reverted_to_draft' => __('Project reverted to draft'),
        'item_updated' => __('Project Updated'),
        'filter_items-list' => __('Filter Projects List'),
        'items_list_navigation' => __('Projects List Navigation'),
        'items_list' => __('Projects List'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'description' => 'Post type for all the projects done for clients',
        'hierarchical' => true,
        'show_in_menu' => true,
        'show_in_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'has_archive' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projects'),
        'show_in_rest' => true,
        'can_export' => true,
        'capability_type' => 'post',
        'supports' => array('title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'post-formats'),
        'taxonomies' => array('category', 'project-category')
    );

    register_post_type('projects', $args);
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');

//query for projects 
function add_my_post_types_to_query($query)
{
    if (is_home() && $query->is_main_query())
        $query->set('post_type', array('post', 'projects'));
    return $query;
}
add_action('pre_get_posts', 'add_my_post_types_to_query');

