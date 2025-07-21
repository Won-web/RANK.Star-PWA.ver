<?php
/**
 * The default template for displaying author posts
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
?>

<div class="container">
	<div class="col-sm-12">
		<div class="kata-author-wrapper">
			<div class="kata-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?></div>
			<div class="kata-author-content">
				<h3 class="kata-author-name"> <?php echo esc_html( get_the_author() ); ?> </h3>
				<p class="kata-author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?></p>
			</div>
		</div>
	</div>
</div>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<div class="kata-default-post kata-default-loop loop-two">
			<div class="kata-post-details">
				<div class="post-content-header">
					<div class="row">
						<div class="col-md-4">
							<div class="kata-post-thumbnail">
								<?php Kata_Helpers::image_resize_output( get_post_thumbnail_id(), array( '300', '300' ) ); ?>
							</div>
						</div>
						<div class="col-md-5">
							<div class="kata-post-categories">
								<?php Kata_Template_Tags::post_categories(); ?>
							</div>
							<div class="kata-post-content-wrap">
								<div class="kata-post-title-wrap">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<h2 class="kata-post-title-loop-two"><?php the_title(); ?></h2>
									</a>
								</div>
								<div class="kata-post-excerpt">
									<p><?php echo esc_html( Kata_Template_Tags::excerpt( 15 ) ); ?></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="kata-post-default-meta">
								<div class="kata-post-date-wrap">
									<span><?php echo esc_html__( 'Date:', 'kata-business' ); ?></span>
									<?php Kata_Template_Tags::post_date(); ?>
								</div>
								<div class="kata-post-author-wrap">
									<span><?php echo esc_html__( 'Author:', 'kata-business' ); ?></span>
									<?php Kata_Template_Tags::post_author(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		endwhile;
	endif;
	wp_reset_postdata();
?>

<div class="kata-pagination">
	<?php the_posts_pagination(); ?>
</div>
