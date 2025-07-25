<?php
/**
 * Layout Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Theme_Options_Layout' ) ) {
	class Kata_Theme_Options_Layout extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_layout',
					'section'     => 'title_tagline',
					'label'       => esc_html__( 'Layout', 'kata-business' ),
					'description' => esc_html__( 'Controls the site layout.', 'kata-business' ),
					'type'        => 'radio-buttonset',
					'default'     => 'kata-wide',
					'choices'     => [
						'kata-wide'  => esc_html__( 'Wide', 'kata-business' ),
						'kata-boxed' => esc_html__( 'Boxed', 'kata-business' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_responsive',
					'section'     => 'title_tagline',
					'label'       => esc_html__( 'Responsive', 'kata-business' ),
					'description' => esc_html__( 'Disable this option in case you don\'t need a responsive website.', 'kata-business' ),
					'type'        => 'switch',
					'default'     => '1',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-business' ),
						'off' => esc_html__( 'Disabled', 'kata-business' ),
					],
				]
			);
		}
	} // class

	Kata_Theme_Options_Layout::set_options();
}
