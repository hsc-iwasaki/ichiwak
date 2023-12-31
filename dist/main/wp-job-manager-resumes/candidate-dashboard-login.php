<?php
/**
 * Message to show above resume submit form when submitting a new resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/candidate-dashboard-login.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.11.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( jobhunt_is_woocommerce_activated() ) :
    echo do_shortcode( '[woocommerce_my_account]' );
else :
?>
<div id="resume-manager-candidate-dashboard">

	<p class="account-sign-in"><?php _e( 'You need to be signed in to manage your resumes.', 'jobhunt' ); ?> <a class="button" href="<?php echo apply_filters( 'resume_manager_candidate_dashboard_login_url', wp_login_url( get_permalink() ) ); ?>"><?php _e( 'Sign in', 'jobhunt' ); ?></a></p>

</div>
<?php
endif;