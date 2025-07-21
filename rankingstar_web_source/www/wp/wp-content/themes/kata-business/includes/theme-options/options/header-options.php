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

if ( ! class_exists( 'Kata_Theme_Options_Header' ) ) {
	class Kata_Theme_Options_Header extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {

			// Header Section
			Kirki::add_section(
				'kata_header_section',
				[
					'icon'       => 'ti-layout-tab-window',
					'title'      => esc_html__( 'Header', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
					'priority'	 => 2,

				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_header_border',
					'section'         => 'kata_header_section',
					'label'           => esc_html__('Border', 'kata-business'),
					'description'     => esc_html__('Header border bottom size', 'kata-business'),
					'type'            => 'slider',
					'default'         => 1,
					'choices'         => [
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'  => 'kata_header_section',
					'settings' => 'kata_header_border_color',
					'type'     => 'color',
					'label'    => esc_html__('Border Color', 'kata-business'),
					'description'     => esc_html__('Header border bottom color', 'kata-business'),
					'default'  => '#f0f1f1',
					'choices'  => [
						'alpha' => true,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_full_width_header',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Full Width Header', 'kata-business' ),
					'type'        => 'switch',
					'default'     => 'off',
					'choices'     => [
						'on'  	=> esc_html__( 'Enabled', 'kata-business' ),
						'off'	=> esc_html__( 'Disabled', 'kata-business' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_header_layout',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Layout', 'kata-business' ),
					'type'        => 'radio-image',
					'default'     => 'left',
					'choices'     => [
						'left'   => kata::$assets . '/left-header.png',
						'right'  => kata::$assets . '/right-header.png',
						'center' => kata::$assets . '/center-header.png',
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_mobile_header_layout',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Mobile Layout', 'kata-business' ),
					'type'        => 'radio-image',
					'default'     => 'left',
					'choices'     => [
						'left'   => kata::$assets . '/mobile-left-header.png',
						'right'  => kata::$assets . '/mobile-right-header.png',
					],
				]
			);

		}
	} // class

	Kata_Theme_Options_Header::set_options();
}
