<?php
/**
 * Template part for displaying single FAQ posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

// Get FAQ meta data
$faq_short_answer = get_post_meta( get_the_ID(), '_pdtai_faq_short_answer', true );
$faq_related_services = get_post_meta( get_the_ID(), '_pdtai_faq_related_services', true );

// Get FAQ categories
$faq_categories = get_the_terms( get_the_ID(), 'pdtai_faq_category' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('faq-single'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		
		<?php if ( $faq_categories && ! is_wp_error( $faq_categories ) ) : ?>
		<div class="faq-categories">
			<?php
			$category_links = array();
			foreach ( $faq_categories as $category ) {
				$category_links[] = '<a href="' . esc_url( get_term_link( $category ) ) . '" class="faq-category">' . esc_html( $category->name ) . '</a>';
			}
			echo implode( ', ', $category_links );
			?>
		</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="faq-featured-image">
		<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( $faq_short_answer ) : ?>
		<div class="faq-short-answer">
			<h3><?php esc_html_e( 'Short Answer', 'oralcancerpdt' ); ?></h3>
			<div class="short-answer-content">
				<?php echo wp_kses_post( wpautop( $faq_short_answer ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="faq-detailed-answer">
			<h3><?php esc_html_e( 'Detailed Answer', 'oralcancerpdt' ); ?></h3>
			<div class="detailed-answer-content">
				<?php the_content(); ?>
			</div>
		</div>
		
		<?php
		// Display related services if available
		if ( $faq_related_services ) :
			$service_ids = explode( ',', $faq_related_services );
			if ( ! empty( $service_ids ) ) :
				$services_args = array(
					'post_type' => 'pdtai_service',
					'post__in' => $service_ids,
					'posts_per_page' => -1,
					'orderby' => 'post__in',
				);
				
				$related_services = new WP_Query( $services_args );
				
				if ( $related_services->have_posts() ) :
					?>
					<div class="faq-related-services">
						<h3><?php esc_html_e( 'Related Services', 'oralcancerpdt' ); ?></h3>
						<div class="related-services-list row">
							<?php
							while ( $related_services->have_posts() ) :
								$related_services->the_post();
								$service_icon = get_post_meta( get_the_ID(), '_pdtai_service_icon', true );
								$service_short_desc = get_post_meta( get_the_ID(), '_pdtai_service_short_desc', true );
								?>
								<div class="col-md-4">
									<div class="related-service-item">
										<?php if ( $service_icon ) : ?>
										<div class="service-icon">
											<i class="fa <?php echo esc_attr( $service_icon ); ?>"></i>
										</div>
										<?php endif; ?>
										
										<h4 class="service-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										
										<?php if ( $service_short_desc ) : ?>
										<div class="service-desc">
											<?php echo wp_kses_post( wp_trim_words( $service_short_desc, 15, '...' ) ); ?>
										</div>
										<?php endif; ?>
										
										<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">
											<?php esc_html_e( 'Learn More', 'oralcancerpdt' ); ?>
										</a>
									</div>
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
		endif;
		?>
		
		<!-- Related FAQs -->
		<?php
		// Get related FAQs based on categories
		if ( $faq_categories && ! is_wp_error( $faq_categories ) ) :
			$category_ids = array();
			foreach ( $faq_categories as $category ) {
				$category_ids[] = $category->term_id;
			}
			
			$related_args = array(
				'post_type' => 'pdtai_faq',
				'posts_per_page' => 5,
				'post__not_in' => array( get_the_ID() ),
				'tax_query' => array(
					array(
						'taxonomy' => 'pdtai_faq_category',
						'field' => 'term_id',
						'terms' => $category_ids,
					),
				),
			);
			
			$related_faqs = new WP_Query( $related_args );
			
			if ( $related_faqs->have_posts() ) :
				?>
				<div class="faq-related-questions">
					<h3><?php esc_html_e( 'Related Questions', 'oralcancerpdt' ); ?></h3>
					<div class="related-questions-list">
						<div class="accordion" id="relatedFaqAccordion">
							<?php
							$counter = 1;
							while ( $related_faqs->have_posts() ) :
								$related_faqs->the_post();
								$rel_faq_short_answer = get_post_meta( get_the_ID(), '_pdtai_faq_short_answer', true );
								?>
								<div class="card">
									<div class="card-header" id="relatedFaqHeading<?php echo esc_attr( $counter ); ?>">
										<h5 class="mb-0">
											<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#relatedFaqCollapse<?php echo esc_attr( $counter ); ?>" aria-expanded="false" aria-controls="relatedFaqCollapse<?php echo esc_attr( $counter ); ?>">
												<?php the_title(); ?>
												<i class="fa fa-chevron-down"></i>
											</button>
										</h5>
									</div>
									<div id="relatedFaqCollapse<?php echo esc_attr( $counter ); ?>" class="collapse" aria-labelledby="relatedFaqHeading<?php echo esc_attr( $counter ); ?>" data-parent="#relatedFaqAccordion">
										<div class="card-body">
											<?php
											if ( $rel_faq_short_answer ) {
												echo wp_kses_post( wpautop( $rel_faq_short_answer ) );
											} else {
												the_excerpt();
											}
											?>
											<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">
												<?php esc_html_e( 'Read Full Answer', 'oralcancerpdt' ); ?>
											</a>
										</div>
									</div>
								</div>
								<?php
								$counter++;
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
				</div>
				<?php
			endif;
		endif;
		?>
		
		<!-- FAQ CTA -->
		<div class="faq-cta">
			<div class="faq-cta-content">
				<h3><?php esc_html_e( 'Still Have Questions?', 'oralcancerpdt' ); ?></h3>
				<p><?php esc_html_e( 'Our team is here to help you understand PDT treatment and answer any questions you may have.', 'oralcancerpdt' ); ?></p>
			</div>
			<div class="faq-cta-buttons">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Contact Us', 'oralcancerpdt' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-outline-primary">
					<?php esc_html_e( 'Book a Consultation', 'oralcancerpdt' ); ?>
				</a>
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->