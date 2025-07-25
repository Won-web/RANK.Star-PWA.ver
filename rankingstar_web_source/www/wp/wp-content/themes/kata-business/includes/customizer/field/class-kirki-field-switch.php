<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Switch extends Kirki_Field_Checkbox {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-switch';
	}

	/**
	 * Sets the control choices.
	 *
	 * @access protected
	 */
	protected function set_choices() {
		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}

		$this->choices = wp_parse_args(
			$this->choices,
			array(
				'on'    => esc_html__( 'On', 'kata-business' ),
				'off'   => esc_html__( 'Off', 'kata-business' ),
				'round' => false,
			)
		);
	}
}
