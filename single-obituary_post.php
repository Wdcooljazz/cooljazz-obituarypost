<?php
/**
 * Created by PhpStorm.
 * User: Euclid The Dark
 * Date: 1/4/2016
 * Time: 9:39 PM
 */
namespace ArkaRobotics;

/*
 * Prevent a direct call of this script.  All WordPress supporting scripts must be called
 * indirectly through ~/index.php
 */
! defined( 'ABSPATH' ) and exit;

get_header(); ?>
    <div id="main" class="<?php echo of_get_option('layout_settings');?>">
        <?php
        // Start the Loop.
        while ( have_posts() ) : the_post();

            get_template_part( 'content', 'single');

        endwhile;
        ?>
    </div><!--main-->
<?php get_footer(); ?>