<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Faq Block Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Jobhunt_Elementor_Jobhunt_Faq_Block extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve Faq Block widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'jobhunt_elementor_jobhunt_faq_block';
    }

    /**
     * Get widget title.
     *
     * Retrieve Faq Block widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Faq Block', 'jobhunt-extensions' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Faq Block widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-plug';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Faq Block widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'jobhunt-elements' ];
    }

    /**
     * Register Faq Block widget controls.
     *
     * ads different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'jobhunt-extensions' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'         => esc_html__( 'Enter Section Title', 'jobhunt-extensions' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter section title.', 'jobhunt-extensions' ),
            ]
        );

        $this->add_control(
            'shortcode',
            [
                'label'         => esc_html__( 'Enter Faq Shortcode', 'jobhunt-extensions' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter faq shortcode.', 'jobhunt-extensions' ),
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'jobhunt-extensions' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter extra class name', 'jobhunt-extensions' ),
            ]
        );

    $this->end_controls_section();

    }

    /**
     * Render Banner output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $args = array(
            'section_title'     => $section_title,
            'shortcode'         => $shortcode,
            'section_class'     => $el_class
        );

        if( function_exists( 'jobhunt_faq_block' ) ) {
            jobhunt_faq_block( $args );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Jobhunt_Elementor_Jobhunt_Faq_Block );