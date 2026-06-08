<?php
/**
 * Archive Jobs Template
 * 
 * @package Job_Board_Pro
 */

get_header(); ?>

<div class="hero">
    <div class="container">
        <h1><?php _e( 'Browse Jobs', 'job-board-pro' ); ?></h1>
        <p><?php echo get_the_archive_title(); ?></p>
    </div>
</div>

<div class="container">
    <div class="search-form-wrapper">
        <form class="search-form" id="job-search-form">
            <div class="form-group">
                <label for="search-keyword"><?php _e( 'Job Title', 'job-board-pro' ); ?></label>
                <input type="text" id="search-keyword" name="search" placeholder="<?php _e( 'e.g. Developer, Designer', 'job-board-pro' ); ?>">
            </div>
            
            <div class="form-group">
                <label for="search-category"><?php _e( 'Category', 'job-board-pro' ); ?></label>
                <select id="search-category" name="category">
                    <option value=""><?php _e( 'All Categories', 'job-board-pro' ); ?></option>
                    <?php
                    $categories = get_terms( array(
                        'taxonomy' => 'job_category',
                        'hide_empty' => false,
                    ) );
                    
                    foreach ( $categories as $category ) {
                        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="search-location"><?php _e( 'Location', 'job-board-pro' ); ?></label>
                <input type="text" id="search-location" name="location" placeholder="<?php _e( 'e.g. New York', 'job-board-pro' ); ?>">
            </div>
            
            <button type="submit"><?php _e( 'Search', 'job-board-pro' ); ?></button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="container">
        <div class="job-grid" id="job-results">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/job-card' );
                }
            } else {
                echo '<p>' . __( 'No jobs found in this category.', 'job-board-pro' ) . '</p>';
            }
            ?>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <?php
            echo paginate_links( array(
                'prev_text' => __( '&laquo; Previous', 'job-board-pro' ),
                'next_text' => __( 'Next &raquo;', 'job-board-pro' ),
            ) );
            ?>
        </div>
    </div>
</div>

<?php get_footer();
