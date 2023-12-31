<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Resume Sidebar
 *
 * @package jobhunt
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php while ( have_posts() ) : the_post();

                do_action( 'jobhunt_page_before' );

                get_template_part( 'content', 'page' );

                /**
                 * Functions hooked in to jobhunt_page_after action
                 *
                 * @hooked jobhunt_display_comments - 10
                 */
                do_action( 'jobhunt_page_after' );

            endwhile; // End of the loop. ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
do_action( 'jobhunt_sidebar', 'resume' );
get_footer();