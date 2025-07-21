<?php
/**
 * Kata Dashboard Page
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Dashboard' ) ) {
	/**
	 * Kata.
	 *
	 * @author     Climaxthemes
	 * @package     Kata
	 * @since     1.0.0
	 */
	class Kata_Dashboard {

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
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $version;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $menu_name;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Dashboard
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
			$this->dependencies();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir     			= Kata::$dir . 'includes/dashboard/';
			self::$url     			= Kata::$url;
			self::$version     		= Kata::$version;
			self::$assets  			= Kata::$url . 'assets/';
			self::$menu_name		= wp_get_theme()->Name;
			if ( ! get_theme_mod( 'install-kata-plus' ) ) set_theme_mod( 'install-kata-plus', 'true' );
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
        public function dependencies() {}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'admin_menu', array( $this, 'kata_dashboard' ) );
			add_action( 'current_screen', array( $this, 'current_screen' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			// add_action( 'admin_notices', array( $this, 'kata_plus_install_notice' ) );
        }

		/**
		 * Add Kata theme page (dashboard).
		 *
		 * @since   1.0.0
		 */
        public function kata_plus_install_notice() {
			if ( class_exists( 'Kata_Plus' ) && class_exists( 'Elementor\Plugin' ) ) {
				return false;
			} elseif ( ! class_exists( 'Kata_Plus' ) && class_exists( 'Elementor\Plugin' ) ) {
				return false;
			} elseif ( class_exists( 'Kata_Plus' ) && ! class_exists( 'Elementor\Plugin' ) ) {
				return false;
			}
			if ( isset( $_GET['hide_kata_plus'] ) ) {
				set_theme_mod( 'install-kata-plus', sanitize_text_field( wp_unslash( $_GET['hide_kata_plus'] ) ) );
				return false;
			}
			if ( 'false' == get_theme_mod( 'install-kata-plus' ) ) {
				return false;
			}
			$url = admin_url( 'themes.php?page=tgmpa-install-plugins' );
			?>
			<style>
				.kata-notice.notice.is-dismissible {
					padding-left: 270px;
					background-image: url(<?php echo esc_url( self::$assets . '/dashboard-notice.png' ); ?>);
					background-repeat: no-repeat;
					background-position: 2px 2px;
					background-size: 252px;
					border-left-color: #908efc;
					min-height: 170px;
					padding-right: 10px;
				}

				.kata-notice.notice.is-dismissible h2 {
					margin-bottom: 8px;
					margin-top: 21px;
					font-size: 17px;
					font-weight: 700;
				}

				.kata-notice.notice.is-dismissible a:not(.notice-dismiss) {
					border-radius: 3px;
					border-color: #6d6af8;
					color: #fff;
					text-shadow: unset;
					background: #6d6af8;
					font-weight: 400;
					font-size: 14px;
					line-height: 18px;
					text-decoration: none;
					text-transform: capitalize;
					padding: 12px 20px;
					display: inline-block;
					margin: 7px 0 13px;
					box-shadow: 0 1px 2px rgba(0,0,0,0.1);
					letter-spacing: 0.4px;
				}

				.kata-notice.notice.is-dismissible a:not(.notice-dismiss):hover {
					border-color: #17202e;
					background: #17202e;
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible {
					display: block;
					margin: 0 0 25px;
					border-left: 4px solid #6d6af8;
					border-radius: 2px;
					overflow: hidden;
					box-shadow: 0 2px 7px -1px rgba(0,0,0,0.04);
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible .notice-dismiss {
					display: none;
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible h2 {
					letter-spacing: -0.3px;
				}

			</style>
			<div class="kata-notice kt-dashboard-box notice notice-success is-dismissible">
				<h2><?php echo esc_html__( 'Enable all Features of Kata theme', 'kata-business' ); ?></h2>
				<p><?php echo esc_html__( 'In order to take full advantage of Kata theme and enabling its demo importer, please install the required plugins.', 'kata-business' ); ?></p>
				<p><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html__( 'Install plugins', 'kata-business' ) ?></a></p>
				<a class="notice-dismiss" style="z-index: 9;" href="?hide_kata_plus=false"></a>
			</div>
			<?php
		}

		/**
		 * Add Kata theme page (dashboard).
		 *
		 * @since   1.0.0
		 */
        public function kata_dashboard() {
            add_theme_page(
				self::$menu_name . ' Theme',
				self::$menu_name . ' Theme',
                'edit_theme_options',
                'kata-dashboard',
               array( $this, 'output' )
            );
        }

		/**
		 * Add Kata theme page styles.
		 *
		 * @since   1.0.0
		 */
        public function enqueue_styles() {
			if ( 'appearance_page_kata-dashboard' === self::current_screen() ) {
				wp_enqueue_style( 'kata-dashboard', self::$assets . 'dashboard.css', array(), self::$version );
			}
        }

		/**
		 * Current Screen
		 *
		 * @since   1.0.0
		 */
		public static function current_screen() {
			return get_current_screen()->base;
		}


		/**
		 * Theme page output.
		 *
		 * @since   1.0.0
		 */
        public function output() {
            if ( 'appearance_page_kata-dashboard' === self::current_screen() ) {
				require self::$dir . 'parts/dashboard.header.tpl.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				require self::$dir . 'parts/dashboard.main.content.tpl.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			}
		}



	} // class

	Kata_Dashboard::get_instance();

}
