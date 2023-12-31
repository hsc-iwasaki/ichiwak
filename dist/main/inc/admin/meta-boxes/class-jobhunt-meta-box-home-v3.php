<?php
/**
 * Home v3 Metabox
 *
 * Displays the home v3 meta box, tabbed, with several panels covering price, stock etc.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Jobhunt_Meta_Box_Home_v3 Class.
 */
class Jobhunt_Meta_Box_Home_v3 {

    /**
     * Output the metabox.
     *
     * @param WP_Post $post
     */
    public static function output( $post ) {
        global $post, $thepostid;

        wp_nonce_field( 'jobhunt_save_data', 'jobhunt_meta_nonce' );

        $thepostid      = $post->ID;
        $template_file  = get_post_meta( $thepostid, '_wp_page_template', true );

        if ( $template_file !== 'template-homepage-v3.php' ) {
            return;
        }

        self::output_home_v3( $post );
    }

    private static function output_home_v3( $post ) {

        $home_v3 = jobhunt_get_home_v3_meta();

        ?>
        <div class="panel-wrap meta-box-home">
            <ul class="home_data_tabs jh-tabs">
            <?php
                $product_data_tabs = apply_filters( 'jobhunt_home_v3_data_tabs', array(
                    'general' => array(
                        'label'  => esc_html__( 'General', 'jobhunt' ),
                        'target' => 'general_block',
                        'class'  => array(),
                    ),
                    'job_categories_block' => array(
                        'label'  => esc_html__( 'Job Categories', 'jobhunt' ),
                        'target' => 'job_categories_block',
                        'class'  => array(),
                    ),
                    'banner' => array(
                        'label'  => esc_html__( 'Banner', 'jobhunt' ),
                        'target' => 'banner',
                        'class'  => array(),
                    ),
                    'job_list_block' => array(
                        'label'  => esc_html__( 'Job List', 'jobhunt' ),
                        'target' => 'job_list_block',
                        'class'  => array(),
                    ),
                    'how_it_works_block' => array(
                        'label'  => esc_html__( 'How It Works Block', 'jobhunt' ),
                        'target' => 'how_it_works_block',
                        'class'  => array(),
                    ),
                    'company_info_carousel' => array(
                        'label'  => esc_html__( 'Company Carousel', 'jobhunt' ),
                        'target' => 'company_info_carousel',
                        'class'  => array(),
                    ),
                    'testimonial_block' => array(
                        'label'  => esc_html__( 'Testimonials', 'jobhunt' ),
                        'target' => 'testimonial_block',
                        'class'  => array(),
                    ),
                    'app_promo_block' => array(
                        'label'  => esc_html__( 'App Promo Block', 'jobhunt' ),
                        'target' => 'app_promo_block',
                        'class'  => array(),
                    ),
                    'candidate_info_block' => array(
                        'label'  => esc_html__( 'Candidate Info Block', 'jobhunt' ),
                        'target' => 'candidate_info_block',
                        'class'  => array(),
                    ),
                    'job_pricing' => array(
                        'label'  => esc_html__( 'Job Pricing Block', 'jobhunt' ),
                        'target' => 'job_pricing',
                        'class'  => array(),
                    ),
                ) );
                foreach ( $product_data_tabs as $key => $tab ) {
                    ?><li class="<?php echo esc_attr( $key ); ?>_options <?php echo esc_attr( $key ); ?>_tab <?php echo implode( ' ' , $tab['class'] ); ?>">
                        <a href="#<?php echo esc_attr( $tab['target'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
                    </li><?php
                }
                do_action( 'jobhunt_home_write_panel_tabs' );
            ?>
            </ul>

            <div id="general_block" class="panel jobhunt_options_panel">
                <div class="options_group">
                    <?php
                        jobhunt_wp_select( array(
                            'id'        => '_home_v3_header_style',
                            'label'     => esc_html__( 'Header Style', 'jobhunt' ),
                            'name'      => '_home_v3[header_style]',
                            'options'   => array(
                                'v1'    => esc_html__( 'Header v1', 'jobhunt' ),
                                'v2'    => esc_html__( 'Header v2', 'jobhunt' ),
                                'v3'    => esc_html__( 'Header v3', 'jobhunt' ),
                                'v4'    => esc_html__( 'Header v4', 'jobhunt' ),
                                'v5'    => esc_html__( 'Header v5', 'jobhunt' )
                            ),
                            'value'     => isset(  $home_v3['header_style'] ) ?  $home_v3['header_style'] : 'v3',
                        ) );
                    ?>
                </div>
                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_section_title', 
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][section_title]',
                        'value'         => isset( $home_v3['hsb']['section_title'] ) ? $home_v3['hsb']['section_title'] : '',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_sub_title', 
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][sub_title]',
                        'value'         => isset( $home_v3['hsb']['sub_title'] ) ? $home_v3['hsb']['sub_title'] : '',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_search_placeholder_text', 
                        'label'         => esc_html__( 'Search Placeholder Text', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Search Placeholder Text here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][search_placeholder_text]',
                        'value'         => isset( $home_v3['hsb']['search_placeholder_text'] ) ? $home_v3['hsb']['search_placeholder_text'] : esc_html__( 'Search freelancer services (e.g. logo design)', 'jobhunt' ),
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_location_placeholder_text', 
                        'label'         => esc_html__( 'Location Placeholder Text', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Location Placeholder Text here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][location_placeholder_text]',
                        'value'         => isset( $home_v3['hsb']['location_placeholder_text'] ) ? $home_v3['hsb']['location_placeholder_text'] : esc_html__( 'City, province or region', 'jobhunt' ),
                    ) );

                    jobhunt_wp_checkbox( array(
                        'id'            => '_home_v3_hsb_show_category_select',
                        'label'         => esc_html__( 'Show Categories Select', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][show_category_select]',
                        'value'         => isset( $home_v3['hsb']['show_category_select'] ) ? $home_v3['hsb']['show_category_select'] : '',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_category_select_text', 
                        'label'         => esc_html__( 'All Categories Text', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the All Categories Text here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][category_select_text]',
                        'value'         => isset( $home_v3['hsb']['category_select_text'] ) ? $home_v3['hsb']['category_select_text'] : esc_html__( 'Any Category', 'jobhunt' ),
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_hsb_search_button_icon', 
                        'label'         => esc_html__( 'Search Button Icon', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Search Button Icon here', 'jobhunt' ),
                        'name'          => '_home_v3[hsb][search_button_icon]',
                        'value'         => isset( $home_v3['hsb']['search_button_icon'] ) ? $home_v3['hsb']['search_button_icon'] : 'la la-search',
                    ) );

                ?>
                </div>
                <div class="options_group">
                    <?php
                        $home_v3_blocks = array(
                            'hpc'   => esc_html__( 'Page content', 'jobhunt' ),
                            'jcb'   => esc_html__( 'Job Categories Block', 'jobhunt' ),
                            'br'    => esc_html__( 'Banner', 'jobhunt' ),
                            'jlb'   => esc_html__( 'Job List Block', 'jobhunt' ),
                            'hiw'   => esc_html__( 'How It Works Block', 'jobhunt' ),
                            'cic'   => esc_html__( 'Company Carousel', 'jobhunt' ),
                            'ts'    => esc_html__( 'Testimonials Block', 'jobhunt' ),
                            'ap'    => esc_html__( 'App Promo Block', 'jobhunt' ),
                            'ci'    => esc_html__( 'Candidate Info Block', 'jobhunt' ),
                            'jp'    => esc_html__( 'Job Pricing', 'jobhunt' ),
                        );
                    ?>
                    <table class="general-blocks-table widefat striped">
                        <thead>
                            <tr>
                                <th><?php echo esc_html__( 'Block', 'jobhunt' ); ?></th>
                                <th><?php echo esc_html__( 'Animation', 'jobhunt' ); ?></th>
                                <th><?php echo esc_html__( 'Priority', 'jobhunt' ); ?></th>
                                <th><?php echo esc_html__( 'Enabled ?', 'jobhunt' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $home_v3_blocks as $key => $home_v3_block ) : ?>
                            <tr>
                                <td><?php echo esc_html( $home_v3_block ); ?></td>
                                <td><?php jobhunt_wp_animation_dropdown( array(  'id' => '_home_v3_' . $key . '_animation', 'label'=> '', 'name' => '_home_v3[' . $key . '][animation]', 'value' => isset( $home_v3['' . $key . '']['animation'] ) ? $home_v3['' . $key . '']['animation'] : '', )); ?></td>
                                <td><?php jobhunt_wp_text_input( array(  'id' => '_home_v3_' . $key . '_priority', 'label'=> '', 'name' => '_home_v3[' . $key . '][priority]', 'value' => isset( $home_v3['' . $key . '']['priority'] ) ? $home_v3['' . $key . '']['priority'] : 10, ) ); ?></td>
                                <td><?php jobhunt_wp_checkbox( array( 'id' => '_home_v3_' . $key . '_is_enabled', 'label' => '', 'name' => '_home_v3[' . $key . '][is_enabled]', 'value'=> isset( $home_v3['' . $key . '']['is_enabled'] ) ? $home_v3['' . $key . '']['is_enabled'] : '', ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="options_group">
                    <?php
                        jobhunt_wp_select( array(
                            'id'        => '_home_v3_footer_style',
                            'label'     => esc_html__( 'Footer Style', 'jobhunt' ),
                            'name'      => '_home_v3[footer_style]',
                            'options'   => array(
                                'v1'    => esc_html__( 'Footer v1', 'jobhunt' ),
                                'v2'    => esc_html__( 'Footer v2', 'jobhunt' ),
                                'v3'    => esc_html__( 'Footer v3', 'jobhunt' ),
                                'v4'    => esc_html__( 'Footer v4', 'jobhunt' ),
                                'v5'    => esc_html__( 'Footer v5', 'jobhunt' ),
                            ),
                            'value'     => isset(  $home_v3['footer_style'] ) ?  $home_v3['footer_style'] : 'v3',
                        ) );
                    ?>
                </div>
                <?php do_action( 'jobhunt_home_v3_after_general_block' ) ?>
            </div><!-- /#general_block -->

            <div id="job_categories_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Job Categories', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jcb_section_title',
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][section_title]',
                        'value'         => isset( $home_v3['jcb']['section_title'] ) ? $home_v3['jcb']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_jcb_sub_title',
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][sub_title]',
                        'value'         => isset( $home_v3['jcb']['sub_title'] ) ? $home_v3['jcb']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_jcb_type',
                        'label'         =>  esc_html__( 'Select Version', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][type]',
                        'options'       => array(
                            'v1'            => esc_html__( 'v1', 'jobhunt' ),
                            'v2'            => esc_html__( 'v2', 'jobhunt' ),
                            'v3'            => esc_html__( 'v3', 'jobhunt' ),
                            'v4'            => esc_html__( 'v4', 'jobhunt' ),
                        ),
                        'value'         => isset( $home_v3['jcb']['type'] ) ? $home_v3['jcb']['type'] : 'v1',
                        'class'         => 'show_hide_select',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_jcb_action_text', 
                        'label'         => esc_html__( 'Action Text', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the action text here', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][action_text]',
                        'value'         => isset( $home_v3['jcb']['action_text'] ) ? $home_v3['jcb']['action_text'] : '',
                        'wrapper_class' => 'show_if_v1 show_if_v3 hide',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_jcb_action_link', 
                        'label'         => esc_html__( 'Action Link', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the action link here', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][action_link]',
                        'value'         => isset( $home_v3['jcb']['action_link'] ) ? $home_v3['jcb']['action_link'] : '',
                        'wrapper_class' => 'show_if_v1 show_if_v3 hide',
                    ) );

                    jobhunt_wp_wc_cat_shortcode_atts ( array(
                        'id'            => '_home_v3_jcb_category_args',
                        'name'          => '_home_v3[jcb][category_args]',
                        'value'         => isset( $home_v3['jcb']['category_args'] ) ? $home_v3['jcb']['category_args'] : '',
                        'fields'        => array( 'number', 'orderby', 'order', 'hide_empty', 'slug' ),
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jcb_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[jcb][section_class]',
                        'value'         => isset( $home_v3['jcb']['section_class'] ) ? $home_v3['jcb']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_job_categories_block' ) ?>

            </div><!-- /#job_categories_block -->

            <div id="banner" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Banner', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_br_section_title',
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[br][section_title]',
                        'value'         => isset( $home_v3['br']['section_title'] ) ? $home_v3['br']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_br_sub_title',
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[br][sub_title]',
                        'value'         => isset( $home_v3['br']['sub_title'] ) ? $home_v3['br']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_br_bg_choice',
                        'label'         => esc_html__( 'Background Choice', 'jobhunt' ),
                        'name'          => '_home_v3[br][bg_choice]',
                        'options'       => array(
                            'image'     => esc_html__( 'Image', 'jobhunt' ),
                            'color'     => esc_html__( 'Color', 'jobhunt' ),
                        ),
                        'class'         => 'show_hide_select',
                        'value'         => isset( $home_v3['br']['bg_choice'] ) ? $home_v3['br']['bg_choice'] : 'image',
                    ) );

                    jobhunt_wp_upload_image( array(
                        'id'            => '_home_v3_br_bg_image',
                        'label'         => esc_html__( 'Background Image', 'jobhunt' ),
                        'name'          => '_home_v3[br][bg_image]',
                        'value'         => isset( $home_v3['br']['bg_image'] ) ? $home_v3['br']['bg_image'] : '',
                        'wrapper_class' => 'show_if_image hide',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_br_bg_color',
                        'label'         => esc_html__( 'Background Color', 'jobhunt' ),
                        'name'          => '_home_v3[br][bg_color]',
                        'value'         => isset( $home_v3['br']['bg_color'] ) ? $home_v3['br']['bg_color'] : '',
                        'wrapper_class' => 'show_if_color hide',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_br_action_text', 
                        'label'         => esc_html__( 'Action Text', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the action text here', 'jobhunt' ),
                        'name'          => '_home_v3[br][action_text]',
                        'value'         => isset( $home_v3['br']['action_text'] ) ? $home_v3['br']['action_text'] : '',
                    ) );

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_br_action_link', 
                        'label'         => esc_html__( 'Action Link', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the action link here', 'jobhunt' ),
                        'name'          => '_home_v3[br][action_link]',
                        'value'         => isset( $home_v3['br']['action_link'] ) ? $home_v3['br']['action_link'] : '',
                    ) );

                    jobhunt_wp_checkbox( array(
                        'id'            => '_home_v3_br_is_enable_action',
                        'label'         => esc_html__( 'Enable Action', 'jobhunt' ),
                        'name'          => '_home_v3[br][is_enable_action]',
                        'value'         => isset( $home_v3['br']['is_enable_action'] ) ? $home_v3['br']['is_enable_action'] : '',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_br_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[br][section_class]',
                        'value'         => isset( $home_v3['br']['section_class'] ) ? $home_v3['br']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_banner' ) ?>

            </div><!-- /#banner -->

            <div id="job_list_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Job List', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jlb_section_title',
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jlb][section_title]',
                        'value'         => isset( $home_v3['jlb']['section_title'] ) ? $home_v3['jlb']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_jlb_sub_title',
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jlb][sub_title]',
                        'value'         => isset( $home_v3['jlb']['sub_title'] ) ? $home_v3['jlb']['sub_title'] : '',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jlb_shortcode',
                        'label'         => esc_html__( 'Job Shortcode', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the shorcode for your job here', 'jobhunt' ),
                        'name'          => '_home_v3[jlb][shortcode]',
                        'value'         => isset( $home_v3['jlb']['shortcode'] ) ? $home_v3['jlb']['shortcode'] : '[jobs featured="true" per_page="6" show_filters="false"]',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jlb_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[jlb][section_class]',
                        'value'         => isset( $home_v3['jlb']['section_class'] ) ? $home_v3['jlb']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_job_list_block' ) ?>

            </div><!-- /#job_list_block -->


            <div id="how_it_works_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'How It Works Block', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_section_title', 
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][section_title]',
                        'value'         => isset( $home_v3['hiw']['section_title'] ) ? $home_v3['hiw']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_hiw_sub_title', 
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][sub_title]',
                        'value'         => isset( $home_v3['hiw']['sub_title'] ) ? $home_v3['hiw']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_hiw_type',
                        'label'         =>  esc_html__( 'Select Version', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][type]',
                        'options'       => array(
                            'v1'            => esc_html__( 'v1', 'jobhunt' ),
                            'v2'            => esc_html__( 'v2', 'jobhunt' ),
                            'v3'            => esc_html__( 'v3', 'jobhunt' ),
                            'v4'            => esc_html__( 'v4', 'jobhunt' ),
                        ),
                        'value'         => isset( $home_v3['hiw']['type'] ) ? $home_v3['hiw']['type'] : 'v2',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][section_class]',
                        'value'         => isset( $home_v3['hiw']['section_class'] ) ? $home_v3['hiw']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php jobhunt_wp_legend( esc_html__( 'Step 1', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php
                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_1_icon',
                        'label'         => esc_html__( 'Icon', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the icon for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][0][icon]',
                        'value'         => isset( $home_v3['hiw']['steps'][0]['icon'] ) ? $home_v3['hiw']['steps'][0]['icon'] : '',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_1_step_title',
                        'label'         => esc_html__( 'Step Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step title for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][0][step_title]',
                        'value'         => isset( $home_v3['hiw']['steps'][0]['step_title'] ) ? $home_v3['hiw']['steps'][0]['step_title'] : '',
                    ) );
                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_hiw_step_1_step_desc',
                        'label'         => esc_html__( 'Step Description', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step description for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][0][step_desc]',
                        'value'         => isset( $home_v3['hiw']['steps'][0]['step_desc'] ) ? $home_v3['hiw']['steps'][0]['step_desc'] : '',
                    ) );
                ?>
                </div>

                <?php jobhunt_wp_legend( esc_html__( 'Step 2', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php
                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_2_icon',
                        'label'         => esc_html__( 'Icon', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the icon for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][1][icon]',
                        'value'         => isset( $home_v3['hiw']['steps'][1]['icon'] ) ? $home_v3['hiw']['steps'][1]['icon'] : '',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_2_step_title',
                        'label'         => esc_html__( 'Step Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step title for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][1][step_title]',
                        'value'         => isset( $home_v3['hiw']['steps'][1]['step_title'] ) ? $home_v3['hiw']['steps'][1]['step_title'] : '',
                    ) );
                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_hiw_step_2_step_desc',
                        'label'         => esc_html__( 'Step Description', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step description for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][1][step_desc]',
                        'value'         => isset( $home_v3['hiw']['steps'][1]['step_desc'] ) ? $home_v3['hiw']['steps'][1]['step_desc'] : '',
                    ) );
                ?>
                </div>

                <?php jobhunt_wp_legend( esc_html__( 'Step 3', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php
                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_3_icon',
                        'label'         => esc_html__( 'Icon', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the icon for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][2][icon]',
                        'value'         => isset( $home_v3['hiw']['steps'][2]['icon'] ) ? $home_v3['hiw']['steps'][2]['icon'] : '',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_hiw_step_3_step_title',
                        'label'         => esc_html__( 'Step Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step title for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][2][step_title]',
                        'value'         => isset( $home_v3['hiw']['steps'][2]['step_title'] ) ? $home_v3['hiw']['steps'][2]['step_title'] : '',
                    ) );
                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_hiw_step_2_step_desc',
                        'label'         => esc_html__( 'Step Description', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the step description for your steps here', 'jobhunt' ),
                        'name'          => '_home_v3[hiw][steps][2][step_desc]',
                        'value'         => isset( $home_v3['hiw']['steps'][2]['step_desc'] ) ? $home_v3['hiw']['steps'][2]['step_desc'] : '',
                    ) );
                ?>
                </div>

                <?php do_action( 'jobhunt_home_v3_after_how_it_works_block' ) ?>

            </div><!-- /#how_it_works_block -->

            <div id="company_info_carousel" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Company Carousel', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php 

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_cic_section_title', 
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[cic][section_title]',
                        'value'         => isset( $home_v3['cic']['section_title'] ) ? $home_v3['cic']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array( 
                        'id'            => '_home_v3_cic_sub_title', 
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[cic][sub_title]',
                        'value'         => isset( $home_v3['cic']['sub_title'] ) ? $home_v3['cic']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array( 
                        'id'            => '_home_v3_cic_type',
                        'label'         =>  esc_html__( 'Select Version', 'jobhunt' ),
                        'name'          => '_home_v3[cic][type]',
                        'options'       => array(
                            'v1'            => esc_html__( 'v1', 'jobhunt' ),
                            'v2'            => esc_html__( 'v2', 'jobhunt' ),
                        ),
                        'value'         => isset( $home_v3['cic']['type'] ) ? $home_v3['cic']['type'] : 'v2',
                    ) );

                    jobhunt_wp_checkbox( array(
                        'id'            => '_home_v3_cic_is_featured', 
                        'label'         =>  esc_html__( 'Show Featured', 'jobhunt' ),
                        'name'          => '_home_v3[cic][is_featured]',
                        'value'         => isset( $home_v3['cic']['is_featured'] ) ? $home_v3['cic']['is_featured'] : true,
                    ) );

                    jobhunt_wp_wc_cat_shortcode_atts ( array( 
                        'id'            => '_home_v3_cic_query_args',
                        'name'          => '_home_v3[cic][query_args]',
                        'value'         => isset( $home_v3['cic']['query_args'] ) ? $home_v3['cic']['query_args'] : '',
                        'fields'        => array( 'per_page', 'orderby', 'order' ),
                    ) );

                    jobhunt_wp_slick_carousel_options( array( 
                        'id'            => '_home_v3_cic_carousel_args',
                        'label'         => esc_html__( 'Carousel Args', 'jobhunt' ),
                        'name'          => '_home_v3[cic][carousel_args]',
                        'value'         => isset( $home_v3['cic']['carousel_args'] ) ? $home_v3['cic']['carousel_args'] : '',
                        'fields'        => array( 'slidesToShow', 'slidesToScroll', 'autoplay', 'arrows' ),
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_cic_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[cic][section_class]',
                        'value'         => isset( $home_v3['cic']['section_class'] ) ? $home_v3['cic']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_company_info_carousel' ) ?>

            </div><!-- /#company_info_carousel -->

            <div id="testimonial_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Testimonials', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ts_section_title',
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ts][section_title]',
                        'value'         => isset( $home_v3['ts']['section_title'] ) ? $home_v3['ts']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_ts_sub_title',
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ts][sub_title]',
                        'value'         => isset( $home_v3['ts']['sub_title'] ) ? $home_v3['ts']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_ts_type',
                        'label'         =>  esc_html__( 'Select Version', 'jobhunt' ),
                        'name'          => '_home_v3[ts][type]',
                        'options'       => array(
                            'v1'            => esc_html__( 'v1', 'jobhunt' ),
                            'v2'            => esc_html__( 'v2', 'jobhunt' ),
                            'v3'            => esc_html__( 'v3', 'jobhunt' ),
                        ),
                        'value'         => isset( $home_v3['ts']['type'] ) ? $home_v3['ts']['type'] : 'v3',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_ts_bg_choice',
                        'label'         => esc_html__( 'Background Choice', 'jobhunt' ),
                        'name'          => '_home_v3[ts][bg_choice]',
                        'options'       => array(
                            'image'     => esc_html__( 'Image', 'jobhunt' ),
                            'color'     => esc_html__( 'Color', 'jobhunt' ),
                        ),
                        'class'         => 'show_hide_select',
                        'value'         => isset( $home_v3['ts']['bg_choice'] ) ? $home_v3['ts']['bg_choice'] : 'color',
                    ) );

                    jobhunt_wp_upload_image( array(
                        'id'            => '_home_v3_ts_bg_image',
                        'label'         => esc_html__( 'Background Image', 'jobhunt' ),
                        'name'          => '_home_v3[ts][bg_image]',
                        'value'         => isset( $home_v3['ts']['bg_image'] ) ? $home_v3['ts']['bg_image'] : '',
                        'wrapper_class' => 'show_if_image hide',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ts_bg_color',
                        'label'         => esc_html__( 'Background Color', 'jobhunt' ),
                        'name'          => '_home_v3[ts][bg_color]',
                        'value'         => isset( $home_v3['ts']['bg_color'] ) ? $home_v3['ts']['bg_color'] : '',
                        'wrapper_class' => 'show_if_color hide',
                    ) );

                    jobhunt_wp_wc_cat_shortcode_atts ( array(
                        'id'            => '_home_v3_ts_query_args',
                        'name'          => '_home_v3[ts][query_args]',
                        'value'         => isset( $home_v3['ts']['query_args'] ) ? $home_v3['ts']['query_args'] : '',
                        'fields'        => array( 'limit', 'orderby', 'order' ),
                    ) );

                    jobhunt_wp_slick_carousel_options( array(
                        'id'            => '_home_v3_ts_carousel_args',
                        'label'         => esc_html__( 'Carousel Args', 'jobhunt' ),
                        'name'          => '_home_v3[ts][carousel_args]',
                        'value'         => isset( $home_v3['ts']['carousel_args'] ) ? $home_v3['ts']['carousel_args'] : '',
                        'fields'        => array( 'autoplay' ),
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ts_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[ts][section_class]',
                        'value'         => isset( $home_v3['ts']['section_class'] ) ? $home_v3['ts']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_testimonial_block' ) ?>

            </div><!-- /#testimonial_block -->

            <div id="app_promo_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'App Promo Block', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php 

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_section_title', 
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][section_title]',
                        'value'         => isset( $home_v3['ap']['section_title'] ) ? $home_v3['ap']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array( 
                        'id'            => '_home_v3_ap_sub_title', 
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][sub_title]',
                        'value'         => isset( $home_v3['ap']['sub_title'] ) ? $home_v3['ap']['sub_title'] : '',
                    ) );

                    jobhunt_wp_upload_image( array(
                        'id'            => '_home_v3_ap_image',
                        'label'         => esc_html__( 'Image', 'jobhunt' ),
                        'name'          => '_home_v3[ap][image]',
                        'value'         => isset( $home_v3['ap']['image'] ) ? $home_v3['ap']['image'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_ap_bg_choice',
                        'label'         => esc_html__( 'Background Choice', 'jobhunt' ),
                        'name'          => '_home_v3[ap][bg_choice]',
                        'options'       => array(
                            'image'     => esc_html__( 'Image', 'jobhunt' ),
                            'color'     => esc_html__( 'Color', 'jobhunt' ),
                        ),
                        'class'         => 'show_hide_select',
                        'value'         => isset( $home_v3['ap']['bg_choice'] ) ? $home_v3['ap']['bg_choice'] : 'image',
                    ) );

                    jobhunt_wp_upload_image( array(
                        'id'            => '_home_v3_ap_bg_image',
                        'label'         => esc_html__( 'Background Image', 'jobhunt' ),
                        'name'          => '_home_v3[ap][bg_image]',
                        'value'         => isset( $home_v3['ap']['bg_image'] ) ? $home_v3['ap']['bg_image'] : '',
                        'wrapper_class' => 'show_if_image hide',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ap_bg_color',
                        'label'         => esc_html__( 'Background Color', 'jobhunt' ),
                        'name'          => '_home_v3[ap][bg_color]',
                        'value'         => isset( $home_v3['ap']['bg_color'] ) ? $home_v3['ap']['bg_color'] : '',
                        'wrapper_class' => 'show_if_color hide',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ap_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][section_class]',
                        'value'         => isset( $home_v3['ap']['section_class'] ) ? $home_v3['ap']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php jobhunt_wp_legend( esc_html__( 'App 1', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_1_app_title',
                        'label'         => esc_html__( 'App Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app title for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][0][app_title]',
                        'value'         => isset( $home_v3['ap']['apps'][0]['app_title'] ) ? $home_v3['ap']['apps'][0]['app_title'] : '',
                    ) );
                    jobhunt_wp_textarea_input( array( 
                        'id'            => '_home_v3_ap_app_1_app_desc',
                        'label'         => esc_html__( 'App Description', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app description for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][0][app_desc]',
                        'value'         => isset( $home_v3['ap']['apps'][0]['app_desc'] ) ? $home_v3['ap']['apps'][0]['app_desc'] : '',
                    ) );
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_1_icon',
                        'label'         => esc_html__( 'App Store Icon', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app store icon for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][0][icon]',
                        'value'         => isset( $home_v3['ap']['apps'][0]['icon'] ) ? $home_v3['ap']['apps'][0]['icon'] : '',
                    ) );
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_1_link',
                        'label'         => esc_html__( 'App Store Link', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app store link for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][0][link]',
                        'value'         => isset( $home_v3['ap']['apps'][0]['link'] ) ? $home_v3['ap']['apps'][0]['link'] : '',
                    ) );
                ?>
                </div>

                <?php jobhunt_wp_legend( esc_html__( 'App 2', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_2_app_title',
                        'label'         => esc_html__( 'App Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app title for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][1][app_title]',
                        'value'         => isset( $home_v3['ap']['apps'][1]['app_title'] ) ? $home_v3['ap']['apps'][1]['app_title'] : '',
                    ) );
                    jobhunt_wp_textarea_input( array( 
                        'id'            => '_home_v3_ap_app_2_app_desc',
                        'label'         => esc_html__( 'App Description', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app description for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][1][app_desc]',
                        'value'         => isset( $home_v3['ap']['apps'][1]['app_desc'] ) ? $home_v3['ap']['apps'][1]['app_desc'] : '',
                    ) );
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_2_icon',
                        'label'         => esc_html__( 'App Store Icon', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app store icon for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][1][icon]',
                        'value'         => isset( $home_v3['ap']['apps'][1]['icon'] ) ? $home_v3['ap']['apps'][1]['icon'] : '',
                    ) );
                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ap_app_2_link',
                        'label'         => esc_html__( 'App Store Link', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the app store link for your apps here', 'jobhunt' ),
                        'name'          => '_home_v3[ap][apps][1][link]',
                        'value'         => isset( $home_v3['ap']['apps'][1]['link'] ) ? $home_v3['ap']['apps'][1]['link'] : '',
                    ) );
                ?>
                </div>

                <?php do_action( 'jobhunt_home_v3_after_app_promo_block' ) ?>

            </div><!-- /#app_promo_block -->

            <div id="candidate_info_block" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Candidate Info Block', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php 

                    jobhunt_wp_text_input( array( 
                        'id'            => '_home_v3_ci_section_title', 
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ci][section_title]',
                        'value'         => isset( $home_v3['ci']['section_title'] ) ? $home_v3['ci']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array( 
                        'id'            => '_home_v3_ci_sub_title', 
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[ci][sub_title]',
                        'value'         => isset( $home_v3['ci']['sub_title'] ) ? $home_v3['ci']['sub_title'] : '',
                    ) );

                    jobhunt_wp_select( array(
                        'id'            => '_home_v3_ci_bg_choice',
                        'label'         => esc_html__( 'Background Choice', 'jobhunt' ),
                        'name'          => '_home_v3[ci][bg_choice]',
                        'options'       => array(
                            'image'     => esc_html__( 'Image', 'jobhunt' ),
                            'color'     => esc_html__( 'Color', 'jobhunt' ),
                        ),
                        'class'         => 'show_hide_select',
                        'value'         => isset( $home_v3['ci']['bg_choice'] ) ? $home_v3['ci']['bg_choice'] : 'color',
                    ) );

                    jobhunt_wp_upload_image( array(
                        'id'            => '_home_v3_ci_bg_image',
                        'label'         => esc_html__( 'Background Image', 'jobhunt' ),
                        'name'          => '_home_v3[ci][bg_image]',
                        'value'         => isset( $home_v3['ci']['bg_image'] ) ? $home_v3['ci']['bg_image'] : '',
                        'wrapper_class' => 'show_if_image hide',
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ci_bg_color',
                        'label'         => esc_html__( 'Background Color', 'jobhunt' ),
                        'name'          => '_home_v3[ci][bg_color]',
                        'value'         => isset( $home_v3['ci']['bg_color'] ) ? $home_v3['ci']['bg_color'] : '',
                        'wrapper_class' => 'show_if_color hide',
                    ) );

                    jobhunt_wp_checkbox( array(
                        'id'            => '_home_v3_ci_is_featured', 
                        'label'         =>  esc_html__( 'Show Featured', 'jobhunt' ),
                        'name'          => '_home_v3[ci][is_featured]',
                        'value'         => isset( $home_v3['ci']['is_featured'] ) ? $home_v3['ci']['is_featured'] : true,
                    ) );

                    jobhunt_wp_wc_cat_shortcode_atts ( array( 
                        'id'            => '_home_v3_ci_query_args',
                        'name'          => '_home_v3[ci][query_args]',
                        'value'         => isset( $home_v3['ci']['query_args'] ) ? $home_v3['ci']['query_args'] : '',
                        'fields'        => array( 'per_page', 'orderby', 'order' ),
                    ) );

                    jobhunt_wp_slick_carousel_options( array( 
                        'id'            => '_home_v3_ci_carousel_args',
                        'label'         => esc_html__( 'Carousel Args', 'jobhunt' ),
                        'name'          => '_home_v3[ci][carousel_args]',
                        'value'         => isset( $home_v3['ci']['carousel_args'] ) ? $home_v3['ci']['carousel_args'] : '',
                        'fields'        => array( 'slidesToShow', 'slidesToScroll', 'autoplay' ),
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_ci_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[ci][section_class]',
                        'value'         => isset( $home_v3['ci']['section_class'] ) ? $home_v3['ci']['section_class'] : '',
                    ) );

                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_candidate_info_block' ) ?>

            </div><!-- /#candidate_info_block -->

            <div id="job_pricing" class="panel jobhunt_options_panel">

                <?php jobhunt_wp_legend( esc_html__( 'Job Pricing Block', 'jobhunt' ) ); ?>

                <div class="options_group">
                <?php

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jp_section_title',
                        'label'         => esc_html__( 'Section Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Section Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jp][section_title]',
                        'value'         => isset( $home_v3['jp']['section_title'] ) ? $home_v3['jp']['section_title'] : '',
                    ) );

                    jobhunt_wp_textarea_input( array(
                        'id'            => '_home_v3_jp_sub_title',
                        'label'         => esc_html__( 'Sub Title', 'jobhunt' ),
                        'placeholder'   => esc_html__( 'Enter the Sub Title here', 'jobhunt' ),
                        'name'          => '_home_v3[jp][sub_title]',
                        'value'         => isset( $home_v3['jp']['sub_title'] ) ? $home_v3['jp']['sub_title'] : '',
                    ) );

                    jobhunt_wp_wc_shortcode( array(
                        'id'            => '_home_v3_jp_shortcode_atts',
                        'name'          => '_home_v3[jp][shortcode_content]',
                        'value'         => isset( $home_v3['jp']['shortcode_content'] ) ? $home_v3['jp']['shortcode_content'] : '',
                        'fields'        => array( 'per_page', 'columns', 'orderby' , 'order' ),
                    ) );

                    jobhunt_wp_text_input( array(
                        'id'            => '_home_v3_jp_section_class',
                        'label'         => esc_html__( 'Extra Class', 'jobhunt' ), 
                        'placeholder'   => esc_html__( 'Enter the extra here', 'jobhunt' ),
                        'name'          => '_home_v3[jp][section_class]',
                        'value'         => isset( $home_v3['jp']['section_class'] ) ? $home_v3['jp']['section_class'] : '',
                    ) );
                ?>

                </div>

                <?php do_action( 'jobhunt_home_v3_after_job_pricing' ) ?>

            </div><!-- /#job_pricing -->

        </div>
        <?php
    }

    public static function save( $post_id, $post ) {
        if ( isset( $_POST['_home_v3'] ) ) {
            $clean_home_v3_options = jobhunt_clean_kses_post( $_POST['_home_v3'] );
            update_post_meta( $post_id, '_home_v3_options',  serialize( $clean_home_v3_options ) );
        }
    }
}
