<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'WP_Job_Manager_Writepanels' ) ) {
    include( JOB_MANAGER_PLUGIN_DIR . '/includes/admin/class-wp-job-manager-writepanels.php' );
}

class JH_WPJM_Company_Writepanels extends WP_Job_Manager_Writepanels {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ), 1, 2 );
        add_action( 'company_manager_save_company', array( $this, 'save_company_data' ), 1, 2 );
    }

    /**
     * Company fields
     *
     * @return array
     */
    public static function company_fields() {
        $default_field = array(
            'label'              => null,
            'placeholder'        => null,
            'description'        => null,
            'priority'           => 10,
            'value'              => null,
            'default'            => null,
            'classes'            => array(),
            'type'               => 'text',
            'data_type'          => 'string',
            'show_in_admin'      => true,
            'show_in_rest'       => false,
            'auth_edit_callback' => array( __CLASS__, 'auth_check_can_edit_job_listings' ),
            'auth_view_callback' => null,
            'sanitize_callback'  => array( __CLASS__, 'sanitize_meta_field_based_on_input_type' ),
        );

        $fields = apply_filters( 'company_manager_company_fields', array(
            '_company_tagline' => array(
                'label'       => esc_html__( 'Tagline', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'Brief description about the company', 'jobhunt-extensions' )
            ),
            '_company_location' => array(
                'label'       => esc_html__( 'Location', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'e.g. "London, UK", "New York", "Houston, TX"', 'jobhunt-extensions' ),
                'description' => ''
            ),
            '_company_website' => array(
                'label'       => esc_html__( 'Website', 'jobhunt-extensions' ),
                'placeholder' => ''
            ),
            '_company_email' => array(
                'label'       => esc_html__( 'Email', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'you@yourdomain.com', 'jobhunt-extensions' ),
                'description' => ''
            ),
            '_company_phone' => array(
                'label'       => esc_html__( 'Phone', 'jobhunt-extensions' ),
                'placeholder' => '',
                'description' => ''
            ),
            '_company_twitter' => array(
                'label'       => esc_html__( 'Twitter', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'company twitter page link', 'jobhunt-extensions' ),
            ),
            '_company_facebook' => array(
                'label'       => esc_html__( 'Facebook', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'company facebook page link', 'jobhunt-extensions' ),
            ),
            '_company_googleplus' => array(
                'label'       => esc_html__( 'Google+', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'company google plus page link', 'jobhunt-extensions' ),
            ),
            '_company_linkedin' => array(
                'label'       => esc_html__( 'LinkedIn', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'company linkedin page link', 'jobhunt-extensions' ),
            ),
            '_company_video' => array(
                'label'       => esc_html__( 'Video', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'URL to the company video', 'jobhunt-extensions' ),
                'type'        => 'file'
            ),
            '_company_since' => array(
                'label'       => esc_html__( 'Since', 'jobhunt-extensions' ),
                'placeholder' => esc_html__( 'company established', 'jobhunt-extensions' ),
            ),
            '_featured' => array(
                'label' => esc_html__( 'Feature this Company?', 'jobhunt-extensions' ),
                'type'  => 'checkbox',
                'description' => esc_html__( 'Featured companies will be sticky during searches, and can be styled differently.', 'jobhunt-extensions' )
            ),
            '_company_author' => array(
                'label' => esc_html__( 'Posted by', 'jobhunt-extensions' ),
                'type'  => 'author'
            ),
        ) );

        // Ensure default fields are set.
        foreach ( $fields as $key => $field ) {
            $fields[ $key ] = array_merge( $default_field, $field );
        }

        uasort( $fields, array( __CLASS__, 'sort_by_priority' ) );

        return $fields;
    }

    /**
     * add_meta_boxes function.
     */
    public function add_meta_boxes() {
        add_meta_box( 'company_data', esc_html__( 'Company Data', 'jobhunt-extensions' ), array( $this, 'company_data' ), 'company', 'normal', 'high' );
    }

    /**
     * Company data
     *
     * @param mixed $post
     */
    public function company_data( $post ) {
        global $post, $thepostid;

        $thepostid = $post->ID;

        echo '<div class="wp_company_manager_meta_data wp_job_manager_meta_data">';

        wp_nonce_field( 'save_meta_data', 'company_manager_nonce' );

        do_action( 'company_manager_company_data_start', $thepostid );

        foreach ( $this->company_fields() as $key => $field ) {
            $type = ! empty( $field['type'] ) ? $field['type'] : 'text';

            if ( ! isset( $field['value'] ) && metadata_exists( 'post', $thepostid, $key ) ) {
                $field['value'] = get_post_meta( $thepostid, $key, true );
            }

            if ( ! isset( $field['value'] ) && isset( $field['default'] ) ) {
                $field['value'] = $field['default'];
            }

            if( has_action( 'company_manager_input_' . $type ) ) {
                do_action( 'company_manager_input_' . $type, $key, $field );
            } elseif( method_exists( $this, 'input_' . $type ) ) {
                call_user_func( array( $this, 'input_' . $type ), $key, $field );
            }
        }

        do_action( 'company_manager_company_data_end', $thepostid );

        echo '</div>';
    }

    /**
     * Triggered on Save Post
     *
     * @param mixed $post_id
     * @param mixed $post
     */
    public function save_post( $post_id, $post ) {
        if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( is_int( wp_is_post_revision( $post ) ) ) return;
        if ( is_int( wp_is_post_autosave( $post ) ) ) return;
        if ( empty( $_POST['company_manager_nonce'] ) || ! wp_verify_nonce( $_POST['company_manager_nonce'], 'save_meta_data' ) ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;
        if ( $post->post_type != 'company' ) return;

        do_action( 'company_manager_save_company', $post_id, $post );
    }

    /**
     * Save Company Meta
     *
     * @param mixed $post_id
     * @param mixed $post
     */
    public function save_company_data( $post_id, $post ) {
        global $wpdb;

        // These need to exist
        add_post_meta( $post_id, '_featured', 0, true );

        foreach ( $this->company_fields() as $key => $field ) {

            // Expirey date
            if ( '_company_founded' === $key ) {
                if ( ! empty( $_POST[ $key ] ) ) {
                    update_post_meta( $post_id, $key, date( 'Y-m-d', strtotime( sanitize_text_field( $_POST[ $key ] ) ) ) );
                } else {
                    update_post_meta( $post_id, $key, '' );
                }
            }

            elseif ( '_company_location' === $key ) {
                if ( update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) ) ) {
                    do_action( 'company_manager_company_location_edited', $post_id, sanitize_text_field( $_POST[ $key ] ) );
                } elseif ( apply_filters( 'company_manager_geolocation_enabled', true ) && ! WP_Job_Manager_Geocode::has_location_data( $post_id ) ) {
                    WP_Job_Manager_Geocode::generate_location_data( $post_id, sanitize_text_field( $_POST[ $key ] ) );
                }
                continue;
            }

            elseif( '_company_author' === $key ) {
                $wpdb->update( $wpdb->posts, array( 'post_author' => $_POST[ $key ] > 0 ? absint( $_POST[ $key ] ) : 0 ), array( 'ID' => $post_id ) );
            }

            // Everything else
            else {
                $type = ! empty( $field['type'] ) ? $field['type'] : '';

                switch ( $type ) {
                    case 'textarea' :
                        update_post_meta( $post_id, $key, wp_kses_post( stripslashes( $_POST[ $key ] ) ) );
                    break;
                    case 'checkbox' :
                        if ( isset( $_POST[ $key ] ) ) {
                            update_post_meta( $post_id, $key, 1 );
                        } else {
                            update_post_meta( $post_id, $key, 0 );
                        }
                    break;
                    default :
                        if ( is_array( $_POST[ $key ] ) ) {
                            update_post_meta( $post_id, $key, array_filter( array_map( 'sanitize_text_field', $_POST[ $key ] ) ) );
                        } else {
                            update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
                        }
                    break;
                }
            }
        }
    }
}

new JH_WPJM_Company_Writepanels();