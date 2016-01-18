<?php
/*
Plugin Name: Obituary Post
Plugin URI: http://tempuri.org
Description: Obituary post builders, comments, candles, and social networking.
Version: 1.0
Author: Arka Robotics Consulting, LLC
Author URI: http://tempuri.org
License: ArkaRobotics
*/
namespace ArkaRobotics;

/*
 * Prevent a direct call of this script.  All WordPress supporting scripts must be called
 * indirectly through ~/index.php
 */
! defined( 'ABSPATH' ) and exit;

/**
 * This is the hook that initializes the Obituary Post.
 */

add_action('init', '\ArkaRobotics\create_obituary_post_type');

/**
 * This function gives the parameters for the Obituary Post.
 */

function create_obituary_post_type()
{
    $obituary_post_type = array(
        'labels' => array('name' => _x('Obituary Posts', 'obituary_post'),
            'singular_name' => _x('Obituary', 'obituary_post'),
            'add_new' => _x('Create Obituary', 'obituary_post'),
            'add_new_item' => _x('Add New Obituary Post', 'obituary_post'),
            'edit_item' => _x('Edit Obituary Post', 'obituary_post'),
            'new_item' => _x('New Obituary Post', 'obituary_post'),
            'view_item' => _x('View Obituaries', 'obituary_post'),
            'search_items' => _x('Search Obituaries', 'obituary_post'),
            'not_found' => _x('That person was not found.', 'obituary_post'),
            'not_found_in_trash' => _x('That person was not found in the trash.', 'obituary_post'),
            'parent_item_colon' => _x('Obituary:', 'obituary_post'),
            'menu_item' => _x('Obituary Posts', 'obituary_post')
        ),
        'description' => ('Obituary Posts filtered by names.'),
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        //put the menu icon in here
        'map_meta_cap' => true,
        'hierarchical' => true,
        'taxonomies' => array('Locations'),
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks',
            'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'has_archive' => true,
        'rewrite' => array('slug' => 'obituaries'),
        'query_var' => true,
        'can_export' => true
    );

    /**
     * This hook registers the Obituary Post for WordPress
     * Core to identify.
     */

    register_post_type('obituary_post', $obituary_post_type);
}

/**
 * This action initializes the taxonomy for the
 * Obituary Post.
 */

add_action( 'init', '\ArkaRobotics\locations_taxonomy');

/**
 * This function establishes the parameters for the taxonomy action.
 */

function locations_taxonomy()
{
    register_taxonomy(
        'locations',
        'obituary_post',
        array(
            'hierarchical' => true,
            'label' => 'Locations',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'locations',
                'with_front' => false
            )
        )
    );
}

/**
 * Output the carousel
 */


add_action('wp_enqueue_scripts', '\ArkaRobotics\register_comment_styles');

function register_comment_styles() {
    wp_register_style( 'obituarypost', plugins_url( 'obituarypost/css/bootstrap.min.css' ) );
    wp_enqueue_style( 'obituarypost' );
}

add_filter('comment_form_before_fields', '\ArkaRobotics\obit_form_top');

function obit_form_top() {
    if (is_singular('obituary_post')) {
        echo '<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">.
       <img src="' . plugins_url( 'obituarypost/img/candle-02.jpg') . '" >.
    </div>
    <div class="item">.
       <img src="' . plugins_url( 'obituarypost/img/candlesmokebybpcomp.jpg') . '" >.
    </div>
    <div class="item">.
       <img src="' . plugins_url( 'obituarypost/img/candles.jpeg') . '" >.
    </div>

    <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" style="text-decoration: none;" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" style="text-decoration: none;" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
  </a>
</div>';
    }
}

function obit_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script('custom-script', plugins_url('obituarypost/js/bootstrap.min.js'), array('jquery'));
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('custom-script');
}
add_action( 'wp_enqueue_scripts', '\ArkaRobotics\obit_scripts_with_jquery' );

function output_footer_script() {
    echo '<!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="'. plugins_url('obituarypost/js/bootstrap.min.js') . '"></script>';
}

add_filter('wp_footer', '\ArkaRobotics\output_footer_script');



