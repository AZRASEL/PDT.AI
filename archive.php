<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<?php
						// Check if we're on a custom post type archive
						$post_type = get_post_type();
						
						// Display custom filters for service archives
						if ( is_post_type_archive( 'pdtai_service' ) ) :
							$treatment_types = get_terms( array(
								'taxonomy' => 'pdtai_treatment_type',
								'hide_empty' => true,
							) );
							
							if ( ! empty( $treatment_types ) && ! is_wp_error( $treatment_types ) ) :
								?>
								<div class="archive-filters service-filters">
									<h3><?php esc_html_e( 'Filter by Treatment Type', 'oralcancerpdt' ); ?></h3>
									<div class="filter-buttons">
										<a href="<?php echo esc_url( get_post_type_archive_link( 'pdtai_service' ) ); ?>" class="btn <?php echo ! isset( $_GET['treatment_type'] ) ? 'btn-primary' : 'btn-outline-primary'; ?>">
											<?php esc_html_e( 'All', 'oralcancerpdt' ); ?>
										</a>
										<?php foreach ( $treatment_types as $type ) : ?>
											<a href="<?php echo esc_url( add_query_arg( 'treatment_type', $type->slug, get_post_type_archive_link( 'pdtai_service' ) ) ); ?>" class="btn <?php echo isset( $_GET['treatment_type'] ) && $_GET['treatment_type'] === $type->slug ? 'btn-primary' : 'btn-outline-primary'; ?>">
												<?php echo esc_html( $type->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
								<?php
							endif;
						
						// Display custom filters for research archives
						elseif ( is_post_type_archive( 'pdtai_research' ) ) :
							$research_categories = get_terms( array(
								'taxonomy' => 'pdtai_research_category',
								'hide_empty' => true,
							) );
							
							if ( ! empty( $research_categories ) && ! is_wp_error( $research_categories ) ) :
								?>
								<div class="archive-filters research-filters">
									<h3><?php esc_html_e( 'Filter by Research Category', 'oralcancerpdt' ); ?></h3>
									<div class="filter-buttons">
										<a href="<?php echo esc_url( get_post_type_archive_link( 'pdtai_research' ) ); ?>" class="btn <?php echo ! isset( $_GET['research_category'] ) ? 'btn-primary' : 'btn-outline-primary'; ?>">
											<?php esc_html_e( 'All', 'oralcancerpdt' ); ?>
										</a>
										<?php foreach ( $research_categories as $category ) : ?>
											<a href="<?php echo esc_url( add_query_arg( 'research_category', $category->slug, get_post_type_archive_link( 'pdtai_research' ) ) ); ?>" class="btn <?php echo isset( $_GET['research_category'] ) && $_GET['research_category'] === $category->slug ? 'btn-primary' : 'btn-outline-primary'; ?>">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
								<?php
							endif;
						
						// Display custom filters for FAQ archives
						elseif ( is_post_type_archive( 'pdtai_faq' ) ) :
							$faq_categories = get_terms( array(
								'taxonomy' => 'pdtai_faq_category',
								'hide_empty' => true,
							) );
							
							if ( ! empty( $faq_categories ) && ! is_wp_error( $faq_categories ) ) :
								?>
								<div class="archive-filters faq-filters">
									<h3><?php esc_html_e( 'Filter by FAQ Category', 'oralcancerpdt' ); ?></h3>
									<div class="filter-buttons">
										<a href="<?php echo esc_url( get_post_type_archive_link( 'pdtai_faq' ) ); ?>" class="btn <?php echo ! isset( $_GET['faq_category'] ) ? 'btn-primary' : 'btn-outline-primary'; ?>">
											<?php esc_html_e( 'All', 'oralcancerpdt' ); ?>
										</a>
										<?php foreach ( $faq_categories as $category ) : ?>
											<a href="<?php echo esc_url( add_query_arg( 'faq_category', $category->slug, get_post_type_archive_link( 'pdtai_faq' ) ) ); ?>" class="btn <?php echo isset( $_GET['faq_category'] ) && $_GET['faq_category'] === $category->slug ? 'btn-primary' : 'btn-outline-primary'; ?>">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
								<?php
							endif;
						endif;
						?>

						<div class="archive-grid">
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile;
							?>
						</div>

						<?php
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