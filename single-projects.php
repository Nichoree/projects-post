<?php 
//Display single projects
get_header(); 
?>

<?php 
    if ( have_posts() ) : ?>
        <div class="w3-container w3-padding-64 page-content">
            <?php
                while ( have_posts() ) : the_post(); ?>
                    <div class="w3-row w3-padding-64">
                        <div class="w3-col m6 s12 ">
                            <?php the_title('<h1>', '</h1>'); ?>
                            <span class="project-category">
                                   <?php the_category(', '); ?>
                            </span>
                        </div>
                       
                        <div class="w3-col m6 s12 ">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                    <?php the_content();  ?>

                    <?php
                endwhile;
            ?>  
    </div>
   <?php
    else: 
        _e( 'Sorry, the project you are looking for can not be found.', 'textdomain' ); 
    endif; 
    ?>
<?php get_footer(); ?>

