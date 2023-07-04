<?php
/**
 * Template Loader
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Template loader class.
 */
class JH_WPJMC_Template_Loader {

    /**
     * Store the company page ID.
     *
     * @var integer
     */
    private static $companies_page_id = 0;

    /**
     * Hook in methods.
     */
    public static function init() {
        self::$companies_page_id  = jh_wpjmc_get_page_id( 'companies' );

        // Supported themes.
        add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
    }

    /**
     * Load a template.
     *
     * Handles template usage so that we can use our own templates instead of the themes.
     *
     * Templates are in the 'templates' folder. woocommerce looks for theme.
     * overrides in /theme/woocommerce/ by default.
     *
     * For beginners, it also looks for a woocommerce.php template first. If the user adds.
     * this to the theme (containing a woocommerce() inside) this will be used for all.
     * woocommerce templates.
     *
     * @param string $template Template to load.
     * @return string
     */
    public static function template_loader( $template ) {

        if ( is_embed() ) {
            return $template;
        }

        $default_file = self::get_template_loader_default_file();


        if ( $default_file ) {
            /**
             * Filter hook to choose which files to find before Jobhunt does it's own logic.
             *
             * @since 3.0.0
             * @var array
             */
            $search_files = self::get_template_loader_files( $default_file );
            $template     = locate_template( $search_files );

            if ( ! $template ) {
                $template = get_template_directory() . '/wp-job-manager-companies/' . $default_file;
            }

        }

        return $template;
    }

    /**
     * Get the default filename for a template.
     *
     * @since  3.0.0
     * @return string
     */
    private static function get_template_loader_default_file() {
        if ( is_singular( 'company' ) ) {
            $default_file = 'single-company.php';
        } elseif ( is_post_type_archive( 'company' ) || is_page( self::$companies_page_id ) || is_company_taxonomy() ) {
            $default_file = 'archive-company.php';
        } else {
            $default_file = '';
        }
        return $default_file;
    }

    /**
     * Get an array of filenames to search for a given template.
     *
     * @since  3.0.0
     * @param  string $default_file The default file name.
     * @return string[]
     */
    private static function get_template_loader_files( $default_file ) {
        $templates   = apply_filters( 'woocommerce_template_loader_files', array(), $default_file );

        if ( is_page_template() ) {
            $templates[] = get_page_template_slug();
        }

        if ( is_singular( 'company' ) ) {
            $object       = get_queried_object();
            $name_decoded = urldecode( $object->post_name );
            if ( $name_decoded !== $object->post_name ) {
                $templates[] = "single-company-{$name_decoded}.php";
            }
            $templates[] = "single-company-{$object->post_name}.php";
        }

        if ( is_company_taxonomy() ) {
            $object      = get_queried_object();
            $templates[] = 'taxonomy-' . $object->taxonomy . '-' . $object->slug . '.php';
            $templates[] = get_template_directory() .'/wp-job-manager-companies/' . 'taxonomy-' . $object->taxonomy . '-' . $object->slug . '.php';
            $templates[] = 'taxonomy-' . $object->taxonomy . '.php';
            $templates[] = get_template_directory() .'/wp-job-manager-companies/' . 'taxonomy-' . $object->taxonomy . '.php';
        }

        $templates[] = $default_file;
        $templates[] = get_template_directory() .'/wp-job-manager-companies/' . $default_file;

        return array_unique( $templates );
    }

}

add_action( 'init', array( 'JH_WPJMC_Template_Loader', 'init' ) );