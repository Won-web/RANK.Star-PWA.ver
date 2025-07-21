<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( is_active_sidebar( 'kata-left-sidebar' ) && is_active_sidebar( 'kata-right-sidebar' ) ) {
	$kata_content_class = 'col-lg-6';
} elseif ( is_active_sidebar( 'kata-left-sidebar' ) || is_active_sidebar( 'kata-right-sidebar' ) ) {
	$kata_content_class = 'col-lg-9';
} else {
	$kata_content_class = 'col-md-12';
}

$posts_sort_thumb_pos		= get_theme_mod( 'kata_blog_posts_thumbnail_pos', 'left' );
$posts_sort					= get_theme_mod( 'kata_blog_posts_sortable_setting', ['kata_post_categories', 'kata_post_title', 'kata_post_post_excerpt'] );
$posts_meta_sort			= get_theme_mod( 'kata_blog_posts_metadata_sortable_setting', ['kata_post_date', 'kata_post_author'] );
$posts_excerpt_length		= get_theme_mod( 'kata_blog_posts_excerpt_length', 15 );
$first_post_sort			= get_theme_mod( 'kata_blog_first_post_sortable_setting', ['kata_post_thumbnail', 'kata_post_content'] );
$first_post_meta_sort		= get_theme_mod( 'kata_blog_first_post_metadata_sortable_setting', ['kata_post_date', 'kata_post_author'] );
$fist_post_excerpt_length	= get_theme_mod( 'kata_blog_first_posts_excerpt_length', 15 ); ?>

<div class="container">
	<div class="row">
		<?php if ( is_active_sidebar( 'kata-left-sidebar' ) ) { ?>
			<div class="col-lg-3 kata-sidebar kata-left-sidebar" role="complementary">
				<?php dynamic_sidebar( 'kata-left-sidebar' ); ?>
			</div>
		<?php } ?>
		<div class="kata-default-loop-content <?php echo esc_attr( $kata_content_class ); ?>" role="main">
			<?php
			if ( have_posts() ) :
				$kata_post_count = 0;
				while ( have_posts() ) :
					the_post();
					$kata_post_count++;
					if ( 1 === $kata_post_count ) :
						?>
						<div <?php post_class( 'kata-default-post kata-default-loop' ); ?>>
							<div class="kata-post-details">
								<div class="post-content-header">
									<?php
									if ( ! empty( $first_post_sort ) ) {
										foreach ( $first_post_sort as $item ) {
											switch ( $item ) {
												case 'kata_post_thumbnail':
													?>
													<div class="row">
														<div class="col-md-12">
															<div class="kata-post-thumbnail">
																<?php Kata_Template_Tags::post_thumbnail(); ?>
															</div>
														</div>
													</div>
													<?php
												break;
												case 'kata_post_content':
													?>
													<div class="row">
														<?php $col_class = ! empty( $first_post_meta_sort ) ? 'col-md-8' : 'col-md-12'; ?>
														<div class="<?php echo esc_attr( $col_class ); ?>">
															<div class="kata-post-categories">
																<?php Kata_Template_Tags::post_categories(); ?>
															</div>
															<?php if ( 'status' !== get_post_format() ) : ?>
																<div class="kata-post-title-wrap">
																	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
																		<h2 class="kata-post-title"><?php the_title(); ?></h2>
																	</a>
																</div>
															<?php endif; ?>
														</div>
														<?php if ( ! empty( $first_post_meta_sort ) ) { ?>
															<div class="col-md-4">
																<div class="kata-post-default-meta">
																	<?php
																	foreach ( $first_post_meta_sort as $item ) {
																		switch ( $item ) {
																			case 'kata_post_date':
																				?>
																				<div class="kata-post-date-wrap">
																					<span><?php echo esc_html__( 'Date:', 'kata-business' ); ?></span>
																					<?php Kata_Template_Tags::post_date(); ?>
																				</div>
																				<?php
																			break;
																			case 'kata_post_author':
																				?>
																				<div class="kata-post-author-wrap">
																					<span><?php echo esc_html__( 'Author:', 'kata-business' ); ?></span>
																					<?php Kata_Template_Tags::post_author(); ?>
																				</div>
																				<?php
																			break;
																		}
																	}
																	?>
																</div>
															</div>
														<?php } ?>
													</div>
													<?php
												break;
											}
										}
									}
									?>
								</div>
							</div>
						</div>
					<?php else : ?>
						<div <?php post_class( 'kata-default-post kata-default-loop loop-two' ); ?>>
							<div class="kata-post-details">
								<div class="post-content-header">
									<div class="row">
										<?php
										if ( 'left' == $posts_sort_thumb_pos ) {
											if ( has_post_thumbnail() ) {
												?>
												<div class="col-md-4">
													<div class="kata-post-thumbnail">
														<?php Kata_Helpers::image_resize_output( get_post_thumbnail_id(), array( '300', '300' ) ); ?>
													</div>
												</div>
												<?php
											}
										}

										$kata_content_class = has_post_thumbnail() ? 'col-md-5' : 'col-md-8';
										$kata_content_class = 'col-md-5' == $kata_content_class && empty( $posts_meta_sort ) ? 'col-md-8' : 'col-md-5';
										?>
										<?php if ( 'right' == $posts_sort_thumb_pos && ! empty( $posts_meta_sort ) ) { ?>
											<div class="col-md-3">
												<div class="kata-post-default-meta">
													<?php
													foreach ( $posts_meta_sort as $meta ) {
														switch ($meta) {
															case 'kata_post_date':
																?>
																<div class="kata-post-date-wrap">
																	<span><?php echo esc_html__( 'Date:', 'kata-business' ); ?></span>
																	<?php Kata_Template_Tags::post_date(); ?>
																</div>
																<?php
															break;
															case 'kata_post_author':
																?>
																<div class="kata-post-author-wrap">
																	<span><?php echo esc_html__( 'Author:', 'kata-business' ); ?></span>
																	<?php Kata_Template_Tags::post_author(); ?>
																</div>
																<?php
															break;
														}
													}
													?>
												</div>
											</div>
										<?php } ?>
										<?php if ( ! empty( $posts_sort ) ) { ?>
											<div class="<?php echo esc_attr( $kata_content_class ); ?>">
												<div class="kata-post-content-wrap">
													<?php
														foreach ( $posts_sort as $item ) {
															switch ($item) {
																case 'kata_post_categories':
																	?>
																	<div class="kata-post-categories">
																		<?php Kata_Template_Tags::post_categories(); ?>
																	</div>
																	<?php
																break;
																case 'kata_post_title':
																	if ( 'status' !== get_post_format() ) :
																		?>
																		<div class="kata-post-title-wrap">
																			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
																				<h2 class="kata-post-title-loop-two"><?php the_title(); ?></h2>
																			</a>
																		</div>
																		<?php
																	endif;
																break;
																case 'kata_post_post_excerpt':
																	?>
																	<div class="kata-post-excerpt">
																		<p><?php echo esc_html( Kata_Template_Tags::excerpt( $posts_excerpt_length ) ); ?></p>
																		<a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Continue reading', 'kata-business' ) ?></a>
																	</div>
																	<?php
																break;
															}
														}
													?>
												</div>
											</div>
										<?php } ?>
										<?php if ( 'left' == $posts_sort_thumb_pos && ! empty( $posts_meta_sort ) ) { ?>
											<div class="col-md-3">
												<div class="kata-post-default-meta">
													<?php
													foreach ( $posts_meta_sort as $meta ) {
														switch ($meta) {
															case 'kata_post_date':
																?>
																<div class="kata-post-date-wrap">
																	<span><?php echo esc_html__( 'Date:', 'kata-business' ); ?></span>
																	<?php Kata_Template_Tags::post_date(); ?>
																</div>
																<?php
															break;
															case 'kata_post_author':
																?>
																<div class="kata-post-author-wrap">
																	<span><?php echo esc_html__( 'Author:', 'kata-business' ); ?></span>
																	<?php Kata_Template_Tags::post_author(); ?>
																</div>
																<?php
															break;
														}
													}
													?>
												</div>
											</div>
										<?php }
										if ( 'right' == $posts_sort_thumb_pos ) {
											if ( has_post_thumbnail() ) {
												?>
												<div class="col-md-4">
													<div class="kata-post-thumbnail">
														<?php Kata_Helpers::image_resize_output( get_post_thumbnail_id(), array( '300', '300' ) ); ?>
													</div>
												</div>
												<?php
											}
										} ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php
				endwhile;
			endif;
			wp_reset_postdata();
			?>
			<div class="kata-pagination">
				<?php the_posts_pagination(); ?>
			</div>
		</div>
		<?php if ( is_active_sidebar( 'kata-right-sidebar' ) ) { ?>
			<div class="col-lg-3 kata-sidebar kata-right-sidebar" role="complementary">
				<?php dynamic_sidebar( 'kata-right-sidebar' ); ?>
			</div>
		<?php } ?>
	</div>
</div>
