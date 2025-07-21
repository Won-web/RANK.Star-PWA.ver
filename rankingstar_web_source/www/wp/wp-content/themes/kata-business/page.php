<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

do_action( 'kata_page_before_loop' );

while ( have_posts() ) :
	the_post();
	do_action( 'kata_page_before_the_content' );
	the_content();
	do_action( 'kata_page_after_the_content' );

	// If comments are open or we have at least one comment, load up the comment template.
	wp_link_pages();
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile; // End of the loop.

do_action( 'kata_page_after_loop' );

get_footer();
