<?php
/**
 * Template Name: Single Job Listing (Elementor)
 * Post Type: job_listing
 */

get_header();
?>

<div class="iala-elementor-single-job-wrapper">
    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php
get_footer();
