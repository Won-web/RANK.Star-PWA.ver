<?php
/**
 * The template for displaying all single Portfolio
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

do_action( 'kata_single_before_loop' );

while ( have_posts() ) :
	the_post();

	do_action( 'kata_single_before_the_content' );

	if ( Kata_Helpers::advance_mode() ) {
		do_action( 'kata_single_portfolio' );
	} elseif ( ! Kata_Helpers::advance_mode() ) {
		Kata_Helpers::single_template();
	} else {
		Kata_Helpers::single_template();
	}

	do_action( 'kata_single_after_the_content' );

endwhile; // End of the loop.

do_action( 'kata_single_after_loop' );

get_footer();
