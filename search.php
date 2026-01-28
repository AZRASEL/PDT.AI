<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package PDT.AI
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
								<?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'oralcancerpdt' ), '<span>' . get_search_query() . '</span>' );
								?>
							</h1>
						</header><!-- .page-header -->

						<div class="search-filters">
							<form class="search-filter-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="hidden" name="s" value="<?php echo get_search_query(); ?>">
								
								<div class="filter-group">
									<label for="post-type"><?php esc_html_e( 'Filter by:', 'oralcancerpdt' ); ?></label>
									<select name="post_type" id="post-type" class="form-control">
										<option value="any" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'any' ); ?>>
											<?php esc_html_e( 'All Content', 'oralcancerpdt' ); ?>
										</option>
										<option value="post" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'post' ); ?>>
											<?php esc_html_e( 'Blog Posts', 'oralcancerpdt' ); ?>
										</option>
										<option value="page" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'page' ); ?>>
											<?php esc_html_e( 'Pages', 'oralcancerpdt' ); ?>
										</option>
										<option value="pdtai_service" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'pdtai_service' ); ?>>
											<?php esc_html_e( 'Services', 'oralcancerpdt' ); ?>
										</option>
										<option value="pdtai_research" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'pdtai_research' ); ?>>
											<?php esc_html_e( 'Research', 'oralcancerpdt' ); ?>
										</option>
										<option value="pdtai_faq" <?php selected( isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '', 'pdtai_faq' ); ?>>
											<?php esc_html_e( 'FAQs', 'oralcancerpdt' ); ?>
										</option>
									</select>
								</div>
								
								<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Apply Filter', 'oralcancerpdt' ); ?></button>
							</form>
						</div>

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						the_posts_navigation(array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'oralcancerpdt' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'oralcancerpdt' ) . '</span> <span class="nav-title">%title</span>',
						));

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div>
				
				<div class="col-lg-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();