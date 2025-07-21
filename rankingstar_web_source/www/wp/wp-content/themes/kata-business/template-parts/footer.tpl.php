<?php
/**
 * Footer template.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

if ( class_exists( 'Kata_Plus_Builders_Base' ) ) {
	return;
}

if ( ! function_exists( 'kata_footer' ) ) {
	/**
	 * Kata Footer.
	 */
	function kata_footer() {
		?>
		<div id="kata-footer" class="kata-footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<?php if ( get_theme_mod( 'kata_footer_widget_area', true ) ) { ?>
						<div class="col-md-4">
							<?php
							if ( is_active_sidebar( 'kata-footr-sidebar-1' ) ) :
								dynamic_sidebar( 'kata-footr-sidebar-1' );
							endif;
							?>
						</div>
						<div class="col-md-4">
							<?php
							if ( is_active_sidebar( 'kata-footr-sidebar-2' ) ) :
								dynamic_sidebar( 'kata-footr-sidebar-2' );
							endif;
							?>
						</div>
						<div class="col-md-4">
							<?php
							if ( is_active_sidebar( 'kata-footr-sidebar-3' ) ) :
								dynamic_sidebar( 'kata-footr-sidebar-3' );
							endif;
							?>
						</div>
					<?php } ?>
				</div>
				<div id="kata-footer-bot" class="kata-footer-bot">
					<div class="container">
						<div class="row">
							<?php do_action( 'kata_footer_bottom_template' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'kata_footer', 'kata_footer' );
}
