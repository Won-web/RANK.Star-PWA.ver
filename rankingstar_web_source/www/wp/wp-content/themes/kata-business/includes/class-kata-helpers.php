<?php
/**
 * Theme Helpers Class.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

use Elementor\Plugin;

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Helpers' ) ) {
	/**
	 * Kata Helpers Functions.
	 *
	 * @author     Climaxthemes
	 * @package     Kata
	 * @since     1.0.0
	 */
	class Kata_Helpers {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Helpers
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
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->actions();
		}

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			if ( ! self::advance_mode() ) {
				add_action( 'kata_page_before_the_content', array( $this, 'page_thumbnail' ) );
			}
			add_action( 'kata_page_before_loop', array( $this, 'open_container' ) );
			add_action( 'kata_page_after_loop', array( $this, 'close_container' ) );
			add_action( 'kata_index_before_loop', array( $this, 'open_container' ) );
			add_action( 'kata_index_after_loop', array( $this, 'close_container' ) );
			if ( ! self::advance_mode() ) {
				add_action( 'kata_single_before_loop', array( $this, 'open_container' ) );
				add_action( 'kata_single_after_loop', array( $this, 'close_container' ) );
			}
			add_action( 'kata_search_before_loop', array( $this, 'open_container' ) );
			add_action( 'kata_search_after_loop', array( $this, 'close_container' ) );
			add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ) );
			add_action( 'save_post_post', array( $this, 'posts_time_to_read' ), 100, 3 );
		}

		/**
		 * Is elementor.
		 *
		 * @since   1.0.0
		 */
		public static function is_elementor() {
			return Plugin::$instance->db->is_built_with_elementor( get_the_ID() );
		}

		/**
		 * Open Page Container.
		 *
		 * @since   1.0.0
		 */
		public function open_container() {
			if ( ! did_action( 'elementor/loaded' ) || ! self::is_elementor() ) : ?>
				<div class="container">
				<?php
			endif;
		}

		/**
		 * Close Page Container.
		 *
		 * @since   1.0.0
		 */
		public function close_container() {
			if ( ! did_action( 'elementor/loaded' ) || ! self::is_elementor() ) :
				?>
				</div> <!-- end .container -->
				<?php
			endif;
		}

		/**
		 * Get theme options.
		 *
		 * @param string $opts Required. Option name.
		 * @param string $key Required. Option key.
		 * @param string $default Optional. Default value.
		 * @since   1.0.0
		 */
		public static function get_theme_option( $opts, $key, $default = '' ) {
			return isset( $opts[ $key ] ) ? $opts[ $key ] : $default;
		}

		/**
		 * Get MetaBox.
		 *
		 * @param string  $key Required. Post meta key.
		 * @param string  $id Optional. Post ID.
		 * @param boolean $single Optional. Add class to heading.
		 * @since   1.0.0
		 */
		public static function get_meta_box( $key, $id = '', $single = true ) {
			if ( function_exists( 'rwmb_meta' ) && '' === $id ) {
				return ! empty( rwmb_meta( $key ) ) || rwmb_meta( $key ) === '0' ? rwmb_meta( $key ) : '';
			} else {
				$id = $id ? $id : get_the_ID();
				return get_post_meta( $id, $key, $single );
			}
		}

		/**
		 * Get icon url.
		 *
		 * @param string $font_family Required. Font family.
		 * @param string $icon_name Optional. Icon name.
		 * @since   1.0.0
		 */
		public static function get_icon_url( $font_family = '', $icon_name ) {
			if ( class_exists( 'Kata_Plus' ) ) {
				$font_family = $font_family ? $font_family . '/' : '';
				return Kata_Plus::$assets . 'fonts/svg-icons/' . $font_family . $icon_name . '.svg';
			}
		}

		/**
		 * Get SVG icon.
		 *
		 * @param string  $font_family Optional. Font Family.
		 * @param string  $icon_name Required. Icon Name.
		 * @param string  $custom_class Optional. Custom Class.
		 * @param boolean $extra_attr Optional. Extra Attribute.
		 * @since   1.0.0
		 */
		public static function get_icon( $font_family = '', $icon_name, $custom_class = '', $extra_attr = '' ) {
			if ( ! empty( $icon_name ) ) {
				$space      = ! empty( $custom_class ) ? ' ' : '';
				$extra_attr = ! empty( $extra_attr ) ? ' ' . $extra_attr : '';
				return '<i class="kata-icon' . $space . $custom_class . '"' . $extra_attr . '>' . self::get_icon_dir( $font_family, $icon_name ) . '</i>';
			}
		}

		/**
		 * Get icon url.
		 *
		 * @since   1.0.0
		 */
		public static function get_icon_dir($font_family = '', $icon_name) {
			$font_family = $font_family ? $font_family . '/' : '';
			if( class_exists( 'Kata_Plus' ) ) {
				return apply_filters( 'kata-get-icon-dir', Kata_Plus::$assets_dir . 'fonts/svg-icons/' . $font_family . $icon_name . '.svg' );
			}
		}

		/**
		 * Advance Mode.
		 *
		 * @since   1.0.0
		 */
		public static function advance_mode() {
			if ( did_action( 'elementor/loaded' ) && class_exists( 'Kata_Plus' ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Is Blog Pages
		 *
		 * @since   1.0.0
		 */
		public static function is_blog_pages() {
			global  $post;
			$posttype = get_post_type($post );
			return ( ((is_archive()) || (is_search()) || (is_author()) || (is_category()) || (is_home()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
		}

		/**
		 * Is Blog Page
		 *
		 * @since   1.0.0
		 */
		public static function is_blog() {
			return ( is_home() ) ? true : false ;
		}

		/**
		 * Css Minifier.
		 * @param $css get css
		 * @since   1.0.0
		 */
		public static function cssminifier( $css ) {
			$css = str_replace(
				["\r\n", "\r", "\n", "\t", '    '],
				'',
				preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', trim($css))
			);
			return str_replace(
				['{ ', ' }', ' {', '} ', ' screen and '],
				['{', '}', '{', '}', ''],
				$css
			);
		}

		/**
		 * Retrieve the archive title based on the queried object.
		 *
		 * @since 1.0.0
		 *
		 * @return string Archive title.
		 */
		public static function get_the_archive_title() {
			$title = __( 'Blog', 'kata-business' );

			if ( is_category() ) {
				$title = sprintf( '%s' . __( 'Category:', 'kata-business' ) . '%s%s%s%s', '<span class="kt-tax-name">', '</span>', '<span class="kt-tax-title">', single_cat_title( '', false ), '</span>' );
			} elseif ( is_search() ) {
				$title = '<span class="kt-tax-name">' . __( 'Search Results:', 'kata-business' ) . ' </span><span class="kt-search-title">' . get_query_var( 's' ) . '</span>';
			} elseif ( is_tag() ) {
				$title = sprintf( '%s' . __( 'Tag:', 'kata-business' ) . '%s%s%s%s', '<span class="kt-tax-name">', '</span>', '<span class="kt-tax-title">', single_tag_title( '', false ), '</span>' );
			} elseif ( is_author() ) {
				$title = sprintf( '%s' . __( 'Tag:', 'kata-business' ) . '%s%s%s%s', '<span class="kt-tax-name">', '</span>', '<span class="kt-tax-title">', single_tag_title( '', false ), '</span>' );
				$title = sprintf( '%s' . __( 'Author:', 'kata-business' ) . '%s%s', '<span class="kt-tax-name">', '</span>', '<span class="vcard">' . get_the_author() . '</span>' );
			}
			return $title;
		}

		/**
		 * Archive Title Template.
		 *
		 * @since 1.0.0
		 *
		 * @param string $class Optional. Add class to heading.
		 * @param string $type Required. To detect the archive page.
		 */
		public static function title_archive_output( $class = '', $type ) {
			if ( 'blog' === $type ) {
				$option_name = get_theme_mod( 'kata_show_blog_title', true );
			} elseif ( 'archive' === $type ) {
				$option_name = get_theme_mod( 'kata_show_archive_title', true );
			} elseif ( 'search' === $type ) {
				$option_name = get_theme_mod( 'kata_show_search_title', true );
			} elseif ( 'author' === $type ) {
				$option_name = get_theme_mod( 'kata_show_author_title', true );
			}
			if ( $option_name ) {
				?>
				<header id="kata-page-title" class="kata-page-title">
					<div class="container">
						<div class="col-sm-12">
							<h1 class="kata-archive-page-title <?php echo esc_attr( $class ) ?>"><?php the_archive_title(); ?></h1>
						</div>
					</div>
				</header>
				<?php
			}
		}

		/**
		 * Advance Mode.
		 *
		 * @since   1.0.0
		 */
		public static function build_by_elementor() {
			return get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ? true : false;
		}

		/**
		 * Single Template.
		 *
		 * @since   1.0.0
		 */
		public static function single_template() {
			get_template_part( 'template-parts/posts/post' );
		}

		/**
		 * Image Resizer.
		 *
		 * @param string $id get attachment ID.
		 * @param array  $size get array size.
		 * @since 1.0.0
		 */
		public static function image_resize( $id, $size = array() ) {
			$file     = get_attached_file( $id, true );
			$image    = wp_get_image_editor( wp_get_attachment_url( $id ) );
			$img_src  = realpath( $file );
			$filename = wp_basename( $img_src );
			$src      = str_replace( $filename, '', $img_src );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( $size['0'], $size['1'], true );
				$save_name = $image->generate_filename( $size[0] . 'x' . $size[1], $src, null );
				$save      = $image->save( $save_name );
				return str_replace( $filename, $save['file'], wp_get_attachment_url( $id ) );
			}
		}

		/**
		 * Image Resizer Output.
		 *
		 * @param string $id get attachment ID.
		 * @param array  $size get array size.
		 * @since 1.0.0
		 */
		public static function image_resize_output( $id, $size = array( 300, 300 ), $permalink = true ) {
			$id = $id ? $id : get_post_thumbnail_id();
			$alt = get_post_meta( $id, '_wp_attachment_image_alt', true ) ? ' alt=' . get_post_meta( $id, '_wp_attachment_image_alt', true ) . '' : '';
			$srcset = '';
			if ( wp_get_attachment_image_srcset( $id, 'full' ) && strpos( wp_get_attachment_image_srcset( $id, 'full' ), wp_get_attachment_url( $id ) ) !== false ) {
				$srcset = str_replace( wp_get_attachment_url( $id ), Kata_Helpers::image_resize( $id, $size ), wp_get_attachment_image_srcset( $id, 'full' ) );
			}
			$allowed_html = array(
				'img'    => array(
				'src'    => array(),
				'srcset' => array(),
				'alt'    => array(),
				'class'    => array(),
				'width'    => array(),
				'height'   => array(),
				),
			);
			if( $permalink && ! is_single() ) {
				echo wp_kses_post( '<a href="' . get_the_permalink() . '">' );
			}
			$srcset = $srcset ? 'srcset=' . esc_attr( $srcset ) . '' : '';
			echo wp_kses( '<img width="' . $size[0] . '" height="' . $size[1] . '" src="' . Kata_Helpers::image_resize( $id, $size ) . '"' . esc_attr( $alt ) . ' class="attachment-post-thumbnail kata-lazyload size-post-thumbnail wp-post-image" ' . esc_attr( $srcset ) . '>', $allowed_html );
			if( $permalink ) {
				echo wp_kses_post( '</a>' );
			}
		}

		/**
		 * Page Thumbnail
		 *
		 * @since   1.0.0
		 */
		public static function posts_time_to_read( $post_id, $post, $update ) {
			if ( ! $update ) {
				return;
			}
			if ( ! get_post_meta( $post_id, 'post_time_to_read', true ) ) {
				$post_content = wp_strip_all_tags( $post->post_content );
				if ( ! $post_content ) {
					return;
				}
				$average = 250;
				$word_length = str_word_count( $post_content );
				if ( $word_length < $average ) {
					$time = 1 . ' ' . __( 'minute', 'kata-business' );
				} elseif ( $word_length > $average ) {
					$time = round( $word_length / $average ) . ' ' . __( 'minutes', 'kata-business' );
				}
				update_post_meta( $post_id, 'post_time_to_read', $time );
			}
		}

		/**
		 * Page Thumbnail
		 *
		 * @since   1.0.0
		 */
		public static function page_thumbnail() {
			if ( has_post_thumbnail() ) {
				echo '<div class="kata-page-thumbnail">';
				Kata_Template_Tags::post_thumbnail();
				echo '</div>';
			}
		}

		/**
		 * Minimum capability.
		 *
		 * @since   1.0.0
		 */
		public static function capability() {
			return 'manage_options';
		}

	} // class

	Kata_Helpers::get_instance();
}
