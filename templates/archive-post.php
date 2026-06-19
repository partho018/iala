<?php
/**
 * Template Name: Blog Posts Archive
 */

get_header();

$card_design_type = get_option( 'iala_blogs_card_design_type', 'default' );
$card_elementor_template = get_option( 'iala_blogs_card_elementor_template', 0 );
?>

<?php
$title = __( 'Blog Posts', 'iala-jobs' );
if ( is_category() ) {
    $title = single_cat_title( '', false );
} elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
} elseif ( is_author() ) {
    $title = sprintf( __( 'Posts by %s', 'iala-jobs' ), get_the_author() );
} elseif ( is_archive() ) {
    $title = get_the_archive_title();
}
?>

<div class="iala-jobs-archive-wrapper iala-blogs-archive-wrapper" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <!-- Archive Header Banner -->
    <div class="iala-archive-header" style="background-color: #ffe5e0; padding: 30px; border-radius: 12px; margin-bottom: 40px; border-left: 5px solid #FF3301;">
        <div class="iala-archive-breadcrumbs" style="font-size: 0.85rem; color: #64748b; margin-bottom: 10px; font-weight: 500;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #64748b; text-decoration: none;">Home</a>
            <span style="margin: 0 5px;">›</span>
            <span style="color: #FF3301;">Blog</span>
        </div>
        <h1 class="iala-archive-title" style="margin: 0 0 10px 0; font-size: 2rem; color: #0f172a; font-weight: 700;">
            <?php echo esc_html( $title ); ?>
        </h1>
    </div>

    <!-- Blog Posts Listing Grid -->
    <div id="iala-jobs-board" class="iala-jobs-container iala-blogs-container">
        <div id="iala-jobs-list" class="iala-jobs-list iala-blogs-list">
            <?php if ( have_posts() ) : ?>
                <?php 
                global $post;
                $original_post = $post;
                while ( have_posts() ) : the_post(); 
                    $post_id = get_the_ID();
                    
                    // Post featured image or placeholder
                    $logo = get_the_post_thumbnail_url( $post_id, 'medium' );
                    if ( ! $logo ) {
                        $letter = strtoupper( substr( get_the_title(), 0, 1 ) );
                        $bg_colors = array( '#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#3b82f6', '#8b5cf6' );
                        $char_code = ord($letter);
                        $color = $bg_colors[$char_code % count($bg_colors)];
                    }

                    // Get category
                    $post_cats = get_the_category( $post_id );
                    
                    // Get tags
                    $post_tags = get_the_tags( $post_id );
                ?>
                    <div class="<?php echo $card_design_type === 'elementor' ? 'iala-job-card iala-blog-card-elementor-type' : 'iala-job-card'; ?>">
                        
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
                                        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="iala-job-card-logo" />
                                    <?php else : ?>
                                        <div class="iala-job-card-logo-placeholder" style="background-color: <?php echo esc_attr($color); ?>;">
                                            <?php echo esc_html( $letter ); ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="iala-job-content-section">
                                <div class="iala-job-top-meta-row">
                                    <div class="iala-job-left-meta">
                                        <span class="iala-job-meta-category">
                                            <?php 
                                            if ( ! empty( $post_cats ) ) {
                                                echo esc_html( strtoupper( $post_cats[0]->name ) ); 
                                            } else {
                                                echo esc_html__( 'BLOG', 'iala-jobs' );
                                            }
                                            ?>
                                        </span>
                                        <span class="iala-job-meta-separator">/</span>
                                        <span class="iala-job-meta-author"><?php echo esc_html( strtoupper( get_the_author() ) ); ?></span>
                                        <span class="iala-job-meta-separator">/</span>
                                        <span class="iala-job-meta-date"><?php echo esc_html( strtoupper( get_the_date( 'j F Y' ) ) ); ?></span>
                                    </div>
                                    <?php 
                                    // Status badge: use first tag, otherwise default to "Article" or "Blog"
                                    $badge_name = 'Blog';
                                    $badge_class = 'iala-job-status-badge';
                                    if ( ! empty( $post_tags ) ) {
                                        $badge_name = $post_tags[0]->name;
                                        $tag_slug = strtolower($post_tags[0]->slug);
                                        if ( strpos($tag_slug, 'expire') !== false || strpos($tag_slug, 'close') !== false || strpos($tag_slug, 'alert') !== false ) {
                                            $badge_class .= ' status-expired';
                                        }
                                    } else {
                                        $badge_name = 'Article';
                                    }
                                    ?>
                                    <div class="iala-job-right-meta">
                                        <span class="<?php echo esc_attr($badge_class); ?>"><?php echo esc_html( $badge_name ); ?></span>
                                    </div>
                                </div>
                                <h3 class="iala-job-title-new">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
                // Restore original global post
                $post = $original_post;
                setup_postdata( $post );
                ?>
                
                <!-- Pagination -->
                <?php 
                $total_pages = $wp_query->max_num_pages;
                if ( $total_pages > 1 ) :
                    $current_page = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
                ?>
                    <div class="iala-pagination-wrapper" style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                        <div class="iala-pagination-container" style="display: flex; align-items: center; justify-content: space-between;">
                            <?php if ( $current_page > 1 ) : ?>
                                <a class="page-numbers prev" href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>">
                                    <?php esc_html_e( '← Previous Page', 'iala-jobs' ); ?>
                                </a>
                            <?php else : ?>
                                <span class="page-numbers prev disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid #cbd5e1; background-color: #ffffff; color: #0f172a; font-size: 0.85rem; font-weight: 700; padding: 0 1.25rem; height: 40px; border-radius: 6px; display: inline-flex; align-items: center;">
                                    <?php esc_html_e( '← Previous Page', 'iala-jobs' ); ?>
                                </span>
                            <?php endif; ?>

                            <div class="iala-page-counter" style="font-size: 0.9rem; font-weight: 600; color: #64748b;">
                                <?php echo sprintf( esc_html__( 'Page %d of %d', 'iala-jobs' ), $current_page, $total_pages ); ?>
                            </div>

                            <?php if ( $current_page < $total_pages ) : ?>
                                <a class="page-numbers next" href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>">
                                    <?php esc_html_e( 'Next Page →', 'iala-jobs' ); ?>
                                </a>
                            <?php else : ?>
                                <span class="page-numbers next disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid #cbd5e1; background-color: #ffffff; color: #0f172a; font-size: 0.85rem; font-weight: 700; padding: 0 1.25rem; height: 40px; border-radius: 6px; display: inline-flex; align-items: center;">
                                    <?php esc_html_e( 'Next Page →', 'iala-jobs' ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <div class="iala-no-jobs">
                    <?php esc_html_e( 'No blog posts found.', 'iala-jobs' ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
