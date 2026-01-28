<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				pdtai_posted_on();
				pdtai_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumbnail">
		<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content(
			spprintf(
				/* translators: %s: Name of current post. Only visible to screen readers */
				wp_kses_post( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'oralcancerpdt' ) ),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oralcancerpdt' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php pdtai_entry_footer(); ?>
		
		<!-- Social Sharing -->
		<div class="social-sharing">
			<h4><?php esc_html_e( 'Share This Post', 'oralcancerpdt' ); ?></h4>
			<div class="social-sharing-buttons">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" class="social-share facebook">
					<i class="fa fa-facebook"></i> <?php esc_html_e( 'Facebook', 'oralcancerpdt' ); ?>
				</a>
				<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" class="social-share twitter">
					<i class="fa fa-twitter"></i> <?php esc_html_e( 'Twitter', 'oralcancerpdt' ); ?>
				</a>
				<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" class="social-share linkedin">
					<i class="fa fa-linkedin"></i> <?php esc_html_e( 'LinkedIn', 'oralcancerpdt' ); ?>
				</a>
				<a href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&body=<?php echo esc_url( get_permalink() ); ?>" class="social-share email">
					<i class="fa fa-envelope"></i> <?php esc_html_e( 'Email', 'oralcancerpdt' ); ?>
				</a>
			</div>
		</div>
		
		<!-- Author Bio -->
		<div class="author-bio">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
			</div>
			<div class="author-info">
				<h4 class="author-name"><?php the_author(); ?></h4>
				<p class="author-description">
					<?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?>
				</p>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-link">
					<?php
					/* translators: %s: Author name */
					printf( esc_html__( 'View all posts by %s', 'oralcancerpdt' ), get_the_author() );
					?>
				</a>
			</div>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->