<?php
/**
 * Job Card Template Part
 * 
 * @package Job_Board_Pro
 */

?>
<div class="job-card">
    <div class="job-card-header">
        <?php if ( has_post_thumbnail() ) { ?>
            <img src="<?php echo get_the_post_thumbnail_url( null, 'job-logo' ); ?>" alt="<?php the_title(); ?>" class="job-company-logo">
        <?php } else { ?>
            <div class="job-company-logo" style="background: linear-gradient(135deg, #0066cc, #0052a3); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                <?php echo strtoupper( substr( get_post_meta( get_the_ID(), 'job_company', true ) ?: 'JB', 0, 2 ) ); ?>
            </div>
        <?php } ?>
        
        <div class="job-card-title-wrap">
            <div class="job-card-company">
                <?php echo get_post_meta( get_the_ID(), 'job_company', true ) ?: __( 'Company', 'job-board-pro' ); ?>
            </div>
            <h3 class="job-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div>
    </div>
    
    <div class="job-card-meta">
        <span class="job-meta-item">
            <i class="fas fa-map-marker-alt"></i>
            <?php echo get_post_meta( get_the_ID(), 'job_location', true ) ?: __( 'Location not specified', 'job-board-pro' ); ?>
        </span>
        
        <span class="job-meta-item">
            <i class="fas fa-briefcase"></i>
            <?php
            $job_type = wp_get_post_terms( get_the_ID(), 'job_type' );
            echo ! empty( $job_type ) ? $job_type[0]->name : __( 'Type not specified', 'job-board-pro' );
            ?>
        </span>
        
        <span class="job-meta-item">
            <i class="fas fa-clock"></i>
            <?php echo job_board_get_duration( get_the_ID() ); ?>
        </span>
    </div>
    
    <div class="job-card-excerpt">
        <?php the_excerpt(); ?>
    </div>
    
    <div class="job-card-footer">
        <div class="job-salary">
            <?php echo job_board_get_salary( get_the_ID() ); ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="job-apply-btn">
            <?php _e( 'View Details', 'job-board-pro' ); ?>
        </a>
    </div>
</div>
