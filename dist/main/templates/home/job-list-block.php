<?php

/**
 * Job List Block
 *
 * @package Jobhunt/Templates
 */

if (!defined('ABSPATH')) {
    exit;
}

if (jobhunt_is_wp_job_manager_activated()) {
    $section_class = empty($section_class) ? 'jh-section job-list-section' : 'jh-section job-list-section ' . $section_class;

?>
    <section <?php if (!empty($animation)) : ?>data-animation="<?php echo esc_attr($animation); ?>" <?php endif; ?>>
        <div>
            <?php echo apply_filters('jobhunt_job_list_html', do_shortcode($shortcode)); ?>
        </div>
    </section>
<?php
}
