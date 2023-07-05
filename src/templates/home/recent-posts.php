<?php

/**
 * Recent Post Block
 *
 * @author  MadrasThemes
 * @package Jobhunt/Templates
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$section_class = empty($section_class) ? 'jh-section jh-recent-articles blog-grid' : 'jh-section jh-recent-articles blog-grid ' . $section_class;

if (!empty($animation)) {
    $section_class .= ' animate-in-view';
}

if (!empty($type)) {
    $section_class .= ' ' . $type;
}

$recent_posts = new WP_Query($query_args);
if ($recent_posts->have_posts()) : ?>
    <section class="<?php echo esc_attr($section_class); ?>" <?php if (!empty($animation)) : ?>data-animation="<?php echo esc_attr($animation); ?>" <?php endif; ?>>
        <div>
            <div>
                <div class="post-lists">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <article >
                            <div class="post-content">
                                <?php
                                echo '<div class="media-attachment">';
                                jobhunt_post_thumbnail('230x153-crop', true);
                                echo '</div>';
                                jobhunt_post_body_wrap_start();
                                echo '<div>';
                                jobhunt_post_header();
                                echo wp_trim_words(get_the_content(), 12, '....');
                                jobhunt_post_meta();
                                echo '</div>';
                                jobhunt_post_body_wrap_end();
                                ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif;
wp_reset_postdata();
