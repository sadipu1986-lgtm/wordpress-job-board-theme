<?php
/**
 * Single Job Template
 * 
 * @package Job_Board_Pro
 */

get_header(); ?>

<?php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        ?>
        
        <div class="main-content">
            <div class="container">
                <div class="job-detail">
                    <div class="job-detail-content">
                        <div class="job-detail-header">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <img src="<?php echo get_the_post_thumbnail_url( null, 'job-thumbnail' ); ?>" alt="<?php the_title(); ?>" class="job-detail-logo">
                            <?php } else { ?>
                                <div class="job-detail-logo" style="background: linear-gradient(135deg, #0066cc, #0052a3); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem;">
                                    <?php echo strtoupper( substr( get_post_meta( get_the_ID(), 'job_company', true ) ?: 'JB', 0, 2 ) ); ?>
                                </div>
                            <?php } ?>
                            
                            <div class="job-detail-info">
                                <div class="job-detail-company">
                                    <?php echo get_post_meta( get_the_ID(), 'job_company', true ) ?: __( 'Company', 'job-board-pro' ); ?>
                                </div>
                                <h1><?php the_title(); ?></h1>
                                
                                <ul class="job-detail-meta-list">
                                    <li>
                                        <strong><?php _e( 'Location:', 'job-board-pro' ); ?></strong>
                                        <span><?php echo get_post_meta( get_the_ID(), 'job_location', true ) ?: __( 'Not specified', 'job-board-pro' ); ?></span>
                                    </li>
                                    <li>
                                        <strong><?php _e( 'Job Type:', 'job-board-pro' ); ?></strong>
                                        <span>
                                            <?php
                                            $job_type = wp_get_post_terms( get_the_ID(), 'job_type' );
                                            echo ! empty( $job_type ) ? $job_type[0]->name : __( 'Not specified', 'job-board-pro' );
                                            ?>
                                        </span>
                                    </li>
                                    <li>
                                        <strong><?php _e( 'Experience Level:', 'job-board-pro' ); ?></strong>
                                        <span>
                                            <?php
                                            $job_level = wp_get_post_terms( get_the_ID(), 'job_level' );
                                            echo ! empty( $job_level ) ? $job_level[0]->name : __( 'Not specified', 'job-board-pro' );
                                            ?>
                                        </span>
                                    </li>
                                    <li>
                                        <strong><?php _e( 'Salary:', 'job-board-pro' ); ?></strong>
                                        <span><?php echo job_board_get_salary( get_the_ID() ); ?></span>
                                    </li>
                                    <li>
                                        <strong><?php _e( 'Posted:', 'job-board-pro' ); ?></strong>
                                        <span><?php echo job_board_get_duration( get_the_ID() ); ?></span>
                                    </li>
                                    <li>
                                        <strong><?php _e( 'Deadline:', 'job-board-pro' ); ?></strong>
                                        <span>
                                            <?php
                                            $deadline = get_post_meta( get_the_ID(), 'job_deadline', true );
                                            echo $deadline ? date_i18n( get_option( 'date_format' ), strtotime( $deadline ) ) : __( 'Not specified', 'job-board-pro' );
                                            ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="job-detail-section">
                            <h2><?php _e( 'Job Description', 'job-board-pro' ); ?></h2>
                            <div class="job-detail-description">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <div class="job-detail-section">
                            <h2><?php _e( 'Categories', 'job-board-pro' ); ?></h2>
                            <div>
                                <?php
                                $categories = wp_get_post_terms( get_the_ID(), 'job_category' );
                                if ( ! empty( $categories ) ) {
                                    foreach ( $categories as $category ) {
                                        echo '<a href="' . get_term_link( $category ) . '" class="button">' . $category->name . '</a> ';
                                    }
                                } else {
                                    echo __( 'No categories assigned', 'job-board-pro' );
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="job-detail-sidebar">
                        <a href="<?php the_permalink(); ?>#apply" class="sidebar-apply-btn">
                            <i class="fas fa-paper-plane"></i> <?php _e( 'Apply Now', 'job-board-pro' ); ?>
                        </a>
                        
                        <div class="sidebar-widget">
                            <h3><?php _e( 'Share This Job', 'job-board-pro' ); ?></h3>
                            <div class="sidebar-widget-content">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="button" style="width: 100%; text-align: center;">
                                    <i class="fab fa-facebook"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="button button-secondary" style="width: 100%; text-align: center;">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>" target="_blank" class="button button-secondary" style="width: 100%; text-align: center;">
                                    <i class="fab fa-linkedin"></i> LinkedIn
                                </a>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3><?php _e( 'Job Information', 'job-board-pro' ); ?></h3>
                            <div class="sidebar-info">
                                <p>
                                    <strong><?php _e( 'Salary Range:', 'job-board-pro' ); ?></strong><br>
                                    <?php echo job_board_get_salary( get_the_ID() ); ?>
                                </p>
                                <p>
                                    <strong><?php _e( 'Job Type:', 'job-board-pro' ); ?></strong><br>
                                    <?php
                                    $job_type = wp_get_post_terms( get_the_ID(), 'job_type' );
                                    echo ! empty( $job_type ) ? $job_type[0]->name : __( 'Not specified', 'job-board-pro' );
                                    ?>
                                </p>
                                <p>
                                    <strong><?php _e( 'Posted Date:', 'job-board-pro' ); ?></strong><br>
                                    <?php echo get_the_date( get_option( 'date_format' ) ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
    }
}
?>

<?php get_footer();
