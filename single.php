<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package PDT.AI
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">

					<?php
					while ( have_posts() ) :
						the_post();

						// Get the post type
						$post_type = get_post_type();

						// Load the appropriate template part based on post type
						if ( 'pdtai_service' === $post_type ) {
							get_template_part( 'template-parts/content', 'service' );
						} elseif ( 'pdtai_team' === $post_type ) {
							get_template_part( 'template-parts/content', 'team' );
						} elseif ( 'pdtai_research' === $post_type ) {
							get_template_part( 'template-parts/content', 'research' );
						} elseif ( 'pdtai_testimonial' === $post_type ) {
							get_template_part( 'template-parts/content', 'testimonial' );
						} elseif ( 'pdtai_faq' === $post_type ) {
							get_template_part( 'template-parts/content', 'faq' );
						} else {
							get_template_part( 'template-parts/content', 'single' );
						}

						// If it's a regular post, show post navigation and comments
						if ( 'post' === $post_type ) :
							the_post_navigation(
								array(
									'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'oralcancerpdt' ) . '</span> <span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'oralcancerpdt' ) . '</span> <span class="nav-title">%title</span>',
								)
							);

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endif;

					endwhile; // End of the loop.
					?>

				</div>
				
				<div class="col-lg-4">
					<?php get_sidebar(); ?>
					
					<?php
					// Display related content based on post type
					$post_type = get_post_type();
					
					// For regular posts, show related posts
					if ( 'post' === $post_type ) :
						$categories = get_the_category();
						if ( $categories ) :
							$category_ids = array();
							foreach ( $categories as $category ) {
								$category_ids[] = $category->term_id;
							}
							
							$related_posts = new WP_Query( array(
								'category__in' => $category_ids,
								'post__not_in' => array( get_the_ID() ),
								'posts_per_page' => 3,
								'orderby' => 'rand',
							) );
							
							if ( $related_posts->have_posts() ) :
								?>
								<div class="related-posts">
									<h3><?php esc_html_e( 'Related Posts', 'oralcancerpdt' ); ?></h3>
									<div class="related-posts-list">
										<?php
										while ( $related_posts->have_posts() ) :
											$related_posts->the_post();
											?>
											<div class="related-post-item">
												<?php if ( has_post_thumbnail() ) : ?>
												<a href="<?php the_permalink(); ?>" class="related-post-thumbnail">
													<?php the_post_thumbnail( 'thumbnail' ); ?>
												</a>
												<?php endif; ?>
												<h4 class="related-post-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h4>
												<div class="related-post-date"><?php echo get_the_date(); ?></div>
											</div>
											<?php
										endwhile;
										wp_reset_postdata();
										?>
									</div>
								</div>
								<?php
							endif;
						endif;
					
					// For services, show related services
					elseif ( 'pdtai_service' === $post_type ) :
						$treatment_types = get_the_terms( get_the_ID(), 'pdtai_treatment_type' );
						if ( $treatment_types && ! is_wp_error( $treatment_types ) ) :
							$treatment_type_ids = array();
							foreach ( $treatment_types as $treatment_type ) {
								$treatment_type_ids[] = $treatment_type->term_id;
							}
							
							$related_services = new WP_Query( array(
								'post_type' => 'pdtai_service',
								'tax_query' => array(
									array(
										'taxonomy' => 'pdtai_treatment_type',
										'field' => 'term_id',
										'terms' => $treatment_type_ids,
									),
								),
								'post__not_in' => array( get_the_ID() ),
								'posts_per_page' => 3,
								'orderby' => 'rand',
							) );
							
							if ( $related_services->have_posts() ) :
								?>
								<div class="related-services">
									<h3><?php esc_html_e( 'Related Services', 'oralcancerpdt' ); ?></h3>
									<div class="related-services-list">
										<?php
										while ( $related_services->have_posts() ) :
											$related_services->the_post();
											?>
											<div class="related-service-item">
												<?php if ( has_post_thumbnail() ) : ?>
												<a href="<?php the_permalink(); ?>" class="related-service-thumbnail">
													<?php the_post_thumbnail( 'thumbnail' ); ?>
												</a>
												<?php endif; ?>
												<h4 class="related-service-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h4>
												<?php
												// Display service short description if available
												$short_desc = get_post_meta( get_the_ID(), '_pdtai_service_short_desc', true );
												if ( $short_desc ) :
													echo '<p class="related-service-desc">' . esc_html( $short_desc ) . '</p>';
												endif;
												?>
											</div>
											<?php
										endwhile;
										wp_reset_postdata();
										?>
									</div>
								</div>
								<?php
							endif;
						endif;
					
					// For research, show related research
					elseif ( 'pdtai_research' === $post_type ) :
						$research_categories = get_the_terms( get_the_ID(), 'pdtai_research_category' );
						if ( $research_categories && ! is_wp_error( $research_categories ) ) :
							$research_category_ids = array();
							foreach ( $research_categories as $research_category ) {
								$research_category_ids[] = $research_category->term_id;
							}
							
							$related_research = new WP_Query( array(
								'post_type' => 'pdtai_research',
								'tax_query' => array(
									array(
										'taxonomy' => 'pdtai_research_category',
										'field' => 'term_id',
										'terms' => $research_category_ids,
									),
								),
								'post__not_in' => array( get_the_ID() ),
								'posts_per_page' => 3,
								'orderby' => 'date',
								'order' => 'DESC',
							) );
							
							if ( $related_research->have_posts() ) :
								?>
								<div class="related-research">
									<h3><?php esc_html_e( 'Related Research', 'oralcancerpdt' ); ?></h3>
									<div class="related-research-list">
										<?php
										while ( $related_research->have_posts() ) :
											$related_research->the_post();
											?>
											<div class="related-research-item">
												<h4 class="related-research-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h4>
												<?php
												// Display research authors if available
												$research_authors = get_post_meta( get_the_ID(), '_pdtai_research_authors', true );
												if ( $research_authors ) :
													echo '<p class="related-research-authors">' . esc_html( $research_authors ) . '</p>';
												endif;
												
												// Display research date if available
												$research_date = get_post_meta( get_the_ID(), '_pdtai_research_date', true );
												if ( $research_date ) :
													echo '<p class="related-research-date">' . esc_html( $research_date ) . '</p>';
												endif;
												?>
											</div>
											<?php
										endwhile;
										wp_reset_postdata();
										?>
									</div>
								</div>
								<?php
							endif;
						endif;
					
					// For FAQs, show related FAQs
					elseif ( 'pdtai_faq' === $post_type ) :
						$faq_categories = get_the_terms( get_the_ID(), 'pdtai_faq_category' );
						if ( $faq_categories && ! is_wp_error( $faq_categories ) ) :
							$faq_category_ids = array();
							foreach ( $faq_categories as $faq_category ) {
								$faq_category_ids[] = $faq_category->term_id;
							}
							
							$related_faqs = new WP_Query( array(
								'post_type' => 'pdtai_faq',
								'tax_query' => array(
									array(
										'taxonomy' => 'pdtai_faq_category',
										'field' => 'term_id',
										'terms' => $faq_category_ids,
									),
								),
								'post__not_in' => array( get_the_ID() ),
								'posts_per_page' => 5,
								'orderby' => 'title',
								'order' => 'ASC',
							) );
							
							if ( $related_faqs->have_posts() ) :
								?>
								<div class="related-faqs">
									<h3><?php esc_html_e( 'Related FAQs', 'oralcancerpdt' ); ?></h3>
									<div class="related-faqs-list">
										<?php
										while ( $related_faqs->have_posts() ) :
											$related_faqs->the_post();
											?>
											<div class="related-faq-item">
												<h4 class="related-faq-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h4>
											</div>
											<?php
										endwhile;
										wp_reset_postdata();
										?>
									</div>
								</div>
								<?php
							endif;
						endif;
					?>
					
					<!-- Booking CTA Widget -->
					<div class="sidebar-booking-cta">
						<h3><?php esc_html_e( 'Book an Appointment', 'oralcancerpdt' ); ?></h3>
						<p><?php esc_html_e( 'Interested in PDT treatment? Schedule a consultation with our specialists.', 'oralcancerpdt' ); ?></p>
						<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-primary btn-block"><?php esc_html_e( 'Book Now', 'oralcancerpdt' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();