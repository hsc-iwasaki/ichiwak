<?php
if ( ! class_exists( 'Redux' ) ) {
    return;
}

if ( ! class_exists( 'Jobhunt_Options' ) ) {

    class Jobhunt_Options {

        public function __construct( ) {
            add_action( 'after_setup_theme', array( $this, 'load_config' ) );
        }

        public function load_config() {

            $options        = array( 'general', 'header', 'footer', 'blog', '404', 'style', 'typography', 'job' );
            $options_dir    = get_template_directory() . '/inc/redux-framework/options';

            foreach ( $options as $option ) {
                $options_file = $option . '-options.php';
                require_once $options_dir . '/' . $options_file ;
            }

            $sections   = apply_filters( 'jobhunt_options_sections_args', array( $general_options, $header_options, $footer_options, $blog_options, $error_page_options, $job_options,  $style_options, $typography_options) );
            $theme      = wp_get_theme();
            $opt_name   = 'jobhunt_options';
            $args       = array(
                'opt_name'          => $opt_name,
                'display_name'      => $theme->get( 'Name' ),
                'display_version'   => $theme->get( 'Version' ),
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__( 'Jobhunt', 'jobhunt' ),
                'page_priority'     => 3,
                'page_slug'         => 'theme_options',
                'intro_text'        => '',
                'dev_mode'          => false,
                'customizer'        => true,
                'footer_credit'     => '&nbsp;',
            );

            Redux::set_args( $opt_name, $args );
            Redux::set_sections( $opt_name, $sections );
            Redux::disable_demo();
        }
    }

    new Jobhunt_Options();
}

if( ! array_key_exists( 'jobhunt_options' , $GLOBALS ) ) {
    $GLOBALS['jobhunt_options'] = get_option( 'jobhunt_options', array() );
}