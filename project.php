<?php
//Display multiple projects


get_header(); 
?>
<?php
    $uri = $_SERVER['REQUEST_URI'];
    $uri_parts = explode("/", $uri);
    $category_name = array_reverse($uri_parts)[1];
?>
<div class="w3-padding-64 page-content" id="portfolio-section">
    <h2 class="w3-center category-title"><?php slug_to_string($category_name);  ?> </h2>
      <?php 
        $args = array( 'post_type' => 'projects', 'posts_per_page' => 9, 'category_name' => $category_name );
        $the_query = new WP_Query( $args ); 
          if ( $the_query->have_posts() ) : ?>
            <div class="w3-row-padding portfolio-row">
              <?php
            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <div class="w3-col l4 m6 s12">
                <a href=<?php echo get_permalink(); ?>>
                    <span class="small-portfolio-image">
                      <?php the_post_thumbnail(); ?>
                    </span>
                    <h4><?php the_title(); ?></h4>
                </a>
              </div>
            <?php
              endwhile;
              else:  
            ?>
            <p><?php _e( 'Sorry, no projects matched your criteria.' ); ?></p>
            </div>
      <?php endif; ?>
 
</div>

<?php get_footer(); ?>