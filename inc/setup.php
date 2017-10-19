<?php
/**
 * Glocal Theme Set-up Functions
 *
 * @package    Glocal
 * @subpackage Glocal\Includes\Setup
 * @since      1.0.0
 * @license    GPL-2.0+
 */

function vantage_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'vantage-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'vantage-custom-style',
        get_stylesheet_directory_uri() . '/dist/styles/style.min.css',
        array( 'vantage-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'vantage_parent_theme_enqueue_styles' );
