<?php
/**
 * Jobs Theme Options
 * 
 */

$job_options    = apply_filters( 'jobhunt_job_single_args', array(
    'title'     => esc_html__( 'Jobs', 'jobhunt' ),
    'icon'      => 'far fa-dot-circle',
    'fields'    => array(
        array(
            'title'     => esc_html__( 'Enable Filtered Links', 'jobhunt' ),
            'id'        => 'enable_filtered_links',
            'on'        => esc_html__('Show', 'jobhunt'),
            'off'       => esc_html__('Hide', 'jobhunt'),
            'type'      => 'switch',
            'default'   => 0,
        ),
        array(
            'title'     => esc_html__( 'Related Jobs ?', 'jobhunt'),
            'subtitle'  => esc_html__( 'Enable to display related jobs in job single.', 'jobhunt' ),
            'id'        => 'related_jobs',
            'type'      => 'switch',
            'on'        => esc_html__( 'Enabled', 'jobhunt' ),
            'off'       => esc_html__( 'Disabled', 'jobhunt' ),
            'default'   => 1,
        ),
    )
) );
