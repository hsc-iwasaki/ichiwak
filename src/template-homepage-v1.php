<?php

/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage v1
 *
 * @package jobhunt
 */

if (function_exists('jobhunt_is_wp_job_manager_activated') && jobhunt_is_wp_job_manager_activated()) {
    remove_action('jobhunt_before_content', 'jobhunt_site_content_header', 10);
    add_action('jobhunt_before_content', 'jobhunt_home_v1_search_block', 10);
    add_action('jobhunt_home_page_header_after', 'jobhunt_home_scroll_button', 15);
}

do_action('jobhunt_before_homepage_v1');

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        /**
         * Functions hooked in to homepage action
         *
         * @hooked jobhunt_homepage_content                 - 10
         * @hooked jobhunt_home_v1_job_categories_block     - 20
         * @hooked jobhunt_home_v1_banner_v1                - 30
         * @hooked jobhunt_home_v1_job_list_block           - 40
         * @hooked jobhunt_home_v1_testimonial_block        - 50
         * @hooked jobhunt_home_v1_brands_carousel          - 60
         * @hooked jobhunt_home_v1_recent_posts             - 70
         * @hooked jobhunt_home_v1_banner_v2                - 80
         */
        do_action('jobhunt_homepage_v1'); ?>
        <div class="site-main__about">
            <div class="img">
                <img src="<?php echo get_template_directory_uri() ?>/img/top/about-h2.png" alt="">
            </div>
            <div class="text">
                <p>
                    当サイトでは、幅広い分野の求人を提供し、市原市での働き方を全く新しい視点から探求します。<br>
                    どんな夢を抱いていても、どんなキャリアを目指していても、ここ市原市でその実現のチャンスを見つけましょう。<br>
                    <br>
                    「いちはらで働こう！」という一歩を踏み出す勇気、私たちはあなたと共にその先へ進むお手伝いをします。<br>
                </p>
            </div>
            <div class="btn">
                <a href="#">いちワクについて</a>
            </div>
        </div>
        <div class="site-main__joblist">
            <div class="section-title">
                <p>ICHIHARA JOB LIST</p>
                <h2>求人情報</h2>
            </div>
            <div>
                <div class="inner job-list">
                    <?php
                    $shortcode  = !empty($jlb_options['shortcode']) ? $jlb_options['shortcode'] : '[jobs featured="true" per_page="6" show_filters="false"]';
                    $home_v1        = jobhunt_get_home_v1_meta();
                    $jlb_options    = $home_v1['jlb'];
                    $args = apply_filters('jobhunt_home_v1_job_list_block_args', array(
                        'shortcode'             => $shortcode
                    ));
                    jobhunt_job_list_block($args);
                    ?>
                </div>
            </div>
            <div class="btn">
                <a href="#">他の求人情報はこちら</a>
            </div>
        </div>
        <!-- <div class="site-main__knowledge">
            <div class="section-title">
                <p>RECRUIT KNOWLEDGE</p>
                <h2>就職に役立つ知識</h2>
            </div>
            <div class="inner blog-lists">
                jobhunt_recent_posts();
            </div>
            <div class="btn">
                <a href="#">他の情報はこちら</a>
            </div>
        </div> -->
    </main><!-- #main -->
</div>
<?php
get_footer();
