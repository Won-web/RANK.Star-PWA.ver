<?php
/**
 * Kata functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata' ) ) {
	/**
	 * Kata.
	 *
	 * @author     Climaxthemes
	 * @package     Kata
	 * @since     1.0.0
	 */
	class Kata {
		/**
		 * Maintains the current version of Kata theme.
		 *
		 * @access public
		 * @var    string
		 */
		public static $version;

		/**
		 * Maintains theme slug.
		 *
		 * @access public
		 * @var    string
		 */
		public static $theme;

		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

		/**
		 * The url of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $url;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $assets;

		/**
		 * The url of uploads file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir;

		/**
		 * The url of uploads file url.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir_url;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Define the core functionality of the theme.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->definitions();
			$this->actions();
			$this->filters();
			$this->dependencies();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$version 			= '1.0.11';
			self::$theme 			= wp_get_theme(); // Do not change value of slug
			self::$dir     			= trailingslashit( get_template_directory() );
			self::$url     			= trailingslashit( get_template_directory_uri() );
			self::$assets  			= self::$url . 'assets/';
			self::$upload_dir       = wp_get_upload_dir()['basedir'] . '/kata';
			self::$upload_dir_url   = wp_get_upload_dir()['baseurl'] . '/kata';
			define( 'KATA_VERSION', '1.0.11' );
			if ( ! get_theme_mod( 'KTSOURCE', '' ) ) {
				set_theme_mod( 'KTSOURCE', 'KATA' );
			}
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'admin_init', array( $this, 'disable_redirection' ), 1 );
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'wp_head', array( $this, 'pingback_header' ) );
			add_action( 'init', array( $this, 'reg_nav' ) );
		}

		/**
		 * Add filters.
		 *
		 * @since   1.0.0
		 */
		public function reg_nav() {
			register_nav_menus(
				array(
					'kt-nav-menu' 	=> esc_html__( 'Header Menu', 'kata-business' ),
					'kt-foot-menu' 	=> esc_html__( 'Footer Menu', 'kata-business' ),
				)
			);
		}

		/**
		 * Add filters.
		 *
		 * @since   1.0.0
		 */
		public function filters() {
			add_filter( 'body_class', array( $this, 'body_classes' ) );
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			/**
			 * autoloader.
			 */
			require self::$dir . 'includes/autoloader/autoloader.php';
			/**
			 * Theme helpers.
			 */
			require self::$dir . 'includes/class-kata-helpers.php';
			/**
			 * Theme Page (dashboard).
			 */
			require self::$dir . 'includes/dashboard/class-kata-dashboard.php';
			/**
			 * Custom template tags.
			 */
			require self::$dir . 'includes/class-kata-template-tags.php';
			/**
			 * Customizer.
			 */
			require self::$dir . 'includes/customizer/kirki.php';
			require self::$dir . 'includes/theme-options/theme-options.php';

			/**
			 * Template parts.
			 */
			require self::$dir . 'template-parts/header.tpl.php';
			require self::$dir . 'template-parts/footer.tpl.php';

			/**
			 * Load Jetpack compatibility file.
			 */
			if ( defined( 'JETPACK__VERSION' ) ) {
				require self::$dir . 'includes/jetpack.php';
			}

			/**
			 * Load TGM.
			 */
			if ( ! class_exists( 'Kata_Plus' ) ) {
				require self::$dir . '/includes/tgm/class-tgm-plugin-activation.php';
				require self::$dir . 'includes/tgm/plugins.php';
			}
		}

		/**
		 * Disable Redirection.
		 *
		 * @since   1.0.0
		 */
		public function disable_redirection() {
			/**
			 * Disable Elementor Redirection
			 */
			if ( did_action( 'elementor/loaded' ) ) {
				remove_action( 'admin_init', array( \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ) );
			}
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since   1.0.0
		 */
		public function setup() {
			/**
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on Kata, use a find and replace
			 * to change 'kata-business' to the name of your theme in all the template files.
			 */
			load_theme_textdomain( 'kata-business', self::$dir . 'languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/**
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				)
			);

			/**
			 * Add theme support for selective refresh for widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add theme support post formats.
			 */
			add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

			/**
			 * Kata registration.
			 */
			if ( get_option( 'kata_is_active' ) ) {
				update_option( 'kata_is_active', true );
			}

			/**
			 * Enable the use of a custom logo.
			 */
			add_theme_support( 'custom-logo' );

			/**
			 * Woocommerce Support.
			 */
			add_theme_support( 'woocommerce', array(
				'thumbnail_image_width' => 150,
				'single_image_width'    => 300,
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 2,
					'max_rows'        => 8,
					'default_columns' => 4,
					'min_columns'     => 2,
					'max_columns'     => 5,
				),
			) );

		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global  int $content_width
		 * @since   1.0.0
		 */
		public function content_width() {
			// Set content-width.
			global $content_width;
			if ( ! isset( $content_width ) ) {
				$content_width = 640;
			}
		}

		/**
		 * Register widget area.
		 *
		 * @link    https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 * @since   1.0.0
		 */
		public function widgets_init() {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Left Sidebar', 'kata-business' ),
					'id'            => 'kata-left-sidebar',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Right Sidebar', 'kata-business' ),
					'id'            => 'kata-right-sidebar',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 1', 'kata-business' ),
					'id'            => 'kata-footr-sidebar-1',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 2', 'kata-business' ),
					'id'            => 'kata-footr-sidebar-2',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 3', 'kata-business' ),
					'id'            => 'kata-footr-sidebar-3',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Bottom Left Widget area', 'kata-business' ),
					'id'            => 'kata-footr-bot-left-sidebar',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Bottom Right Widget area', 'kata-business' ),
					'id'            => 'kata-footr-bot-right-sidebar',
					'description'   => esc_html__( 'Add widgets here.', 'kata-business' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   1.0.0
		 */
		public function scripts() {
			if (!file_exists(self::$upload_dir)) {
				mkdir(self::$upload_dir, 0777);
			}
			if (!file_exists(self::$upload_dir . '/css')) {
				mkdir(self::$upload_dir . '/css', 0777);
			}
			if (!file_exists(self::$upload_dir . '/css/dynamic-styles.css')) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				$wp_filesystem->put_contents(
					self::$upload_dir . '/css/dynamic-styles.css',
					'',
					FS_CHMOD_FILE
				);
			}
			wp_enqueue_style( 'kata-main', get_template_directory_uri() . '/style.css', array(), self::$version );
			wp_enqueue_style( 'kata-grid', self::$assets . 'grid.css', array(), self::$version );
			wp_enqueue_style( 'kata-theme-styles', self::$assets . 'theme-styles.css', array(), self::$version );
			wp_enqueue_style( 'kata-blog-posts', self::$assets . 'blog-posts.css', array(), self::$version );
			if ( is_single() ) {
				wp_enqueue_style( 'kata-single-post', self::$assets . 'single.css', array(), self::$version );
			}
			wp_enqueue_style( 'kata-menu-navigation', self::$assets . 'menu-navigation.css', array(), self::$version );
			wp_enqueue_script( 'kata-default-scripts', self::$assets . 'default-scripts.js', array( 'jquery' ), self::$version, true );
			wp_enqueue_script( 'kata-superfish', self::$assets . 'superfish.js', array( 'jquery', 'kata-default-scripts' ), self::$version, true );
			wp_enqueue_style( 'kata-dynamic-styles', self::$upload_dir_url . '/css/dynamic-styles.css', [], rand(1, 999));
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
		 *
		 * @since   1.0.0
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param   array $classes Classes for the body element.
		 * @return  array
		 * @since   1.0.0
		 */
		public function body_classes( $classes ) {
			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			// Adds a class of no-sidebar when there is no sidebar present.
			if ( ! is_active_sidebar( 'left-sidebar' ) && ! is_active_sidebar( 'right-sidebar' ) ) {
				$classes[] = 'no-sidebar';
			}

			/**
			 * Transparent header.
			 */
			if ( '1' === Kata_Helpers::get_meta_box( 'kata_make_header_transparent' ) && ! Kata_Helpers::is_blog_pages() ) {
				$classes[] = 'kata-make-header-transparent';
			}
			if ( '1' === Kata_Helpers::get_meta_box( 'kata_header_transparent_white_color' ) && ! Kata_Helpers::is_blog_pages() ) {
				$classes[] = 'kata-header-transparent-white-color';
			}

			/**
			 * Builders Transparent header.
			 */
			if ( Kata_Helpers::is_blog_pages() ) {
				$kata_options = get_option( 'kata_options' );
				if ( Kata_Helpers::is_blog() && isset( $kata_options['builder_options']['Kata Blog']['kata_make_header_transparent'] ) && '1' == $kata_options['builder_options']['Kata Blog']['kata_make_header_transparent'] ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_archive() && isset( $kata_options['builder_options']['Kata Archive']['kata_make_header_transparent'] ) && '1' == $kata_options['builder_options']['Kata Archive']['kata_make_header_transparent'] ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_search() && isset( $kata_options['builder_options']['Kata Search']['kata_make_header_transparent'] ) && '1' == $kata_options['builder_options']['Kata Search']['kata_make_header_transparent'] ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_author() && isset( $kata_options['builder_options']['Kata Author']['kata_make_header_transparent'] ) && '1' == $kata_options['builder_options']['Kata Author']['kata_make_header_transparent'] ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_404() && isset( $kata_options['builder_options']['Kata 404']['kata_make_header_transparent'] ) && '1' == $kata_options['builder_options']['Kata 404']['kata_make_header_transparent'] ) {
					$classes[] = 'kata-make-header-transparent';
				}
			}
			if ( Kata_Helpers::is_blog_pages() ) {
				$kata_options = get_option( 'kata_options' );
				if ( Kata_Helpers::is_blog() && isset( $kata_options['builder_options']['Kata Blog']['kata_header_transparent_white_color'] ) && '1' == $kata_options['builder_options']['Kata Blog']['kata_header_transparent_white_color'] ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_archive() && isset( $kata_options['builder_options']['Kata Archive']['kata_header_transparent_white_color'] ) && '1' == $kata_options['builder_options']['Kata Archive']['kata_header_transparent_white_color'] ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_search() && isset( $kata_options['builder_options']['Kata Search']['kata_header_transparent_white_color'] ) && '1' == $kata_options['builder_options']['Kata Search']['kata_header_transparent_white_color'] ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_author() && isset( $kata_options['builder_options']['Kata Author']['kata_header_transparent_white_color'] ) && '1' == $kata_options['builder_options']['Kata Author']['kata_header_transparent_white_color'] ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_404() && isset( $kata_options['builder_options']['Kata 404']['kata_header_transparent_white_color'] ) && '1' == $kata_options['builder_options']['Kata 404']['kata_header_transparent_white_color'] ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
			}
			return $classes;
		}

		/**
		 * Site classes.
		 *
		 * @param class $class add custom class to body.
		 * @since   1.0.0
		 */
		public static function site_class( $class = '' ) {
			$classes  = array();
			$classes[] = $class;
			$classes[] = get_theme_mod( 'kata_layout', 'kata-wide' );

			/**
			 * Separates classes with a single space, collates classes for site container element.
			 */
			echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
		}
	} // class

	Kata::get_instance();
}
