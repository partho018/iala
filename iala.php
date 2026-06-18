<?php
/**
 * Plugin Name: IALA Simple Jobs Post
 * Plugin URI: https://pnscode.com
 * Description: A premium, simple, and responsive jobs post plugin featuring custom taxonomies, job details meta-boxes, a stunning frontend job board shortcode, and dynamic filtering.
 * Version: 1.1.7
 * Author: Raju
 * Author URI: https://pnscode.com
 * License: GPL2
 * Text Domain: iala-jobs
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define Constants
define( 'IALA_JOBS_VERSION', '1.1.7' );
define( 'IALA_JOBS_PATH', plugin_dir_path( __FILE__ ) );
define( 'IALA_JOBS_URL', plugin_dir_url( __FILE__ ) );

/**
 * 1. Register Custom Post Type: job_listing
 */
function iala_jobs_register_post_type() {
    $labels = array(
        'name'                  => _x( 'Jobs', 'Post type general name', 'iala-jobs' ),
        'singular_name'         => _x( 'Job', 'Post type singular name', 'iala-jobs' ),
        'menu_name'             => _x( 'Jobs', 'Admin Menu text', 'iala-jobs' ),
        'name_admin_bar'        => _x( 'Job', 'Add New on Toolbar', 'iala-jobs' ),
        'add_new'               => __( 'Add New', 'iala-jobs' ),
        'add_new_item'          => __( 'Add New Job', 'iala-jobs' ),
        'new_item'              => __( 'New Job', 'iala-jobs' ),
        'edit_item'             => __( 'Edit Job', 'iala-jobs' ),
        'view_item'             => __( 'View Job', 'iala-jobs' ),
        'all_items'             => __( 'All Jobs', 'iala-jobs' ),
        'search_items'          => __( 'Search Jobs', 'iala-jobs' ),
        'parent_item_colon'     => __( 'Parent Jobs:', 'iala-jobs' ),
        'not_found'             => __( 'No jobs found.', 'iala-jobs' ),
        'not_found_in_trash'    => __( 'No jobs found in Trash.', 'iala-jobs' ),
        'featured_image'        => _x( 'Company Logo', 'Overrides the “Featured Image” phrase', 'iala-jobs' ),
        'set_featured_image'    => _x( 'Set company logo', 'Overrides the “Set featured image” phrase', 'iala-jobs' ),
        'remove_featured_image' => _x( 'Remove company logo', 'Overrides the “Remove featured image” phrase', 'iala-jobs' ),
        'use_featured_image'    => _x( 'Use as company logo', 'Overrides the “Use as featured image” phrase', 'iala-jobs' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'jobs' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author' ),
        'show_in_rest'       => true, // Enable Block Editor support
    );

    register_post_type( 'job_listing', $args );
}
add_action( 'init', 'iala_jobs_register_post_type' );

/**
 * Register Custom Image Size for Job Logos/Images (600x400)
 */
function iala_jobs_setup_theme_features() {
    add_image_size( 'iala-job-thumb', 600, 400, true );
}
add_action( 'after_setup_theme', 'iala_jobs_setup_theme_features' );

/**
 * 2. Register Custom Taxonomies: job_category & job_type
 */
function iala_jobs_register_taxonomies() {
    // Job Categories
    $cat_labels = array(
        'name'              => _x( 'Job Categories', 'taxonomy general name', 'iala-jobs' ),
        'singular_name'     => _x( 'Job Category', 'taxonomy singular name', 'iala-jobs' ),
        'search_items'      => __( 'Search Job Categories', 'iala-jobs' ),
        'all_items'         => __( 'All Job Categories', 'iala-jobs' ),
        'parent_item'       => __( 'Parent Job Category', 'iala-jobs' ),
        'parent_item_colon' => __( 'Parent Job Category:', 'iala-jobs' ),
        'edit_item'         => __( 'Edit Job Category', 'iala-jobs' ),
        'update_item'         => __( 'Update Job Category', 'iala-jobs' ),
        'add_new_item'      => __( 'Add New Job Category', 'iala-jobs' ),
        'new_item_name'     => __( 'New Job Category Name', 'iala-jobs' ),
        'menu_name'         => __( 'Categories', 'iala-jobs' ),
    );

    $cat_args = array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'job-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'job_category', array( 'job_listing' ), $cat_args );

    // Job Types (Full-Time, Part-Time, Contract, etc.)
    $type_labels = array(
        'name'              => _x( 'Job Types', 'taxonomy general name', 'iala-jobs' ),
        'singular_name'     => _x( 'Job Type', 'taxonomy singular name', 'iala-jobs' ),
        'search_items'      => __( 'Search Job Types', 'iala-jobs' ),
        'all_items'         => __( 'All Job Types', 'iala-jobs' ),
        'parent_item'       => __( 'Parent Job Type', 'iala-jobs' ),
        'parent_item_colon' => __( 'Parent Job Type:', 'iala-jobs' ),
        'edit_item'         => __( 'Edit Job Type', 'iala-jobs' ),
        'update_item'         => __( 'Update Job Type', 'iala-jobs' ),
        'add_new_item'      => __( 'Add New Job Type', 'iala-jobs' ),
        'new_item_name'     => __( 'New Job Type Name', 'iala-jobs' ),
        'menu_name'         => __( 'Job Types', 'iala-jobs' ),
    );

    $type_args = array(
        'hierarchical'      => true,
        'labels'            => $type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'job-type' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'job_type', array( 'job_listing' ), $type_args );
}
add_action( 'init', 'iala_jobs_register_taxonomies' );

/**
 * 3. Custom Meta Boxes for Job Details
 */
function iala_jobs_add_meta_boxes() {
    add_meta_box(
        'iala_job_details',
        __( 'Job Details', 'iala-jobs' ),
        'iala_jobs_meta_box_callback',
        'job_listing',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'iala_jobs_add_meta_boxes' );

function iala_jobs_meta_box_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'iala_jobs_save_meta_box_data', 'iala_jobs_meta_box_nonce' );

    // Retrieve current values
    $offer_types = get_post_meta( $post->ID, '_job_offer_types', true );
    if ( ! is_array( $offer_types ) ) {
        // Default to 'job' for new or existing listings
        $offer_types = array( 'job' );
    }
    ?>
    <div class="iala-jobs-meta-fields" style="padding: 10px;">
        <p style="margin-bottom: 5px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;"><?php esc_html_e( 'Listing Offer Type', 'iala-jobs' ); ?></label>
            <label style="margin-right: 20px; font-weight: 500; cursor: pointer;">
                <input type="checkbox" name="iala_job_offer_types[]" value="job" <?php checked( in_array( 'job', $offer_types ) ); ?> style="margin-right: 5px; vertical-align: middle;" /> 
                <span style="vertical-align: middle;"><?php esc_html_e( 'Job', 'iala-jobs' ); ?></span>
            </label>
            <label style="font-weight: 500; cursor: pointer;">
                <input type="checkbox" name="iala_job_offer_types[]" value="internship" <?php checked( in_array( 'internship', $offer_types ) ); ?> style="margin-right: 5px; vertical-align: middle;" /> 
                <span style="vertical-align: middle;"><?php esc_html_e( 'Internship', 'iala-jobs' ); ?></span>
            </label>
        </p>
    </div>
    <?php
}

function iala_jobs_save_meta_box_data( $post_id ) {
    // Security check: nonce
    if ( ! isset( $_POST['iala_jobs_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['iala_jobs_meta_box_nonce'], 'iala_jobs_save_meta_box_data' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( isset( $_POST['post_type'] ) && 'job_listing' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Save fields
    if ( isset( $_POST['iala_job_company'] ) ) {
        update_post_meta( $post_id, '_job_company', sanitize_text_field( $_POST['iala_job_company'] ) );
    }
    if ( isset( $_POST['iala_job_company_website'] ) ) {
        update_post_meta( $post_id, '_job_company_website', esc_url_raw( $_POST['iala_job_company_website'] ) );
    }
    if ( isset( $_POST['iala_job_location'] ) ) {
        update_post_meta( $post_id, '_job_location', sanitize_text_field( $_POST['iala_job_location'] ) );
    }
    if ( isset( $_POST['iala_job_salary'] ) ) {
        update_post_meta( $post_id, '_job_salary', sanitize_text_field( $_POST['iala_job_salary'] ) );
    }
    if ( isset( $_POST['iala_job_apply_link'] ) ) {
        update_post_meta( $post_id, '_job_apply_link', sanitize_text_field( $_POST['iala_job_apply_link'] ) );
    }
    if ( isset( $_POST['iala_job_offer_types'] ) && is_array( $_POST['iala_job_offer_types'] ) ) {
        $offer_types = array_map( 'sanitize_text_field', $_POST['iala_job_offer_types'] );
        update_post_meta( $post_id, '_job_offer_types', $offer_types );
    } else {
        update_post_meta( $post_id, '_job_offer_types', array() );
    }
}
add_action( 'save_post', 'iala_jobs_save_meta_box_data' );

/**
 * 4. Enqueue Frontend Styles & Scripts
 */
function iala_jobs_enqueue_scripts() {
    wp_enqueue_style( 'iala-jobs-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'iala-jobs-styles', IALA_JOBS_URL . 'css/style.css', array(), IALA_JOBS_VERSION );
    wp_enqueue_script( 'iala-jobs-scripts', IALA_JOBS_URL . 'js/script.js', array( 'jquery' ), IALA_JOBS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'iala_jobs_enqueue_scripts' );

/**
 * 5. Shortcode [iala_jobs] for Job Listing Board
 */
function iala_jobs_shortcode( $atts ) {
    // Get Settings
    $default_posts_per_page = intval( get_option( 'iala_jobs_posts_per_page', 15 ) );
    
    $atts = shortcode_atts( array(
        'posts_per_page' => $default_posts_per_page,
        'offer_type'     => '', // 'job' or 'internship'
    ), $atts, 'iala_jobs' );

    $card_design_type = get_option( 'iala_jobs_card_design_type', 'default' );
    $card_elementor_template = get_option( 'iala_jobs_card_elementor_template', 0 );

    // Get Taxonomies for filters
    $categories = get_terms( array(
        'taxonomy'   => 'job_category',
        'hide_empty' => true,
    ) );

    $types = get_terms( array(
        'taxonomy'   => 'job_type',
        'hide_empty' => true,
    ) );

    // Get page number for pagination
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    if ( get_query_var( 'page' ) ) {
        $paged = get_query_var( 'page' );
    }

    // Determine offer type from attribute or current page context
    $offer_type = sanitize_text_field( $atts['offer_type'] );
    if ( empty( $offer_type ) ) {
        $current_page_id = get_the_ID();
        $board_page_id = get_option( 'iala_jobs_board_page_id', 0 );
        $internships_page_id = get_option( 'iala_jobs_internships_page_id', 0 );

        if ( ! empty( $board_page_id ) && $current_page_id == $board_page_id ) {
            $offer_type = 'job';
        } elseif ( ! empty( $internships_page_id ) && $current_page_id == $internships_page_id ) {
            $offer_type = 'internship';
        }
    }

    // Query Jobs
    $args = array(
        'post_type'      => 'job_listing',
        'posts_per_page' => intval( $atts['posts_per_page'] ),
        'paged'          => $paged,
        'post_status'    => 'publish',
    );

    // Apply offer type filters (meta_query)
    if ( $offer_type === 'job' ) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key'     => '_job_offer_types',
                'value'   => '"job"',
                'compare' => 'LIKE',
            ),
            array(
                'key'     => '_job_offer_types',
                'compare' => 'NOT EXISTS',
            ),
        );
    } elseif ( $offer_type === 'internship' ) {
        $args['meta_query'] = array(
            array(
                'key'     => '_job_offer_types',
                'value'   => '"internship"',
                'compare' => 'LIKE',
            ),
        );
    }

    // Apply search filter if query parameter exists
    if ( ! empty( $_GET['job_search'] ) ) {
        $args['s'] = sanitize_text_field( $_GET['job_search'] );
    }

    // Apply taxonomy filters if query parameters exist
    $tax_query = array();
    if ( ! empty( $_GET['iala_cat'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'job_category',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['iala_cat'] ),
        );
    }
    if ( ! empty( $_GET['iala_type'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'job_type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['iala_type'] ),
        );
    }
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query( $args );

    ob_start();
    ?>
    <div id="iala-jobs-board" class="iala-jobs-container">

        <!-- Category Title (Only when category/type/search is active) -->
        <?php 
        if ( ! empty( $_GET['iala_cat'] ) ) {
            $term = get_term_by( 'slug', sanitize_text_field( $_GET['iala_cat'] ), 'job_category' );
            if ( $term ) {
                echo '<h2 class="iala-jobs-filtered-title" style="margin: 0 0 25px 0; font-size: 1.8rem; color: #0f172a; font-weight: 700; font-family: inherit;">' . esc_html( $term->name ) . '</h2>';
            }
        } elseif ( ! empty( $_GET['iala_type'] ) ) {
            $term = get_term_by( 'slug', sanitize_text_field( $_GET['iala_type'] ), 'job_type' );
            if ( $term ) {
                echo '<h2 class="iala-jobs-filtered-title" style="margin: 0 0 25px 0; font-size: 1.8rem; color: #0f172a; font-weight: 700; font-family: inherit;">' . esc_html( $term->name ) . '</h2>';
            }
        } elseif ( ! empty( $_GET['job_search'] ) ) {
            echo '<h2 class="iala-jobs-filtered-title" style="margin: 0 0 25px 0; font-size: 1.8rem; color: #0f172a; font-weight: 700; font-family: inherit;">' . sprintf( __( 'Search Results for: "%s"', 'iala-jobs' ), esc_html( $_GET['job_search'] ) ) . '</h2>';
        }
        ?>


        <!-- Jobs Listing Grid -->
        <div id="iala-jobs-list" class="iala-jobs-list">
            <?php if ( $query->have_posts() ) : ?>
                <?php 
                global $post;
                $original_post = $post;
                while ( $query->have_posts() ) : $query->the_post(); 
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
                                <?php if ( ! empty( $job_cats ) && ! is_wp_error( $job_cats ) ) : ?>
                                    <div class="iala-job-card-categories" style="display: flex; gap: 5px; flex-wrap: wrap;">
                                        <?php foreach ( $job_cats as $cat ) : ?>
                                            <span class="iala-job-category-badge"><?php echo esc_html( $cat->name ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
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
                $total_pages = $query->max_num_pages;
                if ( $total_pages > 1 ) {
                    $current_page = max( 1, $paged );
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

                wp_reset_postdata(); 
                ?>
            <?php else : ?>
                <div class="iala-no-jobs">
                    <p><?php esc_html_e( 'No jobs match your search or filters.', 'iala-jobs' ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div id="iala-no-jobs-found" class="iala-no-jobs" style="display:none;">
            <p><?php esc_html_e( 'No jobs match your search or filters.', 'iala-jobs' ); ?></p>
        </div>


    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'iala_jobs', 'iala_jobs_shortcode' );

/**
 * 6. Custom Template Filter for single-job_listing.php
 */
function iala_jobs_single_template( $single_template ) {
    global $post;
    if ( isset($post->post_type) && $post->post_type === 'job_listing' ) {
        $details_design_type = get_option( 'iala_jobs_details_design_type', 'default' );
        $details_elementor_template = get_option( 'iala_jobs_details_elementor_template', 0 );

        if ( $details_design_type === 'elementor' && ! empty( $details_elementor_template ) ) {
            $file = IALA_JOBS_PATH . 'templates/single-job_listing-elementor.php';
        } else {
            $file = IALA_JOBS_PATH . 'templates/single-job_listing.php';
        }

        if ( file_exists( $file ) ) {
            return $file;
        }
    }
    return $single_template;
}
add_filter( 'single_template', 'iala_jobs_single_template' );

/**
 * 6b. Filter the_content for Elementor single job details page override
 */
function iala_jobs_single_content_override( $content ) {
    if ( is_singular( 'job_listing' ) && in_the_loop() && is_main_query() ) {
        $details_design_type = get_option( 'iala_jobs_details_design_type', 'default' );
        $details_elementor_template = get_option( 'iala_jobs_details_elementor_template', 0 );

        if ( $details_design_type === 'elementor' && ! empty( $details_elementor_template ) ) {
            return iala_jobs_render_elementor_template( $details_elementor_template );
        }
    }
    return $content;
}
add_filter( 'the_content', 'iala_jobs_single_content_override' );

/**
 * 6c. Custom Taxonomy Template Filter for job_category and job_type
 */
function iala_jobs_taxonomy_template( $template ) {
    if ( is_tax( array( 'job_category', 'job_type' ) ) ) {
        $file = IALA_JOBS_PATH . 'templates/taxonomy-job_category.php';
        if ( file_exists( $file ) ) {
            return $file;
        }
    }
    return $template;
}
add_filter( 'taxonomy_template', 'iala_jobs_taxonomy_template' );

/**
 * 6d. Custom Archive Template Filter for job_listing post-type archive
 */
function iala_jobs_archive_template_override( $archive_template ) {
    if ( is_post_type_archive( 'job_listing' ) ) {
        $board_design_type = get_option( 'iala_jobs_board_design_type', 'default' );
        $board_elementor_template = get_option( 'iala_jobs_board_elementor_template', 0 );

        if ( $board_design_type === 'elementor' && ! empty( $board_elementor_template ) ) {
            $file = IALA_JOBS_PATH . 'templates/archive-job_listing-elementor.php';
        } else {
            $file = IALA_JOBS_PATH . 'templates/archive-job_listing.php';
        }

        if ( file_exists( $file ) ) {
            return $file;
        }
    }
    return $archive_template;
}
add_filter( 'archive_template', 'iala_jobs_archive_template_override' );

/**
 * 6e. Automatically render Job Board on the selected board page
 */
/**
 * 6e. Automatically render Job Board on the selected board page / internships page
 */
function iala_jobs_auto_render_board_page( $content ) {
    static $rendering = false;
    if ( $rendering ) {
        return $content;
    }

    if ( is_admin() ) {
        return $content;
    }

    if ( class_exists( '\Elementor\Plugin' ) ) {
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::instance()->preview->is_preview_mode() || isset( $_GET['elementor-preview'] ) ) {
            return $content;
        }
    }

    $board_page_id = get_option( 'iala_jobs_board_page_id', 0 );
    $internships_page_id = get_option( 'iala_jobs_internships_page_id', 0 );

    // Jobs Board page context
    if ( ! empty( $board_page_id ) && is_page( $board_page_id ) && in_the_loop() && is_main_query() ) {
        $board_design_type = get_option( 'iala_jobs_board_design_type', 'default' );
        $board_elementor_template = get_option( 'iala_jobs_board_elementor_template', 0 );

        if ( $board_design_type === 'elementor' && ! empty( $board_elementor_template ) ) {
            $rendering = true;
            $output = iala_jobs_render_elementor_template( $board_elementor_template );
            $rendering = false;
            return $output;
        } else {
            $rendering = true;
            $output = do_shortcode( '[iala_jobs offer_type="job"]' );
            $rendering = false;
            return $output;
        }
    }

    // Internships Board page context
    if ( ! empty( $internships_page_id ) && is_page( $internships_page_id ) && in_the_loop() && is_main_query() ) {
        $internships_design_type = get_option( 'iala_jobs_internships_design_type', 'default' );
        $internships_elementor_template = get_option( 'iala_jobs_internships_elementor_template', 0 );

        if ( $internships_design_type === 'elementor' && ! empty( $internships_elementor_template ) ) {
            $rendering = true;
            $output = iala_jobs_render_elementor_template( $internships_elementor_template );
            $rendering = false;
            return $output;
        } else {
            $rendering = true;
            $output = do_shortcode( '[iala_jobs offer_type="internship"]' );
            $rendering = false;
            return $output;
        }
    }

    return $content;
}
add_filter( 'the_content', 'iala_jobs_auto_render_board_page' );

/**
 * 6f. Filter term links to redirect to the selected Jobs / Internships Board page with query parameters
 */
function iala_jobs_filter_term_links( $link, $term, $taxonomy ) {
    if ( $taxonomy === 'job_category' || $taxonomy === 'job_type' ) {
        $board_page_id = get_option( 'iala_jobs_board_page_id', 0 );
        $internships_page_id = get_option( 'iala_jobs_internships_page_id', 0 );

        $target_page_id = $board_page_id;
        if ( ! empty( $internships_page_id ) && is_page( $internships_page_id ) ) {
            $target_page_id = $internships_page_id;
        }

        if ( ! empty( $target_page_id ) ) {
            $target_page_url = get_permalink( $target_page_id );
            if ( $target_page_url ) {
                $param = ( $taxonomy === 'job_category' ) ? 'iala_cat' : 'iala_type';
                return add_query_arg( $param, $term->slug, $target_page_url );
            }
        }
    }
    return $link;
}
add_filter( 'term_link', 'iala_jobs_filter_term_links', 10, 3 );

/**
 * 7. Elementor helper function to render templates programmatically
 */
function iala_jobs_render_elementor_template( $template_id ) {
    if ( class_exists( '\Elementor\Plugin' ) ) {
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
    }
    return '<p>' . esc_html__( 'Elementor is not active or template not found.', 'iala-jobs' ) . '</p>';
}

/**
 * 8. Register Custom Shortcodes for use inside Elementor Templates
 */
function iala_jobs_register_elementor_shortcodes() {
    add_shortcode( 'iala_job_title', 'iala_jobs_sc_title' );
    add_shortcode( 'iala_job_company', 'iala_jobs_sc_company' );
    add_shortcode( 'iala_job_company_website', 'iala_jobs_sc_company_website' );
    add_shortcode( 'iala_job_location', 'iala_jobs_sc_location' );
    add_shortcode( 'iala_job_salary', 'iala_jobs_sc_salary' );
    add_shortcode( 'iala_job_apply_link', 'iala_jobs_sc_apply_link' );
    add_shortcode( 'iala_job_logo', 'iala_jobs_sc_logo' );
    add_shortcode( 'iala_job_category', 'iala_jobs_sc_category' );
    add_shortcode( 'iala_job_type', 'iala_jobs_sc_type' );
    add_shortcode( 'iala_job_date', 'iala_jobs_sc_date' );
    add_shortcode( 'iala_job_author', 'iala_jobs_sc_author' );
    add_shortcode( 'iala_job_header_block', 'iala_jobs_sc_header_block' );
}
add_action( 'init', 'iala_jobs_register_elementor_shortcodes' );

function iala_jobs_sc_title() {
    return get_the_title();
}
function iala_jobs_sc_company() {
    return esc_html( get_post_meta( get_the_ID(), '_job_company', true ) );
}
function iala_jobs_sc_company_website() {
    return esc_url( get_post_meta( get_the_ID(), '_job_company_website', true ) );
}
function iala_jobs_sc_location() {
    return esc_html( get_post_meta( get_the_ID(), '_job_location', true ) );
}
function iala_jobs_sc_salary() {
    return esc_html( get_post_meta( get_the_ID(), '_job_salary', true ) );
}
function iala_jobs_sc_apply_link() {
    return esc_url( get_post_meta( get_the_ID(), '_job_apply_link', true ) );
}
function iala_jobs_sc_logo() {
    $logo = get_the_post_thumbnail_url( get_the_ID(), 'iala-job-thumb' );
    if ( $logo ) {
        return '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( get_post_meta( get_the_ID(), '_job_company', true ) ) . '" class="iala-job-card-logo" style="width:600px; height:400px; max-width:100%; object-fit:cover; border-radius:12px;" />';
    } else {
        $company = get_post_meta( get_the_ID(), '_job_company', true );
        $letter = ! empty( $company ) ? strtoupper( substr( $company, 0, 1 ) ) : 'J';
        $bg_colors = array( '#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#3b82f6', '#8b5cf6' );
        $char_code = ord($letter);
        $color = $bg_colors[$char_code % count($bg_colors)];
        return '<div class="iala-job-card-logo-placeholder-sc" style="background-color: ' . esc_attr($color) . '; width:600px; height:400px; max-width:100%; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:6rem; font-weight:bold;">' . esc_html( $letter ) . '</div>';
    }
}
function iala_jobs_sc_category() {
    $cats = wp_get_post_terms( get_the_ID(), 'job_category' );
    if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
        return esc_html( $cats[0]->name );
    }
    return '';
}
function iala_jobs_sc_type() {
    $types = wp_get_post_terms( get_the_ID(), 'job_type' );
    if ( ! empty( $types ) && ! is_wp_error( $types ) ) {
        return esc_html( $types[0]->name );
    }
    return '';
}
function iala_jobs_sc_date() {
    return get_the_date( 'F j, Y' );
}
function iala_jobs_sc_author() {
    return get_the_author();
}
function iala_jobs_sc_header_block() {
    $post_id = get_the_ID();
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

    $current_url = esc_url( get_permalink() );
    $encoded_title = urlencode( get_the_title() );
    $encoded_url = urlencode( $current_url );

    ob_start();
    ?>
    <div class="iala-single-job-container-new" style="box-shadow: none; border: none; padding: 0; max-width: 100%;">
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
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 9. Admin Settings Page Setup

 */
function iala_jobs_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=job_listing',
        __( 'Settings', 'iala-jobs' ),
        __( 'Settings', 'iala-jobs' ),
        'manage_options',
        'iala-jobs-settings',
        'iala_jobs_settings_page_callback'
    );
}
add_action( 'admin_menu', 'iala_jobs_admin_menu' );

function iala_jobs_settings_page_callback() {
    if ( isset( $_POST['iala_jobs_save_settings'] ) && check_admin_referer( 'iala_jobs_settings_nonce_action', 'iala_jobs_settings_nonce' ) ) {
        update_option( 'iala_jobs_card_design_type', sanitize_text_field( $_POST['iala_jobs_card_design_type'] ) );
        update_option( 'iala_jobs_card_elementor_template', intval( $_POST['iala_jobs_card_elementor_template'] ) );
        update_option( 'iala_jobs_details_design_type', sanitize_text_field( $_POST['iala_jobs_details_design_type'] ) );
        update_option( 'iala_jobs_details_elementor_template', intval( $_POST['iala_jobs_details_elementor_template'] ) );
        update_option( 'iala_jobs_posts_per_page', intval( $_POST['iala_jobs_posts_per_page'] ) );
        update_option( 'iala_jobs_board_page_id', intval( $_POST['iala_jobs_board_page_id'] ) );
        update_option( 'iala_jobs_board_design_type', sanitize_text_field( $_POST['iala_jobs_board_design_type'] ) );
        update_option( 'iala_jobs_board_elementor_template', intval( $_POST['iala_jobs_board_elementor_template'] ) );
        update_option( 'iala_jobs_internships_page_id', intval( $_POST['iala_jobs_internships_page_id'] ) );
        update_option( 'iala_jobs_internships_design_type', sanitize_text_field( $_POST['iala_jobs_internships_design_type'] ) );
        update_option( 'iala_jobs_internships_elementor_template', intval( $_POST['iala_jobs_internships_elementor_template'] ) );
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved successfully.', 'iala-jobs' ) . '</p></div>';
    }

    $card_design_type = get_option( 'iala_jobs_card_design_type', 'default' );
    $card_elementor_template = get_option( 'iala_jobs_card_elementor_template', 0 );
    $details_design_type = get_option( 'iala_jobs_details_design_type', 'default' );
    $details_elementor_template = get_option( 'iala_jobs_details_elementor_template', 0 );
    $posts_per_page = get_option( 'iala_jobs_posts_per_page', 15 );
    $board_page_id = get_option( 'iala_jobs_board_page_id', 0 );
    $board_design_type = get_option( 'iala_jobs_board_design_type', 'default' );
    $board_elementor_template = get_option( 'iala_jobs_board_elementor_template', 0 );
    $internships_page_id = get_option( 'iala_jobs_internships_page_id', 0 );
    $internships_design_type = get_option( 'iala_jobs_internships_design_type', 'default' );
    $internships_elementor_template = get_option( 'iala_jobs_internships_elementor_template', 0 );
    $wp_pages = get_pages();

    $elementor_templates = array();
    if ( post_type_exists( 'elementor_library' ) ) {
        $elementor_templates = get_posts( array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ) );
    }
    ?>
    <div class="wrap iala-jobs-admin-settings">
        <h1 style="margin-bottom: 20px; font-weight: 700; color: #1e293b;"><?php esc_html_e( 'IALA Simple Jobs Post Settings', 'iala-jobs' ); ?></h1>
        <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 30px;">
            Configure whether you want to use the premium built-in layouts or design your own cards and details pages using <strong>Elementor</strong>.
        </p>

        <form method="post" action="">
            <?php wp_nonce_field( 'iala_jobs_settings_nonce_action', 'iala_jobs_settings_nonce' ); ?>
            
            <div class="iala-settings-section" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; max-width: 800px; border: 1px solid #e2e8f0;">
                <h2 style="margin-top: 0; font-size: 1.4rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; color: #0f172a;"><?php esc_html_e( 'Job Card Layout Settings', 'iala-jobs' ); ?></h2>
                
                <table class="form-table" role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_card_design_type"><?php esc_html_e( 'Card Design Option', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <select id="iala_jobs_card_design_type" name="iala_jobs_card_design_type" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;" onchange="toggleCardTemplateSelect(this.value)">
                                <option value="default" <?php selected( $card_design_type, 'default' ); ?>><?php esc_html_e( 'Built-in Premium Card Design (Screenshot style)', 'iala-jobs' ); ?></option>
                                <option value="elementor" <?php selected( $card_design_type, 'elementor' ); ?>><?php esc_html_e( 'Custom Elementor Template', 'iala-jobs' ); ?></option>
                            </select>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select if you want to use the default layout or layout designed in Elementor.
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="card-template-row" style="<?php echo $card_design_type === 'elementor' ? '' : 'display: none;'; ?>">
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_card_elementor_template"><?php esc_html_e( 'Select Elementor Template', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $elementor_templates ) ) : ?>
                                <select id="iala_jobs_card_elementor_template" name="iala_jobs_card_elementor_template" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Template —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $elementor_templates as $tmpl ) : ?>
                                        <option value="<?php echo esc_attr( $tmpl->ID ); ?>" <?php selected( $card_elementor_template, $tmpl->ID ); ?>><?php echo esc_html( $tmpl->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No Elementor templates found. Please create one under Templates -> Saved Templates first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="iala-settings-section" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; max-width: 800px; border: 1px solid #e2e8f0;">
                <h2 style="margin-top: 0; font-size: 1.4rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; color: #0f172a;"><?php esc_html_e( 'Single Job Details Page Settings', 'iala-jobs' ); ?></h2>
                
                <table class="form-table" role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_details_design_type"><?php esc_html_e( 'Details Page Option', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <select id="iala_jobs_details_design_type" name="iala_jobs_details_design_type" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;" onchange="toggleDetailsTemplateSelect(this.value)">
                                <option value="default" <?php selected( $details_design_type, 'default' ); ?>><?php esc_html_e( 'Built-in Premium Two-Column Design', 'iala-jobs' ); ?></option>
                                <option value="elementor" <?php selected( $details_design_type, 'elementor' ); ?>><?php esc_html_e( 'Custom Elementor Template', 'iala-jobs' ); ?></option>
                            </select>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select if you want to use the default layout or layout designed in Elementor for details page.
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="details-template-row" style="<?php echo $details_design_type === 'elementor' ? '' : 'display: none;'; ?>">
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_details_elementor_template"><?php esc_html_e( 'Select Elementor Template', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $elementor_templates ) ) : ?>
                                <select id="iala_jobs_details_elementor_template" name="iala_jobs_details_elementor_template" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Template —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $elementor_templates as $tmpl ) : ?>
                                        <option value="<?php echo esc_attr( $tmpl->ID ); ?>" <?php selected( $details_elementor_template, $tmpl->ID ); ?>><?php echo esc_html( $tmpl->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No Elementor templates found. Please create one under Templates -> Saved Templates first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Jobs Board Page Settings Section -->
            <div class="iala-settings-section" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; max-width: 800px; border: 1px solid #e2e8f0;">
                <h2 style="margin-top: 0; font-size: 1.4rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; color: #0f172a;"><?php esc_html_e( 'Jobs Board Page Settings', 'iala-jobs' ); ?></h2>
                
                <table class="form-table" role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_board_page_id"><?php esc_html_e( 'Select Jobs Board Page', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $wp_pages ) ) : ?>
                                <select id="iala_jobs_board_page_id" name="iala_jobs_board_page_id" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Page —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $wp_pages as $page ) : ?>
                                        <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $board_page_id, $page->ID ); ?>><?php echo esc_html( $page->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No WordPress pages found. Please create one under Pages -> Add New first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select the page where the Job Board should be automatically displayed (similar to the WooCommerce Shop page).
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_board_design_type"><?php esc_html_e( 'Jobs Board Design Option', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <select id="iala_jobs_board_design_type" name="iala_jobs_board_design_type" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;" onchange="toggleBoardTemplateSelect(this.value)">
                                <option value="default" <?php selected( $board_design_type, 'default' ); ?>><?php esc_html_e( 'Built-in Premium Jobs Board', 'iala-jobs' ); ?></option>
                                <option value="elementor" <?php selected( $board_design_type, 'elementor' ); ?>><?php esc_html_e( 'Custom Elementor Template', 'iala-jobs' ); ?></option>
                            </select>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select if you want to use the default jobs list layout or a custom layout designed in Elementor.
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="board-template-row" style="<?php echo $board_design_type === 'elementor' ? '' : 'display: none;'; ?>">
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_board_elementor_template"><?php esc_html_e( 'Select Elementor Template', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $elementor_templates ) ) : ?>
                                <select id="iala_jobs_board_elementor_template" name="iala_jobs_board_elementor_template" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Template —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $elementor_templates as $tmpl ) : ?>
                                        <option value="<?php echo esc_attr( $tmpl->ID ); ?>" <?php selected( $board_elementor_template, $tmpl->ID ); ?>><?php echo esc_html( $tmpl->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No Elementor templates found. Please create one under Templates -> Saved Templates first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Internships Board Page Settings Section -->
            <div class="iala-settings-section" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; max-width: 800px; border: 1px solid #e2e8f0;">
                <h2 style="margin-top: 0; font-size: 1.4rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; color: #0f172a;"><?php esc_html_e( 'Internships Board Page Settings', 'iala-jobs' ); ?></h2>
                
                <table class="form-table" role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_internships_page_id"><?php esc_html_e( 'Select Internships Board Page', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $wp_pages ) ) : ?>
                                <select id="iala_jobs_internships_page_id" name="iala_jobs_internships_page_id" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Page —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $wp_pages as $page ) : ?>
                                        <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $internships_page_id, $page->ID ); ?>><?php echo esc_html( $page->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No WordPress pages found. Please create one under Pages -> Add New first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select the page where the Internships Board should be automatically displayed.
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_internships_design_type"><?php esc_html_e( 'Internships Board Design Option', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <select id="iala_jobs_internships_design_type" name="iala_jobs_internships_design_type" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;" onchange="toggleInternshipsTemplateSelect(this.value)">
                                <option value="default" <?php selected( $internships_design_type, 'default' ); ?>><?php esc_html_e( 'Built-in Premium Internships Board', 'iala-jobs' ); ?></option>
                                <option value="elementor" <?php selected( $internships_design_type, 'elementor' ); ?>><?php esc_html_e( 'Custom Elementor Template', 'iala-jobs' ); ?></option>
                            </select>
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Select if you want to use the default layout or a custom layout designed in Elementor for Internships.
                            </p>
                        </td>
                    </tr>
                    
                    <tr id="internships-template-row" style="<?php echo $internships_design_type === 'elementor' ? '' : 'display: none;'; ?>">
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_internships_elementor_template"><?php esc_html_e( 'Select Elementor Template', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <?php if ( ! empty( $elementor_templates ) ) : ?>
                                <select id="iala_jobs_internships_elementor_template" name="iala_jobs_internships_elementor_template" style="width: 100%; max-width: 400px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="0"><?php esc_html_e( '— Select a Template —', 'iala-jobs' ); ?></option>
                                    <?php foreach ( $elementor_templates as $tmpl ) : ?>
                                        <option value="<?php echo esc_attr( $tmpl->ID ); ?>" <?php selected( $internships_elementor_template, $tmpl->ID ); ?>><?php echo esc_html( $tmpl->post_title ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <p style="color: #ef4444; font-weight: 500;">
                                    <?php esc_html_e( 'No Elementor templates found. Please create one under Templates -> Saved Templates first.', 'iala-jobs' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- New Pagination Settings Section -->
            <div class="iala-settings-section" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; max-width: 800px; border: 1px solid #e2e8f0;">
                <h2 style="margin-top: 0; font-size: 1.4rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; color: #0f172a;"><?php esc_html_e( 'Jobs Board Pagination Settings', 'iala-jobs' ); ?></h2>
                
                <table class="form-table" role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <th scope="row" style="width: 30%; font-weight: 600; padding: 15px 10px 15px 0; vertical-align: top; text-align: left;">
                            <label for="iala_jobs_posts_per_page"><?php esc_html_e( 'Default Jobs Per Page', 'iala-jobs' ); ?></label>
                        </th>
                        <td style="padding: 15px 10px;">
                            <input type="number" id="iala_jobs_posts_per_page" name="iala_jobs_posts_per_page" value="<?php echo esc_attr( $posts_per_page ); ?>" min="1" max="100" style="width: 100%; max-width: 100px; height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; padding: 0 10px;" />
                            <p class="description" style="color: #64748b; margin-top: 8px; font-size: 0.9rem;">
                                Define how many job listing cards show on a single page of the jobs board. You can also override this on specific pages by using the shortcode attribute like <code>[iala_jobs posts_per_page="15"]</code>.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Shortcode Reference Box -->
            <div class="iala-settings-section" style="background: #f8fafc; padding: 25px; border-radius: 12px; max-width: 800px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <h3 style="margin-top:0; font-size: 1.1rem; color: #0f172a;"><?php esc_html_e( 'Shortcode for Custom Elementor Templates', 'iala-jobs' ); ?></h3>
                <p style="font-size:0.92rem; color: #64748b;">
                    Use the following shortcode inside your custom Elementor templates (using the Shortcode widget or text editor) to display the dynamic job header:
                </p>
                <div style="font-family: monospace; font-size: 0.88rem; background: #ffffff; padding: 15px; border-radius: 6px; border: 1px solid #cbd5e1; color: #FF3301; font-weight: 600;">
                    [iala_job_header_block]
                </div>
            </div>

            <p class="submit">
                <input type="submit" name="iala_jobs_save_settings" id="submit" class="button button-primary" style="height: 44px; padding: 0 30px; font-size: 1rem; border-radius: 6px; font-weight: 600; background: #4f46e5; border-color: #4f46e5;" value="<?php esc_attr_e( 'Save All Settings', 'iala-jobs' ); ?>">
            </p>
        </form>
    </div>

    <script type="text/javascript">
        function toggleCardTemplateSelect(val) {
            var row = document.getElementById('card-template-row');
            if (val === 'elementor') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
        function toggleDetailsTemplateSelect(val) {
            var row = document.getElementById('details-template-row');
            if (val === 'elementor') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
        function toggleBoardTemplateSelect(val) {
            var row = document.getElementById('board-template-row');
            if (val === 'elementor') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
        function toggleInternshipsTemplateSelect(val) {
            var row = document.getElementById('internships-template-row');
            if (val === 'elementor') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    </script>
    <?php
}

/**
 * 10. Plugin Activation: Setup Sample Categories, Types and Sample Jobs
 */
function iala_jobs_activate() {
    iala_jobs_register_post_type();
    iala_jobs_register_taxonomies();
    flush_rewrite_rules();

    // Check if we already inserted sample data to avoid duplicates
    if ( get_option( 'iala_jobs_sample_data_imported' ) ) {
        return;
    }

    // Insert Taxonomies
    $categories = array( 'Technology', 'Design', 'Marketing', 'Customer Support' );
    $cat_ids = array();
    foreach ( $categories as $cat ) {
        $term = wp_insert_term( $cat, 'job_category' );
        if ( ! is_wp_error( $term ) ) {
            $cat_ids[$cat] = $term['term_id'];
        } else if ( isset( $term->error_data['term_exists'] ) ) {
            $cat_ids[$cat] = $term->error_data['term_exists'];
        }
    }

    $types = array( 'Full Time', 'Part Time', 'Remote', 'Contract' );
    $type_ids = array();
    foreach ( $types as $type ) {
        $term = wp_insert_term( $type, 'job_type' );
        if ( ! is_wp_error( $term ) ) {
            $type_ids[$type] = $term['term_id'];
        } else if ( isset( $term->error_data['term_exists'] ) ) {
            $type_ids[$type] = $term->error_data['term_exists'];
        }
    }

    // Insert Sample Jobs
    $sample_jobs = array(
        array(
            'title'       => 'Senior React & Node Developer',
            'company'     => 'PnsCode',
            'website'     => 'https://pnscode.com',
            'location'    => 'Remote (USA / Europe)',
            'salary'      => '$90,000 - $120,000 / year',
            'apply'       => 'careers@pnscode.com',
            'category'    => 'Technology',
            'type'        => 'Remote',
            'content'     => '<h3>About the Role</h3><p>We are looking for a Senior Full-Stack React & Node Developer to join our growing engineering team. You will be responsible for architecture, developing high-performing frontend components, and building scaleable APIs.</p><h3>Requirements</h3><ul><li>4+ years of professional React experience</li><li>Strong Node.js, Express, and Database knowledge</li><li>Familiarity with modern deployment solutions (AWS, Vercel)</li><li>Excellent communication and team skills</li></ul>'
        ),
        array(
            'title'       => 'Lead UI/UX Designer',
            'company'     => 'DesignCraft Studio',
            'website'     => 'https://pnscode.com',
            'location'    => 'New York, NY (Hybrid)',
            'salary'      => '$85,000 - $105,000 / year',
            'apply'       => 'https://pnscode.com/apply',
            'category'    => 'Design',
            'type'        => 'Full Time',
            'content'     => '<h3>About the Role</h3><p>DesignCraft is searching for an inspiring Lead UI/UX Designer to orchestrate our creative visuals and define product UX flows. You will work side-by-side with product owners and engineers to ship delightful user journeys.</p><h3>Requirements</h3><ul><li>Proven portfolio showcasing web & mobile product designs</li><li>Proficiency in Figma, Adobe Creative Suite, and prototyping tools</li><li>Experience developing dynamic design systems</li></ul>'
        ),
        array(
            'title'       => 'Digital Marketing specialist',
            'company'     => 'GrowUp Media',
            'website'     => 'https://pnscode.com',
            'location'    => 'Remote (Worldwide)',
            'salary'      => '$45 - $60 / hour',
            'apply'       => 'jobs@pnscode.com',
            'category'    => 'Marketing',
            'type'        => 'Contract',
            'content'     => '<h3>About the Role</h3><p>GrowUp Media is looking for a creative, data-driven Digital Marketing specialist to construct, test, and optimize advertising campaigns across meta platforms and Google Ads.</p><h3>Requirements</h3><ul><li>2+ years of PPC and social ads management</li><li>Strong analytic skillsets with Google Analytics and Tag Manager</li><li>A dynamic approach to content creation and growth experiments</li></ul>'
        ),
    );

    foreach ( $sample_jobs as $job ) {
        $post_id = wp_insert_post( array(
            'post_title'   => $job['title'],
            'post_content' => $job['content'],
            'post_status'  => 'publish',
            'post_type'    => 'job_listing',
        ) );

        if ( ! is_wp_error( $post_id ) && $post_id > 0 ) {
            update_post_meta( $post_id, '_job_company', $job['company'] );
            update_post_meta( $post_id, '_job_company_website', $job['website'] );
            update_post_meta( $post_id, '_job_location', $job['location'] );
            update_post_meta( $post_id, '_job_salary', $job['salary'] );
            update_post_meta( $post_id, '_job_apply_link', $job['apply'] );

            // Associate Taxonomies
            if ( isset( $cat_ids[$job['category']] ) ) {
                wp_set_post_terms( $post_id, array( $cat_ids[$job['category']] ), 'job_category' );
            }
            if ( isset( $type_ids[$job['type']] ) ) {
                wp_set_post_terms( $post_id, array( $type_ids[$job['type']] ), 'job_type' );
            }
        }
    }

    update_option( 'iala_jobs_sample_data_imported', true );
}
register_activation_hook( __FILE__, 'iala_jobs_activate' );

/**
 * 11. Deactivation Hook: Flush Rewrite Rules
 */
function iala_jobs_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'iala_jobs_deactivate' );

/**
 * 12. Register Elementor Widget
 */
add_action( 'elementor/widgets/register', 'iala_jobs_register_elementor_widgets' );
function iala_jobs_register_elementor_widgets( $widgets_manager ) {
    if ( class_exists( '\\Elementor\\Widget_Base' ) ) {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-iala-job-categories-widget.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-iala-job-search-widget.php';
        $widgets_manager->register( new \IALA_Job_Categories_Widget() );
        $widgets_manager->register( new \IALA_Job_Search_Widget() );
    }
}
