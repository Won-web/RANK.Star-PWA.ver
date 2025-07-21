<?php
/**
 * The template for displaying search results
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author ClimaxThemes
 * @package Kata
 * @since 1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Page title.
 */
Kata_Helpers::title_archive_output( 'kt-search-posts', 'search' );

if ( Kata_Helpers::advance_mode() ) {
	do_action( 'kata_search' );
} else {
	get_template_part( 'template-parts/default-search' );
}

get_footer();
