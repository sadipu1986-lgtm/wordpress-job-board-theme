<?php
/**
 * Header Template
 * 
 * @package Job_Board_Pro
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <header class="site-header">
        <div class="container">
            <div class="site-logo">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo get_bloginfo( 'name' );
                }
                ?>
            </div>
            
            <nav class="site-nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class' => 'site-nav',
                    'container' => false,
                    'fallback_cb' => function() {
                        echo '<a href="#">Home</a>';
                        echo '<a href="' . get_post_type_archive_link( 'job' ) . '">Jobs</a>';
                        echo '<a href="#">About</a>';
                        echo '<a href="#">Contact</a>';
                    },
                ) );
                ?>
            </nav>
        </div>
    </header>
