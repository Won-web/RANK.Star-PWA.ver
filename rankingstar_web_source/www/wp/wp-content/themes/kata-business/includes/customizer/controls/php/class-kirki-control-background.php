<?php
/**
 * Customizer Control: background.
 *
 * Creates a new custom control.
 * Custom controls contains all background-related options.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Adds multiple input fiels that combined make up the background control.
 */
class Kirki_Control_Background extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-background';

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<div class="background-wrapper">

			<!-- background-color -->
			<div class="background-color">
				<h4><?php esc_html_e( 'Background Color', 'kata-business' ); ?></h4>
				<input type="text" data-default-color="{{ data.default['background-color'] }}" data-alpha="true" value="{{ data.value['background-color'] }}" class="kirki-color-control"/>
			</div>

			<!-- background-image -->
			<div class="background-image">
				<h4><?php esc_html_e( 'Background Image', 'kata-business' ); ?></h4>
				<div class="attachment-media-view background-image-upload">
					<# if ( data.value['background-image'] ) { #>
						<div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}"/></div>
					<# } else { #>
						<div class="placeholder"><?php esc_html_e( 'No File Selected', 'kata-business' ); ?></div>
					<# } #>
					<div class="actions">
						<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_html_e( 'Remove', 'kata-business' ); ?></button>
						<button type="button" class="button background-image-upload-button"><?php esc_html_e( 'Select File', 'kata-business' ); ?></button>
					</div>
				</div>
			</div>

			<!-- background-repeat -->
			<div class="background-repeat">
				<h4><?php esc_html_e( 'Background Repeat', 'kata-business' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="no-repeat"<# if ( 'no-repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'No Repeat', 'kata-business' ); ?></option>
					<option value="repeat"<# if ( 'repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat All', 'kata-business' ); ?></option>
					<option value="repeat-x"<# if ( 'repeat-x' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat Horizontally', 'kata-business' ); ?></option>
					<option value="repeat-y"<# if ( 'repeat-y' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat Vertically', 'kata-business' ); ?></option>
				</select>
			</div>

			<!-- background-position -->
			<div class="background-position">
				<h4><?php esc_html_e( 'Background Position', 'kata-business' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="left top"<# if ( 'left top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Top', 'kata-business' ); ?></option>
					<option value="left center"<# if ( 'left center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Center', 'kata-business' ); ?></option>
					<option value="left bottom"<# if ( 'left bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Bottom', 'kata-business' ); ?></option>
					<option value="right top"<# if ( 'right top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Top', 'kata-business' ); ?></option>
					<option value="right center"<# if ( 'right center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Center', 'kata-business' ); ?></option>
					<option value="right bottom"<# if ( 'right bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Bottom', 'kata-business' ); ?></option>
					<option value="center top"<# if ( 'center top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Top', 'kata-business' ); ?></option>
					<option value="center center"<# if ( 'center center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Center', 'kata-business' ); ?></option>
					<option value="center bottom"<# if ( 'center bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Bottom', 'kata-business' ); ?></option>
				</select>
			</div>

			<!-- background-size -->
			<div class="background-size">
				<h4><?php esc_html_e( 'Background Size', 'kata-business' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="cover" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}cover" <# if ( 'cover' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'cover' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}cover"><?php esc_html_e( 'Cover', 'kata-business' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="contain" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}contain" <# if ( 'contain' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'contain' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}contain"><?php esc_html_e( 'Contain', 'kata-business' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="auto" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}auto" <# if ( 'auto' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'auto' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}auto"><?php esc_html_e( 'Auto', 'kata-business' ); ?></label>
					</input>
				</div>
			</div>

			<!-- background-attachment -->
			<div class="background-attachment">
				<h4><?php esc_html_e( 'Background Attachment', 'kata-business' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="scroll" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}scroll" <# if ( 'scroll' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'scroll' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}scroll"><?php esc_html_e( 'Scroll', 'kata-business' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="fixed" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}fixed" <# if ( 'fixed' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'fixed' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}fixed"><?php esc_html_e( 'Fixed', 'kata-business' ); ?></label>
					</input>
				</div>
			</div>
			<input class="background-hidden-value" type="hidden" {{{ data.link }}}>
		<?php
	}
}
