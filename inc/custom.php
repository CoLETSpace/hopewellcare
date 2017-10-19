<?php
/**
 * Glocal Theme Set-up Functions
 *
 * @package    Glocal
 * @subpackage Glocal\Includes\Custom
 * @since      1.1.1
 * @license    GPL-2.0+
 */

/**
 * Adds custom classes to the array of body classes.
 * Overrides the `vantage_body_classes` in parent theme
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function vantage_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( siteorigin_setting( 'layout_responsive' ) ) {
		$classes[] = 'responsive';
	}
	$classes[] = 'layout-' . siteorigin_setting( 'layout_bound' );
	$classes[] = 'no-js';

	$is_full_width_template = is_page_template( 'templates/template-full.php' ) || is_page_template( 'templates/template-full-notitle.php' );
	if( !$is_full_width_template ) {
		$wc_shop_sidebar = vantage_is_woocommerce_active() && is_shop() && is_active_sidebar( 'shop' );
		if( in_array( 'buddypress', $classes ) && is_active_sidebar( 'buddypress' ) ) {
			$classes[] = 'has-sidebar';
		} elseif( !is_active_sidebar( 'sidebar-1' ) && !$wc_shop_sidebar ) {
			$classes[] = 'no-sidebar';

			var_dump( in_array( 'buddypress', $classes ) && is_active_sidebar( 'buddypress' ) );
		}
		else {
			$classes[] = 'has-sidebar';
		}
	}

	if( is_customize_preview() ) {
		$classes[] = 'so-vantage-customizer-preview';
	}

	if( wp_is_mobile() ) {
		$classes[] = 'so-vantage-mobile-device';
	}
	$mega_menu_active = function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'primary' );
	if( siteorigin_setting( 'navigation_menu_search' ) && !$mega_menu_active ) {
		$classes[] = 'has-menu-search';
	}

	if( siteorigin_setting( 'layout_force_panels_full' ) ) {
		$classes[] = 'panels-style-force-full';
	}

	$page_settings = siteorigin_page_setting();

	if( !empty( $page_settings ) ) {
		if( !empty( $page_settings['layout'] ) ) $classes[] = 'page-layout-' . $page_settings['layout'];

		if( empty( $page_settings['masthead_margin'] ) ) $classes[] = 'page-layout-no-masthead-margin';
		if( empty( $page_settings['footer_margin'] ) ) $classes[] = 'page-layout-no-footer-margin';
		if( !empty( $page_settings['hide_masthead'] ) ) $classes[] = 'page-layout-hide-masthead';
		if( !empty( $page_settings['hide_footer_widgets'] ) ) $classes[] = 'page-layout-hide-footer-widgets';
	}

	if ( is_page() && is_page_template() ) {
		$classes[] = 'not-default-page';
	}

	return $classes;
}
add_filter( 'body_class', 'vantage_body_classes' );
