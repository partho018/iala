<?php
/**
 * Template Name: Single Job Listing
 * Post Type: job_listing
 */

get_header();

$post_id = get_the_ID();

// Detect if post is built or being edited in Elementor
$is_elementor = false;
if ( class_exists( '\\Elementor\\Plugin' ) ) {
    $is_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) || \Elementor\Plugin::$instance->editor->is_edit_mode();
}

if ( $is_elementor ) {
    // Custom Elementor Design: Render content directly (uses the [iala_job_header_block] shortcode if placed)
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
} else {
    // Default Layout: Render all boxes automatically
    $company = get_post_meta( $post_id, '_job_company', true );
    $website = get_post_meta( $post_id, '_job_company_website', true );
    $location = get_post_meta( $post_id, '_job_location', true );
    $salary = get_post_meta( $post_id, '_job_salary', true );
    $apply_link = get_post_meta( $post_id, '_job_apply_link', true );

    // Get taxonomy terms
    $categories = wp_get_post_terms( $post_id, 'job_category' );
    $types = wp_get_post_terms( $post_id, 'job_type' );

    // Company Logo / Featured Image (cropped to 600x400)
    $logo = get_the_post_thumbnail_url( $post_id, 'iala-job-thumb' );
    if ( ! $logo ) {
        $logo = get_the_post_thumbnail_url( $post_id, 'large' );
    }

    // Generate apply link
    $application_url = esc_url($apply_link);
    if ( ! empty( $apply_link ) && strpos( $apply_link, '@' ) !== false && strpos( $apply_link, 'mailto:' ) === false ) {
        $application_url = 'mailto:' . antispambot( $apply_link );
    }

    $current_url = esc_url( get_permalink() );
    $encoded_title = urlencode( get_the_title() );
    $encoded_url = urlencode( $current_url );
    ?>
    <div class="iala-single-job-wrapper-new">
        <div class="iala-single-job-container-new">
            
            <!-- Breadcrumbs -->
            <div class="iala-single-breadcrumbs">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="iala-breadcrumb-home">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -1px; margin-right: 4px;"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </a>
                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <span class="iala-breadcrumb-separator">›</span>
                    <a href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>" class="iala-breadcrumb-link"><?php echo esc_html( $categories[0]->name ); ?></a>
                <?php endif; ?>
                <span class="iala-breadcrumb-separator">›</span>
                <span class="iala-breadcrumb-current"><?php the_title(); ?></span>
            </div>

            <!-- Title -->
            <h1 class="iala-single-title-new"><?php the_title(); ?></h1>

            <!-- Category Badge -->
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <div class="iala-single-cat-badge-container">
                    <span class="iala-single-cat-badge"><?php echo esc_html( $categories[0]->name ); ?></span>
                </div>
            <?php endif; ?>

            <!-- Meta Bar (Author & Date) -->
            <div class="iala-single-meta-bar-new">
                <span class="iala-single-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    <?php echo get_the_author(); ?>
                </span>
                <span class="iala-single-meta-separator">•</span>
                <span class="iala-single-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo get_the_date( 'F j, Y' ); ?>
                </span>
            </div>

            <!-- Featured Image / Logo Card -->
            <?php if ( $logo ) : ?>
                <div class="iala-single-image-card">
                    <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $company ); ?>" class="iala-single-image-el" />
                </div>
            <?php endif; ?>

            <!-- Share & spread the love -->
            <div class="iala-share-section">
                <div class="iala-share-title"><?php esc_html_e( 'Share & spread the love', 'iala-jobs' ); ?></div>
                <div class="iala-share-buttons">
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text=<?php echo $encoded_title . '%20' . $encoded_url; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-whatsapp" title="Share on WhatsApp">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.863-9.864.001-2.63-1.019-5.101-2.871-6.957C16.608 1.928 14.129.907 11.5.907c-5.438 0-9.863 4.42-9.866 9.865-.001 1.902.5 3.745 1.458 5.4l-.993 3.63 3.722-.976zm12.174-6.902c-.3-.15-1.782-.88-2.057-.98-.275-.1-.475-.15-.675.15-.2.3-.775 1-.95 1.2-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.795-1.49-1.77-1.665-2.07-.175-.3-.019-.462.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.625-.925-2.225-.244-.589-.491-.58-.675-.589-.175-.008-.375-.01-.575-.01-.2 0-.525.075-.8 0-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.7.635.717.227 1.37.195 1.885.118.575-.087 1.783-.73 2.033-1.43.25-.7.25-1.293.175-1.425-.075-.13-.275-.23-.575-.38z"/></svg>
                    </a>
                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $encoded_url; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-linkedin" title="Share on LinkedIn">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-facebook" title="Share on Facebook">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                    </a>
                    <!-- X (Twitter) -->
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $encoded_url; ?>&text=<?php echo $encoded_title; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-x" title="Share on X">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <!-- Threads -->
                    <a href="https://www.threads.net/intent/post?text=<?php echo $encoded_title . '%20' . $encoded_url; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-threads" title="Share on Threads">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.35 15.65c-.75 1.5-2.2 2.35-4.35 2.35-3.6 0-6.1-2.4-6.1-6 0-3.7 2.45-6.05 6.05-6.05 2.5 0 4.25 1.25 5 3 .35.8.45 1.7.45 2.65 0 2.35-1.15 3.75-2.85 3.75-.8 0-1.45-.4-1.75-1.1-.5.75-1.25 1.1-2.15 1.1-1.35 0-2.35-1-2.35-2.6 0-1.7 1.15-2.65 2.5-2.65.85 0 1.55.35 1.95.95v-.75c0-.95-.45-1.55-1.45-1.55-1.1 0-1.85.55-2.05 1.55l-1.9-.35c.4-1.95 2-3.1 3.95-3.1 2.25 0 3.4 1.25 3.4 3.4v4.5c0 .65.35.85.7.85.3 0 .65-.15.85-.45l1.1 1.5zm-5.45-4.1c0-.6-.35-.95-.9-.95-.6 0-.95.4-.95 1 0 .55.35.9.9.9.6 0 .95-.35.95-.95z"/></svg>
                    </a>
                    <!-- Telegram -->
                    <a href="https://t.me/share/url?url=<?php echo $encoded_url; ?>&text=<?php echo $encoded_title; ?>" target="_blank" rel="noopener noreferrer" class="iala-share-btn iala-share-telegram" title="Share on Telegram">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-1-.65-.35-1 .22-1.62.15-.15 2.72-2.5 2.77-2.7.01-.03.01-.14-.05-.2-.07-.06-.17-.04-.24-.02-.1.02-1.69 1.07-4.79 3.17-.45.3-.87.45-1.25.44-.42 0-1.22-.23-1.82-.42-.73-.24-1.3-.37-1.25-.78.03-.22.33-.44.9-.68 3.52-1.53 5.87-2.54 7.05-3 .3-.12 3.32-1.37 3.38-1.39.08-.01.27-.03.39.07.1.08.13.23.14.33v.16z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Main Body Content -->
            <article class="iala-single-content-new">
                <?php 
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile; 
                ?>
            </article>

            <!-- Apply Now Footer Section -->
            <?php if ( ! empty( $application_url ) ) : ?>
                <div class="iala-single-apply-wrapper">
                    <a href="<?php echo $application_url; ?>" target="_blank" rel="noopener noreferrer" class="iala-btn iala-btn-primary iala-single-apply-btn-big">
                        <?php esc_html_e( 'Apply for this Job', 'iala-jobs' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

get_footer();
