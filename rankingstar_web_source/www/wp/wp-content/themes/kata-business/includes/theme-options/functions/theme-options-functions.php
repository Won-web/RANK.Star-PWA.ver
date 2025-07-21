<?php

/**
 * Kata Plus Theme Options Helpers.
 *
 * @since   1.0.0
 */

if ( !class_exists( 'Kata_Theme_Options_Functions' ) ) {
	class Kata_Theme_Options_Functions {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Theme_Options_Functions
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return   object
		 */
		public static function get_instance() {
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->actions();
		}

		/**
		 * Add actions.
		 *
		 * @since    1.0.0
		 */
		public function actions() {
			// Responsive
			add_filter( 'wp_head', [$this, 'option_responsive'], 100 );
			// Load google fonts
			add_action( 'wp_enqueue_scripts', [$this, 'load_google_fonts'] );
			// Option Dynamic Styles
			add_action( 'kata_header_template', [$this, 'header_template'] );
			// Option Dynamic Styles
			add_action( 'customize_preview_init', [$this, 'option_dynamic_styles'], 999999 );
			// Page Title
			add_action( 'kata_page_before_loop', [$this, 'page_title'], 10 );
			// Sidebars
			add_action( 'kata_page_before_loop', [$this, 'left_sidebar'], 30 );
			add_action( 'kata_page_before_the_content', [$this, 'start_page_with_sidebar'] );
			add_action( 'kata_page_after_the_content', [$this, 'end_page_with_sidebar'] );
			add_action( 'kata_page_after_loop', [$this, 'right_sidebar'] );
			// Body Classes
			add_filter( 'body_class', [$this, 'body_classes'] );
			// Backup customizer
			add_action( 'wp_head', [$this, 'backup_customizer'] );
			add_action( 'wp_head', [$this, 'restore_backup_customizer'] );
			add_action( 'kata_footer_bottom_template', [$this, 'footer_bottom_template'] );
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function header_template() {
			$kata_header_layout = get_theme_mod( 'kata_header_layout', 'left' );
			switch ( $kata_header_layout ) {
				case 'left':
					?>
					<div class="col-md-2 kt-h-logo-wrapper">
						<div class="kata-logo">
							<a class="kata-default-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
								$logo_id = get_theme_mod( 'custom_logo' ) ? get_theme_mod( 'custom_logo' ) : '';
								$logo    = wp_get_attachment_image_src( $logo_id, 'full' ) ? wp_get_attachment_image_src( $logo_id, 'full' )[0] : '';
								if( $logo ) {
									Kata_Helpers::image_resize_output( $logo_id, array( '163', '60' ) );
								} else {
									echo wp_kses_post( '<h4><strong>' . get_bloginfo( 'name' ) . '</strong></h4>' );
								}
								?>
							</a>
						</div> <!-- end .kata-logo -->
					</div>
					<div class="col-md-9 kt-h-menu-wrapper">
						<div class="kata-menu-wrap">
							<a href="#" class="kt-h-menu-hamburger">
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
							</a>
							<?php
							if ( has_nav_menu( 'kt-nav-menu' ) ) {
								wp_nav_menu(
									array(
										'menu'           => 'Default Menu',
										'container'      => false,
										'theme_location' => 'kt-nav-menu',
										'menu_id'        => 'kata-menu-navigation-' . uniqid(),
										'menu_class'     => 'kata-menu-navigation',
										'depth'          => '5',
										'fallback_cb'    => 'wp_page_menu',
										'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
										'echo'           => true,
									)
								);
							}
							?>
						</div> <!-- end .kata-menu-wrap -->
					</div>
					<div class="col-md-1 kt-h-search-wrapper">
						<div class="kata-header-search-wrap kata-text-right">
							<div class="icon-wrap">
								<a href="#" class="kt-header-search">
									<i class="kata-icon"><svg version="1.1"   width="32" height="32" viewBox="0 0 32 32"> <g id="icomoon-ignore"> </g> <path d="M28.591 27.273l-7.263-7.264c1.46-1.756 2.339-4.010 2.339-6.471 0-5.595-4.535-10.129-10.129-10.129-5.594 0-10.129 4.535-10.129 10.129 0 5.594 4.536 10.129 10.129 10.129 2.462 0 4.716-0.879 6.471-2.339l7.263 7.264 1.319-1.319zM4.475 13.538c0-4.997 4.065-9.063 9.063-9.063 4.997 0 9.063 4.066 9.063 9.063s-4.066 9.063-9.063 9.063c-4.998 0-9.063-4.066-9.063-9.063z" fill="#000000"></path> </svg></i>
								</a>
							</div>
							<div class="search-form-wrap" style="display: none;">
								<?php get_search_form(); ?>
								<a href="#" class="header-close-search"><i class="kata-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"> <g id="icomoon-ignore"> </g> <path d="M10.722 9.969l-0.754 0.754 5.278 5.278-5.253 5.253 0.754 0.754 5.253-5.253 5.253 5.253 0.754-0.754-5.253-5.253 5.278-5.278-0.754-0.754-5.278 5.278z" fill="#000000"></path> </svg></i></a>
							</div>
						</div>
					</div>
					<div class="kata-mobile-menu-navigation"></div>
					<?php
				break;
				case 'center':
					?>
					<div class="col-md-12 kata-text-center kt-h-logo-wrapper">
						<div class="kata-logo">
							<a class="kata-default-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
								$logo_id = get_theme_mod( 'custom_logo' ) ? get_theme_mod( 'custom_logo' ) : '';
								$logo    = wp_get_attachment_image_src( $logo_id, 'full' ) ? wp_get_attachment_image_src( $logo_id, 'full' )[0] : '';
								if( $logo ) {
									Kata_Helpers::image_resize_output( $logo_id, array( '163', '60' ) );
								} else {
									echo wp_kses_post( '<h4><strong>' . get_bloginfo( 'name' ) . '</strong></h4>' );
								}
								?>
							</a>
						</div> <!-- end .kata-logo -->
					</div>
					<div class="col-md-12 kata-text-center kt-h-menu-wrapper">
						<div class="kata-menu-wrap">
							<a href="#" class="kt-h-menu-hamburger">
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
							</a>
							<?php
							if ( has_nav_menu( 'kt-nav-menu' ) ) {
								wp_nav_menu(
									array(
										'menu'           => 'Default Menu',
										'container'      => false,
										'theme_location' => 'kt-nav-menu',
										'menu_id'        => 'kata-menu-navigation-' . uniqid(),
										'menu_class'     => 'kata-menu-navigation',
										'depth'          => '5',
										'fallback_cb'    => 'wp_page_menu',
										'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
										'echo'           => true,
									)
								);
							}
							?>
						</div> <!-- end .kata-menu-wrap -->
					</div>
					<div class="kata-mobile-menu-navigation"></div>
					<?php
				break;
				case 'right':
					?>
					<div class="col-md-1 kt-h-search-wrapper">
						<div class="kata-header-search-wrap kata-text-left">
							<div class="icon-wrap">
								<a href="#" class="kt-header-search">
									<i class="kata-icon"><svg version="1.1"   width="32" height="32" viewBox="0 0 32 32"> <g id="icomoon-ignore"> </g> <path d="M28.591 27.273l-7.263-7.264c1.46-1.756 2.339-4.010 2.339-6.471 0-5.595-4.535-10.129-10.129-10.129-5.594 0-10.129 4.535-10.129 10.129 0 5.594 4.536 10.129 10.129 10.129 2.462 0 4.716-0.879 6.471-2.339l7.263 7.264 1.319-1.319zM4.475 13.538c0-4.997 4.065-9.063 9.063-9.063 4.997 0 9.063 4.066 9.063 9.063s-4.066 9.063-9.063 9.063c-4.998 0-9.063-4.066-9.063-9.063z" fill="#000000"></path> </svg></i>
								</a>
							</div>
							<div class="search-form-wrap" style="display: none;">
								<?php get_search_form(); ?>
								<a href="#" class="header-close-search"><i class="kata-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"> <g id="icomoon-ignore"> </g> <path d="M10.722 9.969l-0.754 0.754 5.278 5.278-5.253 5.253 0.754 0.754 5.253-5.253 5.253 5.253 0.754-0.754-5.253-5.253 5.278-5.278-0.754-0.754-5.278 5.278z" fill="#000000"></path> </svg></i></a>
							</div>
						</div>
					</div>
					<div class="col-md-9 kata-text-right kt-h-menu-wrapper">
						<div class="kata-menu-wrap">
							<a href="#" class="kt-h-menu-hamburger">
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
								<div class="kt-hm-line"></div>
							</a>
							<?php
							if ( has_nav_menu( 'kt-nav-menu' ) ) {
								wp_nav_menu(
									array(
										'menu'           => 'Default Menu',
										'container'      => false,
										'theme_location' => 'kt-nav-menu',
										'menu_id'        => 'kata-menu-navigation-' . uniqid(),
										'menu_class'     => 'kata-menu-navigation',
										'depth'          => '5',
										'fallback_cb'    => 'wp_page_menu',
										'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
										'echo'           => true,
									)
								);
							}
							?>
						</div> <!-- end .kata-menu-wrap -->
					</div>
					<div class="col-md-2 kt-h-logo-wrapper">
						<div class="kata-logo">
							<a class="kata-default-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
								$logo_id = get_theme_mod( 'custom_logo' ) ? get_theme_mod( 'custom_logo' ) : '';
								$logo    = wp_get_attachment_image_src( $logo_id, 'full' ) ? wp_get_attachment_image_src( $logo_id, 'full' )[0] : '';
								if( $logo ) {
									Kata_Helpers::image_resize_output( $logo_id, array( '163', '60' ) );
								} else {
									echo wp_kses_post( '<h4><strong>' . get_bloginfo( 'name' ) . '</strong></h4>' );
								}
								?>
							</a>
						</div> <!-- end .kata-logo -->
					</div>
					<div class="kata-mobile-menu-navigation"></div>
					<?php
				break;
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function footer_bottom_template() {
			$kata_footer_bottom_layout 				= get_theme_mod( 'kata_footer_bottom_layout', 'left' );
			$kata_footer_bottom_left_section		= get_theme_mod( 'kata_footer_bottom_left_section', 'custom-text' );
			$kata_footer_bottom_left_custom_text 	= get_theme_mod( 'kata_footer_bottom_left_custom_text', 'Copyright ©[kata-date] all right reserved.' );
			$kata_footer_bottom_right_section 		= get_theme_mod( 'kata_footer_bottom_right_section', 'none' );
			$kata_footer_bottom_right_custom_text 	= get_theme_mod( 'kata_footer_bottom_right_custom_text', 'Email: contact@yourwebsite.com' );
			switch ( $kata_footer_bottom_layout ) {
				case 'left':
					?>
					<div class="col-md-6 kata-footer-bottom-column-left">
						<?php if ( 'custom-text' === $kata_footer_bottom_left_section ) { ?>
							<p class="copyright"><?php echo esc_html( str_replace( '[kata-date]', date( 'Y' ), $kata_footer_bottom_left_custom_text ) ); ?></p>
						<?php } ?>
						<?php if ( 'footer-menu' === $kata_footer_bottom_left_section ) { ?>
							<?php
								if ( has_nav_menu( 'kt-foot-menu' ) ) {
									wp_nav_menu(
										array(
											'menu'           => 'Default Menu',
											'container'      => false,
											'theme_location' => 'kt-foot-menu',
											'menu_id'        => 'kata-menu-navigation-' . uniqid(),
											'menu_class'     => 'kata-menu-navigation kata-footer-menu-navigation',
											'depth'          => '5',
											'fallback_cb'    => 'wp_page_menu',
											'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
											'echo'           => true,
										)
									);
								}
							?>
						<?php } ?>
						<?php if ( 'widget' === $kata_footer_bottom_left_section ) { ?>
							<?php
								if ( is_active_sidebar( 'kata-footr-bot-left-sidebar' ) ) {
									dynamic_sidebar( 'kata-footr-bot-left-sidebar' );
								}
							?>
						<?php } ?>
					</div>
					<div class="col-md-6 kata-footer-bottom-column-right">
						<?php if ( 'custom-text' === $kata_footer_bottom_right_section ) { ?>
							<p class="copyright"><?php echo esc_html( str_replace( '[kata-date]', date( 'Y' ), $kata_footer_bottom_right_custom_text ) ); ?></p>
						<?php } ?>
						<?php if ( 'footer-menu' === $kata_footer_bottom_right_section ) { ?>
							<?php
								if ( has_nav_menu( 'kt-foot-menu' ) ) {
									wp_nav_menu(
										array(
											'menu'           => 'Default Menu',
											'container'      => false,
											'theme_location' => 'kt-foot-menu',
											'menu_id'        => 'kata-menu-navigation-' . uniqid(),
											'menu_class'     => 'kata-menu-navigation kata-footer-menu-navigation',
											'depth'          => '5',
											'fallback_cb'    => 'wp_page_menu',
											'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
											'echo'           => true,
										)
									);
								}
							?>
						<?php } ?>
						<?php if ( 'widget' === $kata_footer_bottom_right_section ) { ?>
							<?php
								if ( is_active_sidebar( 'kata-footr-bot-right-sidebar' ) ) {
									dynamic_sidebar( 'kata-footr-bot-right-sidebar' );
								}
							?>
						<?php } ?>
					</div>
					<?php
				break;
				case 'center':
					?>
					<div class="col-md-12">
						<?php if ( 'custom-text' === $kata_footer_bottom_left_section ) { ?>
							<p class="copyright"><?php echo esc_html( str_replace( '[kata-date]', date( 'Y' ), $kata_footer_bottom_left_custom_text ) ); ?></p>
						<?php } ?>
						<?php if ( 'footer-menu' === $kata_footer_bottom_left_section ) { ?>
							<?php
								if ( has_nav_menu( 'kt-foot-menu' ) ) {
									wp_nav_menu(
										array(
											'menu'           => 'Default Menu',
											'container'      => false,
											'theme_location' => 'kt-foot-menu',
											'menu_id'        => 'kata-menu-navigation-' . uniqid(),
											'menu_class'     => 'kata-menu-navigation kata-footer-menu-navigation',
											'depth'          => '5',
											'fallback_cb'    => 'wp_page_menu',
											'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
											'echo'           => true,
										)
									);
								}
							?>
						<?php } ?>
						<?php if ( 'widget' === $kata_footer_bottom_left_section ) { ?>
							<?php
								if ( is_active_sidebar( 'kata-footr-bot-left-sidebar' ) ) {
									dynamic_sidebar( 'kata-footr-bot-left-sidebar' );
								}
							?>
						<?php } ?>
						<?php if ( 'footer-menu' === $kata_footer_bottom_right_section ) { ?>
							<?php
								if ( has_nav_menu( 'kt-foot-menu' ) ) {
									wp_nav_menu(
										array(
											'menu'           => 'Default Menu',
											'container'      => false,
											'theme_location' => 'kt-foot-menu',
											'menu_id'        => 'kata-menu-navigation-' . uniqid(),
											'menu_class'     => 'kata-menu-navigation kata-footer-menu-navigation',
											'depth'          => '5',
											'fallback_cb'    => 'wp_page_menu',
											'items_wrap'     => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
											'echo'           => true,
										)
									);
								}
							?>
						<?php } ?>
						<?php if ( 'widget' === $kata_footer_bottom_right_section ) { ?>
							<?php
								if ( is_active_sidebar( 'kata-footr-bot-center-sidebar' ) ) {
									dynamic_sidebar( 'kata-footr-bot-center-sidebar' );
								}
							?>
						<?php } ?>
						<?php if ( 'custom-text' === $kata_footer_bottom_right_section ) { ?>
							<p class="copyright"><?php echo esc_html( str_replace( '[kata-date]', date( 'Y' ), $kata_footer_bottom_right_custom_text ) ); ?></p>
						<?php } ?>
					</div>
					<?php
				break;
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function load_google_fonts( $classes ) {
			$fonts = get_theme_mod( 'kata_add_google_font_repeater' );
			$voiced_fonts = '';
			if ( $fonts ) {
				foreach ($fonts as $key => $font) {
					$voiced_fonts .= $font['fonts'] . ':' . $font['varients'] . '|';
				}
			}
			$src = 'https://fonts.googleapis.com/css?family=' . $voiced_fonts;
			if ( $voiced_fonts ) {
				wp_enqueue_style( 'kata-plus-basic-google-fonts', $src, [], Kata::$version );
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @param $classes return body custom classes added by theme.
		 * @since   1.0.0
		 */
		public function body_classes( $classes ) {
			$colorbase = get_theme_mod('kata_base_color', '');
			if (!empty($colorbase)) {
				$classes[] = 'kata-color-base';
			}

			return $classes;
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function option_dynamic_styles() {
			$css = '';

			// Body Typography
			$body_typo_status		= get_theme_mod( 'kata_body_typography_status', 'disable' );
			$body_font_family		= get_theme_mod( 'kata_body_font_family', 'select-font' );
			$body_font_properties	= get_theme_mod( 'kata_body_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$body_font_color		= get_theme_mod( 'kata_body_font_color' );
			if ( 'enabel' == $body_typo_status ) {
				$css .= 'body{';
				$css .= $body_font_family ? 'font-family:' . $body_font_family . ';' :'';
				$css .= $body_font_properties['font-size'] ? 'font-size:' . $body_font_properties['font-size'] . ';' : '';
				$css .= $body_font_properties['font-weight'] ? 'font-weight:' . $body_font_properties['font-weight'] . ';' : '';
				$css .= $body_font_properties['letter-spacing'] ? 'letter-spacing:' . $body_font_properties['letter-spacing'] . ';' : '';
				$css .= $body_font_properties['line-height'] ? 'line-height:' . $body_font_properties['line-height'] . ';' : '';
				$css .= $body_font_color ? 'color:' . $body_font_color . ';' : '';
				$css .= '}';
			}

			// Heading Typography
			$headings_typo_status		= get_theme_mod( 'kata_headings_typography_status', 'disable' );
			$headings_font_family		= get_theme_mod( 'kata_headings_font_family', 'select-font' );
			$headings_font_properties	= get_theme_mod( 'kata_headings_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$headings_font_color		= get_theme_mod( 'kata_headings_font_color' );
			if ( 'enabel' == $headings_typo_status ) {
				$css .= 'h1,h2,h3,h4,h5,h6{';
				$css .= $headings_font_family ? 'font-family:' . $headings_font_family . ';' :'';
				$css .= $headings_font_properties['font-size'] ? 'font-size:' . $headings_font_properties['font-size'] . ';' : '';
				$css .= $headings_font_properties['font-weight'] ? 'font-weight:' . $headings_font_properties['font-weight'] . ';' : '';
				$css .= $headings_font_properties['letter-spacing'] ? 'letter-spacing:' . $headings_font_properties['letter-spacing'] . ';' : '';
				$css .= $headings_font_properties['line-height'] ? 'line-height:' . $headings_font_properties['line-height'] . ';' : '';
				$css .= $headings_font_color ? 'color:' . $headings_font_color . ';' : '';
				$css .= '}';
			}

			// Menu Navigation Typography
			$nav_menu_typo_status		= get_theme_mod( 'kata_nav_menu_typography_status', 'disable' );
			$nav_menu_font_family		= get_theme_mod( 'kata_nav_menu_font_family', 'select-font' );
			$nav_menu_font_properties	= get_theme_mod( 'kata_nav_menu_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$nav_menu_font_color		= get_theme_mod( 'kata_nav_menu_font_color' );
			if ( 'enabel' == $nav_menu_typo_status ) {
				$css .= '.kata-menu-navigation li a{';
				$css .= $nav_menu_font_family ? 'font-family:' . $nav_menu_font_family . ';' :'';
				$css .= $nav_menu_font_properties['font-size'] ? 'font-size:' . $nav_menu_font_properties['font-size'] . ';' : '';
				$css .= $nav_menu_font_properties['font-weight'] ? 'font-weight:' . $nav_menu_font_properties['font-weight'] . ';' : '';
				$css .= $nav_menu_font_properties['letter-spacing'] ? 'letter-spacing:' . $nav_menu_font_properties['letter-spacing'] . ';' : '';
				$css .= $nav_menu_font_properties['line-height'] ? 'line-height:' . $nav_menu_font_properties['line-height'] . ';' : '';
				$css .= $nav_menu_font_color ? 'color:' . $nav_menu_font_color . ';' : '';
				$css .= '}';
			}

			// Mobile Header Templates
			$kata_mobile_header_layout = get_theme_mod( 'kata_mobile_header_layout', 'left' );
			if ( 'right' === $kata_mobile_header_layout ) {
				$css .= '@media(max-width:1024px){.kata-header-mobile-template-right .row { flex-direction: row-reverse; }.kt-h-logo-wrapper[class*="col-"] { text-align: right; } .kt-h-menu-wrapper[class*="col-"] { text-align: left; }}';
			}

			// Full width Header
			$kata_full_width_header = get_theme_mod( 'kata_full_width_header', 'off' );
			if ( $kata_full_width_header ) {
				$css .= '.kata-header .container { max-width: 100%; }';
			}

			// Full width Header
			$kata_header_border			= get_theme_mod( 'kata_header_border' );
			$kata_header_border_color	= get_theme_mod( 'kata_header_border_color', '#f0f1f1' );
			if ( $kata_header_border ) {
				$css .= '#kata-header { border-bottom: ' . $kata_header_border . 'px solid';
				if ( $kata_header_border_color ) {
					$css .= ' ' . $kata_header_border_color;
				}
				$css .= ';}';
			}


			// Container Size
			$kata_grid_size_desktop         = get_theme_mod( 'kata_grid_size_desktop', '1280' );
			$kata_grid_size_laptop          = get_theme_mod( 'kata_grid_size_laptop', '1024' );
			$kata_grid_size_tabletlandscape = get_theme_mod( 'kata_grid_size_tabletlandscape', '96' );
			$kata_grid_size_tablet          = get_theme_mod( 'kata_grid_size_tablet', '96' );
			$kata_grid_size_mobile          = get_theme_mod( 'kata_grid_size_mobile', '96' );
			$kata_grid_size_small_mobile    = get_theme_mod( 'kata_grid_size_small_mobile', '96' );
			$wide_container = get_theme_mod( 'kata_wide_container', '0' );


			if ( $kata_grid_size_desktop ) {
				$css .= '.container, .elementor-section.elementor-section-boxed>.elementor-container{ max-width: ' . $kata_grid_size_desktop . 'px;}';
			}
			// Layout
			if ( $wide_container ) {
				$css .= ' @media ( min-width: 1367px ) { .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: 96%; } }';
			}
			if ( $kata_grid_size_laptop ) {
				$css .= '@media(max-width:1366px){ .container, .elementor-section.elementor-section-boxed>.elementor-container{ max-width: ' . $kata_grid_size_laptop . 'px;} }';
			}
			if ( $kata_grid_size_tabletlandscape ) {
				$css .= '@media(max-width:1024px){  .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_tabletlandscape . '% !important;} }';
			}
			if ( $kata_grid_size_tablet ) {
				$css .= '@media(max-width:768px){  .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_tablet . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			if ( $kata_grid_size_mobile ) {
				$css .= '@media(max-width:480px){  .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_mobile . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			if ( $kata_grid_size_small_mobile ) {
				$css .= '@media(max-width:320px){  .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_small_mobile . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			$css .= '.elementor-section.elementor-section-boxed>.elementor-container .elementor-container, .elementor-section.elementor-section-boxed>.elementor-container .container { max-width: 100% !important; }';
			$css .= '.single .kata-content .container .elementor-container { max-width: 100%; }';

			// Color Skin
			$colorbase = get_theme_mod( 'kata_base_color', '' );
			if ( $colorbase ) {
				$css .= '
				.kata-color-base .kata-menu-navigation>li.menu-item.current-menu-ancestor>a,
				.kata-color-base .kata-menu-navigation ul:not(.mega-menu-content)>li.menu-item.current-menu-parent>a,
				.kata-color-base .kata-menu-navigation ul:not(.mega-menu-content) li.menu-item.current-menu-parent ul>li.current-menu-item a,
				.kata-color-base .kata-language-switcher li a, .kata-color-base .kata-hamburger-menu-navigation>li.current-menu-item>a,
				.kata-color-base .kata-owl.dots-num .owl-dot.active, .df-color, .df-color-h:hover, .kata-color-base .kata-menu-navigation li.current-menu-item>a { color: ' . $colorbase . '; }
				.df-fill, .df-fill-h:hover { fill: ' . $colorbase . '; }
				.kata-color-base .kata-arc-scale .kata-loader .kata-arc::before,
				.kata-color-base .kata-arc-scale .kata-loader .kata-arc::after,
				.kata-color-base .kata-owl .owl-dots .owl-dot.active,
				.dbg-color, .dbg-color-h:hover { background-color: ' . $colorbase . '; }
				.dbo-color, .dbo-color-h:hover { border-color: ' . $colorbase . '; } ';
			} else {
				$css .= '
				.df-color, .df-color-h:hover { color: #403cf2; }
				.df-fill, .df-fill-h:hover { fill: #403cf2; }
				.dbg-color, .dbg-color-h:hover { background-color: #403cf2; }
				.dbo-color, .dbo-color-h:hover { border-color: #403cf2; }';
			}

			$uploaddir = wp_get_upload_dir();
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				WP_Filesystem();
			}
			$wp_filesystem->put_contents(
				$uploaddir['basedir'] . '/kata/css/dynamic-styles.css',
				kata_Helpers::cssminifier( $css ),
				FS_CHMOD_FILE
			);
		}

		/**
		 * Left Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function left_sidebar() {
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position != 'none') {
				echo '<div class="row">';
			}

			// Left sidebar
			if ($sidebar_position == 'left' || $sidebar_position == 'both') {
				echo '<div class="col-md-3 kata-sidebar kata-left-sidebar">';
				if (is_active_sidebar('kata-left-sidebar')) {
					dynamic_sidebar('kata-left-sidebar');
				}
				echo '</div>';
			}
		}

		/**
		 * Start Page with Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function start_page_with_sidebar() {
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position == 'both') {
				echo '<div class="col-md-6 kata-page-content">';
			} elseif ($sidebar_position == 'right' || $sidebar_position == 'left') {
				echo '<div class="col-md-9 kata-page-content">';
			}
		}

		/**
		 * End Page with Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function end_page_with_sidebar() {
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position != 'none') {
				echo '</div>';
			}
		}

		/**
		 * Right Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function right_sidebar() {
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			// Right sidebar
			if ($sidebar_position == 'right' || $sidebar_position == 'both') {
				echo '<div class="col-md-3 kata-sidebar kata-right-sidebar">';
				if (is_active_sidebar('kata-right-sidebar')) {
					dynamic_sidebar('kata-right-sidebar');
				}
				echo '</div>';
			}

			if ($sidebar_position != 'none') {
				echo '</div>';
			}
		}

		/**
		 * Page Title.
		 *
		 * @since   1.0.0
		 */
		public function page_title() {
			$page_title_meta      = Kata_Helpers::get_meta_box( 'kata_show_page_title' );
			$page_title_text_meta = Kata_Helpers::get_meta_box( 'kata_page_title_text' );
			$page_title           = $page_title_meta != 'inherit_from_customizer' ? $page_title_meta : get_theme_mod( 'kata_show_page_title', '1' );
			$page_title_class     = '1' === $page_title ? 'on' : 'off';
			$page_title_text      = $page_title_text_meta ? $page_title_text_meta : get_the_title();

			if ( 'on' === $page_title_class ) {
				echo '
				<div id="kata-page-title" class="kata-page-title">
					<div class="container">
						<div class="col-sm-12">
							<h1>' . wp_kses_post( $page_title_text ) . '</h1>
						</div>
					</div>
				</div>';
			}
		}

		/**
		 * Responsive.
		 *
		 * @since   1.0.0
		 */
		public function option_responsive() {
			$kata_grid_size_desktop	= get_theme_mod( 'kata_grid_size_desktop', '1280' );
			if (get_theme_mod('kata_responsive', '1') == '1') {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
			} else {
				echo '<meta name="viewport" content="width=' . esc_attr( $kata_grid_size_desktop ) . ',user-scalable=yes">';
			}
		}

		/**
		 * Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function backup_customizer() {
			if ( strlen(json_encode(get_option( 'theme_mods_kata' ))) < 86 ) {
				return;
			}
			if ( ! get_option( 'customizer_backup' ) ) {
				add_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				add_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
			if ( get_option( 'customizer_backup_date' ) <= date( 'Ymd' ) && '-' !== get_option( 'theme_mods_kata' ) ) {
				update_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				update_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
		}

		/**
		 * Restore Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function restore_backup_customizer() {
			if ( get_option( 'customizer_backup' ) && get_option( 'customizer_backup_date' ) ) {
				if ( '-' == get_option( 'theme_mods_kata' ) ) {
					$user			= wp_get_current_user();
					$allowed_roles	= ['editor', 'administrator', 'author'];
					if ( array_intersect( $allowed_roles, $user->roles ) ) {
						echo '<div class="kata-plus-customizer-problem" style="background:#ffb0b0;padding:10px 10px 7px;"><h3 style="line-height:1.2;font-size:21px;font-weight:normal;color:#ad0000;">' . __( 'There is a problem with customizer (theme options) data\'s please refresh the page to resolve the problem', 'kata-business' ) . '</h3></div>';
					}
					update_option( 'theme_mods_kata', get_option( 'customizer_backup' ) );
				}
			}
		}

	} // Class

	Kata_Theme_Options_Functions::get_instance();
}
