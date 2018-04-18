<?php
/**
 * Pure Framework.
 *
 * WARNING: This is part of the Pure Framework. DO NOT EDIT this file under any circumstances.
 * Please do all your modifications in a child theme.
 *
 * @package Pure
 * @author  Boong
 * @link    https://boongstudio.com/themes/pure
 */

add_action( 'wp_enqueue_scripts', 'pure_load_css' );
function pure_load_css() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
	wp_enqueue_style( PARENT_THEME_NAME, PURE_CSS_URL . "/pure{$suffix}.css", array(), PARENT_THEME_VERSION );
	wp_enqueue_style( 'photoswipe', PURE_CSS_URL . '/photoswipe/photoswipe.css', array(), '4.1.2' );
	wp_enqueue_style( 'photoswipe-default-skin', PURE_CSS_URL . '/photoswipe/default-skin/default-skin.css', array(), '4.1.2' );
//	wp_enqueue_style( 'font-awesome-5', 'https://use.fontawesome.com/releases/v5.0.8/css/all.css' );
}

add_action( 'admin_print_styles', 'pure_load_admin_css' );
function pure_load_admin_css() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
	wp_enqueue_style( PARENT_THEME_NAME . '-admin', PURE_CSS_URL . "/admin{$suffix}.css", array(), PARENT_THEME_VERSION );
}
