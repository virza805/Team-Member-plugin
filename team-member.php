<?php
/**
 * Plugin Name: Team Member
 * Description: Use this shortcode named ‘[team_members qty="3" img="top" btn="yes"] ’.
 * Plugin URI: https://vir-za.com
 * Version: 1.0.1
 * Author: 1mdalamin1
 * Author URI: https://www.linkedin.com/in/1mdalamin1
 * License: GPLv2
 * textdomain: tm
 */

// Exit if accessed directly wc_gift_card | gtw | Version: 1.10.0
if ( ! defined('ABSPATH')) {
    // return; 
    exit;
}
include_once 'tm-settings.php';

function tm_plugin_js(){ // tm_plugin_js | wc_gift_card_wp_admin_plugin_js

    wp_enqueue_style( 'tm_style', plugins_url( 'assets/style.css', __FILE__ ), false, "1.0.0");
    
    wp_localize_script("tm_script","ajax_object",array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));

    wp_enqueue_script('jquery');
    wp_enqueue_script('script', plugin_dir_url(__FILE__ ) . 'assets/js.js', array('jquery'), '5.0.55', true );


}
add_action('wp_enqueue_scripts', 'tm_plugin_js');



// Register Custom Post Type 'Team Member'
function custom_register_team_member_post_type() {
    $labels = array(
        'name'                  => _x( 'Team Members', 'Post Type General Name', 'tm' ),
        'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'tm' ),
        'menu_name'             => __( 'Team Members', 'tm' ),
        'all_items'             => __( 'All Team Members', 'tm' ),
        'add_new_item'          => __( 'Add New Team Member', 'tm' ),
        'add_new'               => __( 'Add New', 'tm' ),
        'new_item'              => __( 'New Team Member', 'tm' ),
        'edit_item'             => __( 'Edit Team Member', 'tm' ),
        'update_item'           => __( 'Update Team Member', 'tm' ),
        'view_item'             => __( 'View Team Member', 'tm' ),
        'view_items'            => __( 'View Team Members', 'tm' ),
        'search_items'          => __( 'Search Team Members', 'tm' ),
        'not_found'             => __( 'Not found', 'tm' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'tm' ),
        'featured_image'        => __( 'Feature Image', 'tm' ),
        'set_featured_image'    => __( 'Set feature image', 'tm' ),
        'remove_featured_image' => __( 'Remove feature image', 'tm' ),
        'use_featured_image'    => __( 'Use as feature image', 'tm' ),
        'insert_into_item'      => __( 'Insert into item', 'tm' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'tm' ),
        'items_list'            => __( 'Items list', 'tm' ),
        'items_list_navigation' => __( 'Items list navigation', 'tm' ),
        'filter_items_list'     => __( 'Filter items list', 'tm' ),
    );
    $args = array(
        'label'                 => __( 'Team Member', 'tm' ),
        'description'           => __( 'Team Member Description', 'tm' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail','excerpt' ), // 'custom-fields'
        'taxonomies'            => array( 'member_type' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'team_member', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'custom_register_team_member_post_type', 0 );

// Register Custom Taxonomy 'Member Type'
function custom_register_member_type_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Member Types', 'Taxonomy General Name', 'tm' ),
        'singular_name'              => _x( 'Member Type', 'Taxonomy Singular Name', 'tm' ),
        'menu_name'                  => __( 'Member Types', 'tm' ),
        'all_items'                  => __( 'All Member Types', 'tm' ),
        'parent_item'                => __( 'Parent Member Type', 'tm' ),
        'parent_item_colon'          => __( 'Parent Member Type:', 'tm' ),
        'new_item_name'              => __( 'New Member Type Name', 'tm' ),
        'add_new_item'               => __( 'Add New Member Type', 'tm' ),
        'edit_item'                  => __( 'Edit Member Type', 'tm' ),
        'update_item'                => __( 'Update Member Type', 'tm' ),
        'view_item'                  => __( 'View Member Type', 'tm' ),
        'separate_items_with_commas' => __( 'Separate Member Types with commas', 'tm' ),
        'add_or_remove_items'        => __( 'Add or remove Member Types', 'tm' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'tm' ),
        'popular_items'              => __( 'Popular Member Types', 'tm' ),
        'search_items'               => __( 'Search Member Types', 'tm' ),
        'not_found'                  => __( 'Not Found', 'tm' ),
        'no_terms'                   => __( 'No Member Types', 'tm' ),
        'items_list'                 => __( 'Member Types list', 'tm' ),
        'items_list_navigation'      => __( 'Member Types list navigation', 'tm' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'member_type', array( 'team_member' ), $args );
}
add_action( 'init', 'custom_register_member_type_taxonomy', 0 );

// [team_members qty="3" img="top" btn="yes" cid="32"] Short code
add_shortcode('team_members','team_members_short_code_fun');
function team_members_short_code_fun($jekono){ 
    $result = shortcode_atts(array( 
        'qty' =>'',
        'img' =>'',
        'btn' =>'',
        'cid' =>'',
    ),$jekono);
    extract($result);
    ob_start();

    $sQty = $qty ? $qty : -1; //  number of team members to show
    $sImg = $img ? $img : 'top'; // the position of image in the html template
    $sBtn = $btn ? $btn : 'yes'; // display or not ‘See all’ Button 

    $postT = get_option('tm_post_type');
    $postType = $postT ? $postT : 'team_member'; //
    
    if($cid){
        $args = array(
            'post_type' => $postType,
            'post_status' => 'publish',
            'posts_per_page' => $sQty, // Number of posts per page
            'tax_query' => array(
                array(
                    'taxonomy' => 'member_type',
                    'field' => 'term_id', // Specify the field for comparison
                    'terms' => $cid,
                ),
            ),
        );
    } else {
        $args = array(
            'post_type' => $postType,
            'post_status' => 'publish',
            'posts_per_page' => $sQty, // Number of posts per page
            
        );
    }
    $query = new WP_Query( $args );
    
    echo '<div class="team_wrap">';

if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
        
    
        // Output the post thumbnail URL
        $thumbnail_url = get_the_post_thumbnail_url();
        $archive_link = get_post_type_archive_link( 'team_member' );
        $single_post_link = get_permalink();
        
        if($sImg=="top"){
            echo '
            <a href="' . esc_url( $single_post_link ) . '" class="member"> ';
                if ( $thumbnail_url ) {
                    echo '<div class="profile"><img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '"></div>';
                }
            echo '<h3>'.the_title().'</h3>
                <div class="position">'.the_excerpt().'</div>
            </a>';
        }else{
            echo '
            <a href="' . esc_url( $single_post_link ) . '" class="member"> ';
                
            echo '<h3>'.the_title().'</h3>
                <div class="position">'.the_excerpt().'</div>';
                if ( $thumbnail_url ) {
                    echo '<div class="profile"><img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '"></div>';
                }
            echo '</a>';
        }
        

    endwhile;
    wp_reset_postdata();
else :
    echo 'No posts found';
endif;
echo '</div>';
if($sBtn=="yes"){
    echo '<p class="see-all-btn"><a href="' . esc_url( $archive_link ) . '">See all</a></p>';
}
    
    return ob_get_clean();
}

add_filter('template_include', 'tm_template_include', 10, 1);
function tm_template_include($template) {
    if (is_post_type_archive('team_member')) {
        $new_template = plugin_dir_path(__FILE__) . 'archive-team_member.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}


// function tm_modify_query_for_team_member($query) {
//     if (!is_admin() && $query->is_main_query() && is_post_type_archive('team_member')) {
//         $query->set('posts_per_page', 4);
//     }
// }
// add_action('pre_get_posts', 'tm_modify_query_for_team_member');
