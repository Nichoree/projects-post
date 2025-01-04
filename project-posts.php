<?php
/**
 * Plugin Name:       Project Posts
 * Plugin URI:        https://github.com/Nichoree/wordpress-posts-plugin
 * Description:       A WordPress plugin that allows users to create a custom post type called projects.
 * Version:           0.1
 * Author:            Nichoree Designs, Nancy Victor <https://github.com/navish>
 * Author URI:        https://nichoree.com
 * Tags: wordpress, custom post type, portfolio, projects
 */


/** Creates a custom post type called projects */


//add custom post type projects
  function create_posttype() {
    register_post_type( 'projects',

       array(
           'labels' => array(
               'name' => __( 'Projects' ),
               'singular_name' => __( 'Project' ),
               'add_new_item' => __( 'Add New Project' ),
               'edit_item' => __( 'Edit Project' ),
               'new_item' => __( 'New Project' ),
               'view_item' => __( 'View Project' ),
               'view_items' => __( 'View Items' ),
               'all_items' => __( 'All Projects' ),
               'archives' => __( 'Archived Projects' ),
               'featured_image' => __( 'Project Cover' ),
               'set_featured_image' => __( 'Set project cover' ),
               'remove_featured_image' => __( 'Remove project cover' ),
               'use_featured_image' => __( 'Use as project cover' ),
               'item_published' => __( 'Project published' ),
               'item_reverted_to_draft' => __( 'Project reverted to draft' ),
               'item_updated' => __( 'Project Updated' ),
               'filter_items-list' => __( 'Filter Projects List' ),
               'items_list_navigation' => __( 'Projects List Navigation' ),
               'items_list' => __( 'Projects List' ),

           ),
           'public' => true,
           'description' => 'Post type for all the projects done for clients',
           'hierarchical' => true,
           'show_in_menu' => true,
           'show_in_ui' => true,
           'show_in_nav_menus' => true,
           'show_in_admin_bar' => true,
           'hierarchical' => true,
           'has_archive' => true,
           'rewrite' => array('slug' => 'projects'),
           'show_in_rest' => true,
           'can_export' => true,
           'capability_type' => 'post',
           'supports' => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'post-formats' ),
           'taxonomies' => array( 'category', 'project-category' )

       )
      );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

//query for projects 
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'projects' ) );
    return $query;
}

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

//List projects posts

/** Adds shortcode to list project posts based on different categories 
 * 
 * HOW TO USE SHORTCODE
 * [projects-list post-type="projects" category=0 number-of-posts=3]
 *      "posts" in post-type can be replaced by custom post types
 * 
*/

function projects_list_styles() {
    wp_enqueue_style( 'w3', plugin_dir_url( __FILE__ ) . '/css/w3.css', false, '' , 'all' );
    wp_enqueue_style( 'projects-list', plugin_dir_url( __FILE__ ).'/css/posts-list.css', false, '' , 'all' );
    };
add_action( 'wp_enqueue_scripts', 'projects_list_styles' );

function posts_list_shortcode($atts)
    {
        ob_start();
        $defaults = array(
            'post-type' => 'projects',
            'category' => 0,
            'number-of-posts' => -1
        );
        $project_atts = shortcode_atts($defaults, $atts, 'projects-list');
        $projects_args = array(
            'numberposts' => $project_atts['number-of-posts'],
            'post_type' => $project_atts['post-type'],
            'category_name' => $project_atts['category'],
        );

        $projects = get_posts($projects_args);

        if ($projects) { ?>
            <div class="w3-row-padding post-row">
            <?php 
            foreach($projects as $project) { ?>
            
                <div class="w3-col l4 m6 s12">
                <a href=<?php echo get_permalink($project->ID); ?>>
                <div class="posts-list-image">
                    <?php echo get_the_post_thumbnail($project->ID); ?>
            </div>
                <h4><?php echo esc_html( get_the_title($project->ID) ); ?></h4>
            </a>
            </div> 
            <?php } ?>
            </div>
            <?php
        } else { echo "<p>No posts found </p>"; }
            
        // always return
        return ob_get_clean();
    }

// Register shortcode
add_shortcode('projects-list', 'projects_list_shortcode');
 ?>
