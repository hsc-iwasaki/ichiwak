<?php
/**
 * Job dashboard shortcode content if user is not logged in.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-dashboard-login.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( jobhunt_is_woocommerce_activated() ) :
    echo do_shortcode( '[woocommerce_my_account]' );
else :
?>
<div id="job-manager-job-dashboard">

    <p class="account-sign-in"><?php esc_html_e( 'You need to be signed in to manage your listings.', 'jobhunt' ); ?> <a class="button" href="<?php echo esc_url( apply_filters( 'job_manager_job_dashboard_login_url', wp_login_url( get_permalink() ) ) ); ?>"><?php esc_html_e( 'Sign in', 'jobhunt' ); ?></a></p>

</div>
<?php
endif;