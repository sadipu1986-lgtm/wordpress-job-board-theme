<?php
/**
 * Footer Template
 * 
 * @package Job_Board_Pro
 */

?>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-widget">
                    <h3><?php echo get_bloginfo( 'name' ); ?></h3>
                    <p><?php echo get_bloginfo( 'description' ); ?></p>
                </div>
                
                <div class="footer-widget">
                    <h3><?php _e( 'Quick Links', 'job-board-pro' ); ?></h3>
                    <ul>
                        <li><a href="<?php echo get_post_type_archive_link( 'job' ); ?>"><?php _e( 'Browse Jobs', 'job-board-pro' ); ?></a></li>
                        <li><a href="#"><?php _e( 'Post a Job', 'job-board-pro' ); ?></a></li>
                        <li><a href="#"><?php _e( 'For Companies', 'job-board-pro' ); ?></a></li>
                        <li><a href="#"><?php _e( 'About Us', 'job-board-pro' ); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-widget">
                    <h3><?php _e( 'Popular Categories', 'job-board-pro' ); ?></h3>
                    <ul>
                        <?php
                        $categories = get_terms( array(
                            'taxonomy' => 'job_category',
                            'number' => 5,
                        ) );
                        
                        foreach ( $categories as $category ) {
                            echo '<li><a href="' . get_term_link( $category ) . '">' . $category->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="footer-widget">
                    <h3><?php _e( 'Contact Info', 'job-board-pro' ); ?></h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:info@example.com">info@example.com</a></li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Business St, City, State</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date( 'Y' ); ?> <?php echo get_bloginfo( 'name' ); ?>. <?php _e( 'All rights reserved.', 'job-board-pro' ); ?></p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
