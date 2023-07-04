<?php
/**
 * Filter functions for Jobs Section of Theme Options
 */


if( ! function_exists( 'redux_toggle_related_products' ) ) {
    function redux_toggle_related_products() {
        global $jobhunt_options;

        if( isset( $jobhunt_options['related_jobs'] ) && $jobhunt_options['related_jobs'] == '1' ) {
            $related_jobs = true;
        } else {
            $related_jobs = false;
        }

        return $related_jobs;
    }
}

if( ! function_exists( 'redux_apply_filtered_link' ) ) {
    function redux_apply_filtered_link( $enable ) {
        global $jobhunt_options;

        if( isset( $jobhunt_options['enable_filtered_links'] ) && $jobhunt_options['enable_filtered_links'] == '1' ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}