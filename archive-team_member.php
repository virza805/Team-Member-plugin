<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>


    <?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $args = array(
        'post_type' => 'team_member', // Specify the custom post type
        'post_status' => 'publish',
        'posts_per_page' => 4, // Show 4 members per page
        'paged' => $paged, // Pagination parameter
    );
    
    $query = new WP_Query( $args );
    
    echo '<div class="team_wrap">';
    
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            
            // Output the post thumbnail URL
            $thumbnail_url = get_the_post_thumbnail_url();
            $single_post_link = get_permalink();
            
            echo '<a href="' . esc_url( $single_post_link ) . '" class="member">';
            if ( $thumbnail_url ) {
                echo '<div class="profile"><img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '"></div>';
            }
            echo '<h3>' . get_the_title() . '</h3>
                  <div class="position">' . get_the_excerpt() . '</div>
                  </a>';
            
        endwhile;
    
        // Numeric pagination
        $pagination = paginate_links( array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'type' => 'array', // Set the type to 'array'
            'prev_text' => __( '&laquo; Previous', 'text-domain' ),
            'next_text' => __( 'Next &raquo;', 'text-domain' ),
        ) );
    
        if ( $pagination ) {
            echo '<div class="pagination">';
            foreach ( $pagination as $page_link ) {
                echo $page_link;
            }
            echo '</div>';
        }
    
        wp_reset_postdata();
    else :
        echo 'No posts found';
    endif;
    echo '</div>';
    
    
    ?>

	</div><!-- #primary -->



<?php get_footer(); ?>
