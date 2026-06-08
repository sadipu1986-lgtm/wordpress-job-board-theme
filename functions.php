<?php
/**
 * Theme Functions
 * 
 * @package Job_Board_Pro
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme Version
define( 'JOB_BOARD_THEME_VERSION', '1.0.0' );
define( 'JOB_BOARD_THEME_DIR', get_template_directory() );
define( 'JOB_BOARD_THEME_URI', get_template_directory_uri() );

/**
 * Setup Theme
 */
function job_board_setup() {
    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
    
    // Add image sizes
    add_image_size( 'job-logo', 100, 100, true );
    add_image_size( 'job-thumbnail', 300, 200, true );
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'job-board-pro' ),
        'footer' => __( 'Footer Menu', 'job-board-pro' ),
    ) );
}
add_action( 'after_setup_theme', 'job_board_setup' );

/**
 * Enqueue Scripts and Styles
 */
function job_board_enqueue_scripts() {
    // Main stylesheet
    wp_enqueue_style( 'job-board-style', JOB_BOARD_THEME_URI . '/style.css', array(), JOB_BOARD_THEME_VERSION );
    
    // Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' );
    
    // Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' );
    
    // Main JavaScript
    wp_enqueue_script( 'job-board-main', JOB_BOARD_THEME_URI . '/assets/js/main.js', array(), JOB_BOARD_THEME_VERSION, true );
    
    // Localize script
    wp_localize_script( 'job-board-main', 'jobBoardData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'job_board_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'job_board_enqueue_scripts' );

/**
 * Register Sidebar
 */
function job_board_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Primary Sidebar', 'job-board-pro' ),
        'id' => 'primary-sidebar',
        'description' => __( 'Main sidebar', 'job-board-pro' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'job_board_widgets_init' );

/**
 * Custom Post Type - Jobs
 */
function job_board_register_post_types() {
    register_post_type( 'job', array(
        'label' => __( 'Jobs', 'job-board-pro' ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_icon' => 'dashicons-briefcase',
        'rewrite' => array( 'slug' => 'jobs' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'job_board_register_post_types' );

/**
 * Register Custom Taxonomies
 */
function job_board_register_taxonomies() {
    // Job Category
    register_taxonomy( 'job_category', 'job', array(
        'label' => __( 'Job Categories', 'job-board-pro' ),
        'public' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'job-category' ),
        'show_in_rest' => true,
    ) );
    
    // Job Type
    register_taxonomy( 'job_type', 'job', array(
        'label' => __( 'Job Types', 'job-board-pro' ),
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'job-type' ),
        'show_in_rest' => true,
    ) );
    
    // Job Level
    register_taxonomy( 'job_level', 'job', array(
        'label' => __( 'Experience Level', 'job-board-pro' ),
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'job-level' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'job_board_register_taxonomies' );

/**
 * Add Meta Fields for Jobs
 */
function job_board_add_meta_fields() {
    register_meta( 'post', 'job_salary_min', array(
        'object_subtype' => 'job',
        'type' => 'number',
        'single' => true,
        'show_in_rest' => true,
    ) );
    
    register_meta( 'post', 'job_salary_max', array(
        'object_subtype' => 'job',
        'type' => 'number',
        'single' => true,
        'show_in_rest' => true,
    ) );
    
    register_meta( 'post', 'job_location', array(
        'object_subtype' => 'job',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ) );
    
    register_meta( 'post', 'job_company', array(
        'object_subtype' => 'job',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ) );
    
    register_meta( 'post', 'job_deadline', array(
        'object_subtype' => 'job',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'job_board_add_meta_fields' );

/**
 * AJAX Handler for Job Search
 */
function job_board_search_jobs() {
    check_ajax_referer( 'job_board_nonce', 'nonce' );
    
    $search = sanitize_text_field( $_POST['search'] ?? '' );
    $category = sanitize_text_field( $_POST['category'] ?? '' );
    $location = sanitize_text_field( $_POST['location'] ?? '' );
    $paged = intval( $_POST['paged'] ?? 1 );
    
    $args = array(
        'post_type' => 'job',
        'posts_per_page' => 12,
        'paged' => $paged,
        's' => $search,
    );
    
    if ( ! empty( $category ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'job_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }
    
    if ( ! empty( $location ) ) {
        $args['meta_query'] = array(
            array(
                'key' => 'job_location',
                'value' => $location,
                'compare' => 'LIKE',
            ),
        );
    }
    
    $query = new WP_Query( $args );
    
    ob_start();
    if ( $query->have_posts() ) {
        echo '<div class="job-grid">';
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/job-card' );
        }
        echo '</div>';
    } else {
        echo '<p class="text-center">' . __( 'No jobs found.', 'job-board-pro' ) . '</p>';
    }
    
    $output = ob_get_clean();
    wp_send_json_success( array(
        'html' => $output,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages,
    ) );
}
add_action( 'wp_ajax_job_board_search_jobs', 'job_board_search_jobs' );
add_action( 'wp_ajax_nopriv_job_board_search_jobs', 'job_board_search_jobs' );

/**
 * Get Job Salary Display
 */
function job_board_get_salary( $job_id ) {
    $salary_min = get_post_meta( $job_id, 'job_salary_min', true );
    $salary_max = get_post_meta( $job_id, 'job_salary_max', true );
    
    if ( $salary_min && $salary_max ) {
        return '$' . number_format( $salary_min ) . ' - $' . number_format( $salary_max );
    } elseif ( $salary_min ) {
        return '$' . number_format( $salary_min );
    }
    
    return __( 'Not specified', 'job-board-pro' );
}

/**
 * Get Job Duration Text
 */
function job_board_get_duration( $job_id ) {
    $post = get_post( $job_id );
    $date = strtotime( $post->post_date );
    $now = current_time( 'timestamp' );
    $diff = $now - $date;
    
    if ( $diff < HOUR_IN_SECONDS ) {
        return __( 'Just now', 'job-board-pro' );
    } elseif ( $diff < DAY_IN_SECONDS ) {
        $hours = intval( $diff / HOUR_IN_SECONDS );
        return sprintf( _n( '%d hour ago', '%d hours ago', $hours, 'job-board-pro' ), $hours );
    } elseif ( $diff < WEEK_IN_SECONDS ) {
        $days = intval( $diff / DAY_IN_SECONDS );
        return sprintf( _n( '%d day ago', '%d days ago', $days, 'job-board-pro' ), $days );
    } elseif ( $diff < MONTH_IN_SECONDS ) {
        $weeks = intval( $diff / WEEK_IN_SECONDS );
        return sprintf( _n( '%d week ago', '%d weeks ago', $weeks, 'job-board-pro' ), $weeks );
    } else {
        return date_i18n( get_option( 'date_format' ), $date );
    }
}

/**
 * Custom Excerpt Length
 */
function job_board_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'job_board_excerpt_length', 999 );

/**
 * Custom Excerpt More
 */
function job_board_excerpt_more( $more ) {
    return ' ...';
}
add_filter( 'excerpt_more', 'job_board_excerpt_more' );
