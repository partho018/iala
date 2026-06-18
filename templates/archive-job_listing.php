<?php
/**
 * Template Name: Job Listings Archive
 */

get_header();

$card_design_type = get_option( 'iala_jobs_card_design_type', 'default' );
$card_elementor_template = get_option( 'iala_jobs_card_elementor_template', 0 );
?>

<?php
$title = __( 'All Jobs', 'iala-jobs' );
if ( ! empty( $_GET['iala_cat'] ) ) {
    $term = get_term_by( 'slug', sanitize_text_field( $_GET['iala_cat'] ), 'job_category' );
    if ( $term ) {
        $title = sprintf( __( '%s Jobs', 'iala-jobs' ), $term->name );
    }
} else if ( ! empty( $_GET['iala_type'] ) ) {
    $term = get_term_by( 'slug', sanitize_text_field( $_GET['iala_type'] ), 'job_type' );
    if ( $term ) {
        $title = sprintf( __( '%s Jobs', 'iala-jobs' ), $term->name );
    }
}
?>

<div class="iala-jobs-archive-wrapper" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <!-- Archive Header Banner -->
    <div class="iala-archive-header" style="background-color: #ffe5e0; padding: 30px; border-radius: 12px; margin-bottom: 40px; border-left: 5px solid #FF3301;">
        <div class="iala-archive-breadcrumbs" style="font-size: 0.85rem; color: #64748b; margin-bottom: 10px; font-weight: 500;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #64748b; text-decoration: none;">Home</a>
            <span style="margin: 0 5px;">›</span>
            <span style="color: #FF3301;">Jobs</span>
        </div>
        <h1 class="iala-archive-title" style="margin: 0 0 10px 0; font-size: 2rem; color: #0f172a; font-weight: 700;">
            <?php echo esc_html( $title ); ?>
        </h1>
    </div>

    <!-- Jobs Listing Grid -->
    <div id="iala-jobs-board" class="iala-jobs-container">
        <div id="iala-jobs-list" class="iala-jobs-list">
            <?php if ( have_posts() ) : ?>
                <?php 
                global $post;
                $original_post = $post;
                while ( have_posts() ) : the_post(); 
                    $post_id = get_the_ID();
                    $company = get_post_meta( $post_id, '_job_company', true );
                    $location = get_post_meta( $post_id, '_job_location', true );
                    $salary = get_post_meta( $post_id, '_job_salary', true );
                    $apply_link = get_post_meta( $post_id, '_job_apply_link', true );
                    
                    // Get taxonomy slugs for filtering
                    $job_cats = wp_get_post_terms( $post_id, 'job_category' );
                    $job_types = wp_get_post_terms( $post_id, 'job_type' );

                    $cat_slugs = array();
                    foreach ( $job_cats as $cat ) {
                        $cat_slugs[] = $cat->slug;
                    }

                    $type_slugs = array();
                    foreach ( $job_types as $t ) {
                        $type_slugs[] = $t->slug;
                    }

                    // Company Logo (600x400 cropped version)
                    $logo = get_the_post_thumbnail_url( $post_id, 'iala-job-thumb' );
                    if ( ! $logo ) {
                        $letter = ! empty( $company ) ? strtoupper( substr( $company, 0, 1 ) ) : 'J';
                        $bg_colors = array( '#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#3b82f6', '#8b5cf6' );
                        $char_code = ord($letter);
                        $color = $bg_colors[$char_code % count($bg_colors)];
                    }
                ?>
                    <div class="<?php echo $card_design_type === 'elementor' ? 'iala-job-card iala-job-card-elementor-type' : 'iala-job-card'; ?>" 
                          data-categories="<?php echo esc_attr( implode( ',', $cat_slugs ) ); ?>"
                          data-types="<?php echo esc_attr( implode( ',', $type_slugs ) ); ?>"
                          data-title="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>"
                          data-company="<?php echo esc_attr( strtolower( $company ) ); ?>"
                          data-content="<?php echo esc_attr( strtolower( wp_strip_all_tags( get_the_content() ) ) ); ?>">
                        
                        <?php if ( $card_design_type === 'elementor' && ! empty( $card_elementor_template ) ) : ?>
                            <?php 
                            // Set up the global post data for Elementor dynamic content
                            $post = get_post( $post_id );
                            setup_postdata( $post );
                            echo iala_jobs_render_elementor_template( $card_elementor_template ); 
                            ?>
                        <?php else : ?>
                            <div class="iala-job-logo-section">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( $logo ) : ?>
                                        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $company ); ?>" class="iala-job-card-logo" />
                                    <?php else : ?>
                                        <div class="iala-job-card-logo-placeholder" style="background-color: <?php echo esc_attr($color); ?>;">
                                            <?php echo esc_html( $letter ); ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="iala-job-content-section">
                                <h3 class="iala-job-title-new">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="iala-job-meta-new">
                                    <span class="iala-meta-item">
                                        <span class="iala-meta-icon">🕒</span>
                                        <?php echo get_the_date( 'F j, Y' ); ?>
                                    </span>
                                    <span class="iala-meta-item">
                                        <span class="iala-meta-icon">✍️</span>
                                        <?php echo get_the_author(); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
                // Restore original global post
                $post = $original_post;
                setup_postdata( $post );

                // Pagination links
                global $wp_query;
                $total_pages = $wp_query->max_num_pages;
                if ( $total_pages > 1 ) {
                    $current_page = max( 1, get_query_var('paged') );
                    $big = 999999999;
                    echo '<div class="iala-pagination-wrapper">';
                    echo paginate_links( array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $current_page,
                        'total'     => $total_pages,
                        'prev_text' => __( '< PREV', 'iala-jobs' ),
                        'next_text' => __( 'NEXT >', 'iala-jobs' ),
                        'type'      => 'plain',
                    ) );
                    echo '</div>';
                }
                ?>
            <?php else : ?>
                <div class="iala-no-jobs">
                    <p><?php esc_html_e( 'No jobs found.', 'iala-jobs' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
