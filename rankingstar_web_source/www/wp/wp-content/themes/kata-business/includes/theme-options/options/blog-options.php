<?php
/**
 * Blog Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Theme_Options_Blog' ) ) {
	class Kata_Theme_Options_Blog extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Blog panel
			Kirki::add_panel(
				'kata_blog_panel',
				[
					'title'      => esc_html__( 'Blog', 'kata-business' ),
					'icon'       => 'ti-pencil-alt',
					'type' 		 => 'kirki-nested',
					'capability' => kata_Helpers::capability(),
					'priority'   => 4,
				]
			);
			Kirki::add_panel(
				'kata_blog_and_archive_panel',
				[
					'title'      => esc_html__( 'Blog', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
					'icon' 		 => 'ti-layout-list-post',
					'panel'      => 'kata_blog_panel',
					'priority'   => 4,
				]
			);
			Kirki::add_panel(
				'kata_blog_post_single_panel',
				[
					'title'      => esc_html__( 'Single', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
					'icon' 		 => 'ti-layout-list-post',
					'panel'      => 'kata_blog_panel',
					'priority'   => 4,
				]
			);

			// First Posts
			Kirki::add_section(
				'kata_blog_first_post_section',
				[
					'panel'      => 'kata_blog_and_archive_panel',
					'title'      => esc_html__( 'First Post', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_first_post_section',
					'settings'    => 'kata_blog_first_post_sortable_setting',
					'label'       => esc_html__( 'Post Structure', 'kata-business' ),
					'default'     => [
						'kata_post_thumbnail',
						'kata_post_content',
					],
					'choices'     => [
						'kata_post_thumbnail'		=> esc_html__( 'Thumbnail', 'kata-business' ),
						'kata_post_content'			=> esc_html__( 'Content', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_first_post_section',
					'settings'    => 'kata_blog_first_post_metadata_sortable_setting',
					'label'       => esc_html__( 'Metadata Structure', 'kata-business' ),
					'default'     => [
						'kata_post_date',
						'kata_post_author',
					],
					'choices'     => [
						'kata_post_date'	=> esc_html__( 'Date', 'kata-business' ),
						'kata_post_author' 	=> esc_html__( 'Author', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_blog_first_posts_excerpt_length',
					'section'         => 'kata_blog_first_post_section',
					'label'           => esc_html__('Excerpt length', 'kata-business'),
					'description'     => esc_html__('Sets the post excerpt length size', 'kata-business'),
					'type'            => 'slider',
					'default'         => 15,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				]
			);

			// Posts
			Kirki::add_section(
				'kata_blog_posts_section',
				[
					'panel'      => 'kata_blog_and_archive_panel',
					'title'      => esc_html__( 'Posts', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'select',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_thumbnail_pos',
					'label'       => esc_html__( 'Thumbnail Position', 'kata-business' ),
					'default'     => 'left',
					'choices'     => [
						'left'	=> esc_html__( 'Left', 'kata-business' ),
						'right'	=> esc_html__( 'Right', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_sortable_setting',
					'label'       => esc_html__( 'Post Structure', 'kata-business' ),
					'default'     => [
						'kata_post_categories',
						'kata_post_title',
						'kata_post_post_excerpt',
					],
					'choices'     => [
						'kata_post_categories'		=> esc_html__( 'Category', 'kata-business' ),
						'kata_post_title'			=> esc_html__( 'Title', 'kata-business' ),
						'kata_post_post_excerpt'	=> esc_html__( 'Post Excerpt', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_metadata_sortable_setting',
					'label'       => esc_html__( 'Metadata Structure', 'kata-business' ),
					'default'     => [
						'kata_post_date',
						'kata_post_author',
					],
					'choices'     => [
						'kata_post_date'	=> esc_html__( 'Date', 'kata-business' ),
						'kata_post_author' 	=> esc_html__( 'Author', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_blog_posts_excerpt_length',
					'section'         => 'kata_blog_posts_section',
					'label'           => esc_html__('Excerpt length', 'kata-business'),
					'description'     => esc_html__('Sets the post excerpt length size', 'kata-business'),
					'type'            => 'slider',
					'default'         => 15,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				]
			);

			// Single
			Kirki::add_section(
				'kata_post_single_section',
				[
					'panel'      => 'kata_blog_panel',
					'icon'       => 'ti-pencil-alt',
					'title'      => esc_html__( 'Post Single', 'kata-business' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_thumbnail',
					'label'       => esc_html__( 'Post Thumbnail', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_categories',
					'label'       => esc_html__( 'Post Categories', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_title',
					'label'       => esc_html__( 'Post Title', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_date',
					'label'       => esc_html__( 'Post Date', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_author',
					'label'       => esc_html__( 'Post Author', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_tags',
					'label'       => esc_html__( 'Post Tags', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_socials',
					'label'       => esc_html__( 'Post Socials', 'kata-business' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata-business' ),
						'off' => esc_html__( 'Disable', 'kata-business' ),
					],
					'priority'    => 10,
				]
			);
		}
	} // class

	Kata_Theme_Options_Blog::set_options();
}
