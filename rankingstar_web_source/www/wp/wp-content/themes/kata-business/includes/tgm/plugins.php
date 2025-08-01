<?php
/**
 * TGM Class integration.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

add_action( 'tgmpa_register', 'kata_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function kata_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$url     = 'https://climaxthemes.com/kata/requirements/pp/';
	$plugins = array(
		array(
			'name'               => esc_html__( 'Elementor', 'kata-business' ),
			'slug'               => 'elementor',
			'force_activation'   => false,
			'force_deactivation' => false,
			'required'           => false,
			'version'            => '3.1.3',
		),
		array(
			'name'               => esc_html__( 'Kata Plus', 'kata-business' ),
			'slug'               => 'kata-plus',
			'force_activation'   => false,
			'force_deactivation' => false,
			'required'           => false,
			'version'            => '1.0.4',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	*/
	$config = array(
		'id'           => 'kata-business',                   // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                       // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',      // Menu slug.
		'parent_slug'  => 'themes.php',             // Parent menu slug.
		'capability'   => 'edit_theme_options',     // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
