<?php
function wordpress_portfolio_shortcode($atts) {
    ob_start(); // Start output buffering

    $defaults = array(
        'post-type' => 'projects',
        'category' => 0,
        'number-of-posts' => -1 //Display all projects
    );

    $project_atts = shortcode_atts($defaults, $atts, 'projects-portfolio');
    $projects_args = array(
        'numberposts' => $project_atts['number-of-posts'],
        'post_type' => $project_atts['post-type'],
        'category_name' => $project_atts['category'],
    );

    $posts = get_posts($projects_args);

    if ($posts) { ?>
        <div class="w3-row-padding portfolio-row">
        <?php 
        foreach($posts as $post) { ?>
        
            <div class="w3-col l4 m6 s12">
          <a href=<?php echo get_permalink($post->ID); ?>>
              <span class="small-portfolio-image">
                <?php echo get_the_post_thumbnail($post->ID); ?>
              </span>
              <h4><?php echo esc_html( get_the_title($post->ID) ); ?></h4>
          </a>
        </div> <?php
        }
     } else {
        echo '<p>No projects found.</p>';
    }
        
    // always return a buffered output
    return ob_get_clean();

}
add_shortcode('projects-portfolio', 'wordpress_projects_shortcode');

?>