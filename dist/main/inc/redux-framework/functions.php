<?php
/**
 * Redux Framework functions
 *
 * @package Jobhunt/ReduxFramework
 */

/**
 * Setup functions for theme options
 */

function jobhunt_remove_demo_mode_link() {
    if ( class_exists( 'Redux_Framework_Plugin' ) ) {
        $instance = Redux_Framework_Plugin::get_instance();
        remove_filter( 'plugin_row_meta', array( $instance , 'plugin_metalinks'), null, 2 );
        remove_action( 'admin_notices', array( $instance , 'admin_notices' ) );
        remove_filter( 'network_admin_plugin_action_links', array( $instance , 'add_settings_link' ), 1, 2 );
        remove_filter( 'plugin_action_links', array( $instance, 'add_settings_link' ), 1, 2 );
    }
}

function jobhunt_redux_disable_dev_mode_and_remove_admin_notices( $redux ) {
    remove_action( 'admin_notices', array( $redux, '_admin_notices' ), 99 );
    $redux->args['dev_mode'] = false;
    $redux->args['forced_dev_mode_off'] = false;

    if ( class_exists( 'Redux' ) ) {
        Redux::disable_demo();
    }
}

/**
 * Enqueues font awesome for Redux Theme Options
 * 
 * @return void
 */
function redux_queue_font_awesome() {
    wp_register_style( 'redux-fontawesome', get_template_directory_uri() . '/assets/css/fontawesome-all.min.css', array(), time(), 'all' );
    wp_enqueue_style( 'redux-fontawesome' );
}

require_once get_template_directory() . '/inc/redux-framework/functions/general-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/header-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/footer-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/blog-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/404-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/style-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/typography-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/job-functions.php';

