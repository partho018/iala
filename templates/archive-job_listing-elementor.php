<?php
/**
 * Template Name: Jobs Board Archive (Elementor)
 */

get_header();
?>

<div class="iala-elementor-board-archive-wrapper">
    <?php
    $board_elementor_template = get_option( 'iala_jobs_board_elementor_template', 0 );
    if ( ! empty( $board_elementor_template ) ) {
        echo iala_jobs_render_elementor_template( $board_elementor_template );
    } else {
        echo do_shortcode( '[iala_jobs]' );
    }
    ?>
</div>

<?php
get_footer();
