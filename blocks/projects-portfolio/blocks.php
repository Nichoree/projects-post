<?php
function wordpress_portfolio_render_projects_block($attributes, $content, $block) {
    $args = array(
        'post_type' => 'projects',
        'posts_per_page' => -1,
        'category' => 0,
    );

    $projects = new WP_Query($args);

    if ($projects->have_posts()) {
        $output = '<div class="projects-portfolio">';
        $output .= '<ul>';
        while ($projects->have_posts()) {
            $projects->the_post();
            $output .= '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No projects found.</p>';
    }
}

function wordpress_portfolio_register_blocks() {
    register_block_type('wordpress-portfolio/projects-portfolio', array(
        'render_callback' => 'wordpress-portfolio_render_projects_block',
        'editor_script' => 'wordpress-portfolio-projects-portfolio-block',
    ));
}
add_action('init', 'wordpress_portfolio_register_blocks');

function my_project_plugin_enqueue_block_assets() {
    wp_enqueue_script(
        'wordpress-portfolio-projects-list-block',
        plugins_url('blocks/projects-portfolio/block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-editor', 'wp-data'),
        filemtime(plugin_dir_path(__FILE__) . 'blocks/projects-portfolio/block.js')
    );
}
add_action('enqueue_block_editor_assets', 'wordpress_portfolio_enqueue_block_assets');