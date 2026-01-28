<?php
/**
 * Template part for displaying single testimonial posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

// Get testimonial meta data
$testimonial_client_name = get_post_meta( get_the_ID(), '_pdtai_testimonial_client_name', true );
$testimonial_client_location = get_post_meta( get_the_ID(), '_pdtai_testimonial_client_location', true );
$testimonial_treatment = get_post_meta( get_the_ID(), '_pdtai_testimonial_treatment', true );
$testimonial_date = get_post_meta( get_the_ID(), '_pdtai_testimonial_date', true );
$testimonial_rating = get_post_meta( get_the_ID(), '_pdtai_testimonial_rating', true );
$testimonial_video = get_post_meta( get_the_ID(), '_pdtai_testimonial_video', true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('testimonial-single'); ?>>
	<div class="testimonial-container">
		<div class="row">
			<div class="col-md-4">
				<div class="testimonial-client-info">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="testimonial-client-image">
						<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
					</div>
					<?php endif; ?>
					
					<div class="testimonial-client-details">
						<?php if ( $testimonial_client_name ) : ?>
						<h3 class="testimonial-client-name"><?php echo esc_html( $testimonial_client_name ); ?></h3>
						<?php else : ?>
						<h3 class="testimonial-client-name"><?php the_title(); ?></h3>
						<?php endif; ?>
						
						<?php if ( $testimonial_client_location ) : ?>
						<div class="testimonial-client-location">
							<i class="fa fa-map-marker"></i> <?php echo esc_html( $testimonial_client_location ); ?>
						</div>
						<?php endif; ?>
						
						<?php if ( $testimonial_treatment ) : ?>
						<div class="testimonial-treatment">
							<strong><?php esc_html_e( 'Treatment:', 'oralcancerpdt' ); ?></strong> <?php echo esc_html( $testimonial_treatment ); ?>
						</div>
						<?php endif; ?>
						
						<?php if ( $testimonial_date ) : ?>
						<div class="testimonial-date">
							<i class="fa fa-calendar"></i> <?php echo esc_html( $testimonial_date ); ?>
						</div>
						<?php endif; ?>
						
						<?php if ( $testimonial_rating ) : ?>
						<div class="testimonial-rating">
							<?php
							// Display star rating
							for ( $i = 1; $i <= 5; $i++ ) {
								if ( $i <= $testimonial_rating ) {
									echo '<i class="fa fa-star"></i>';
								} elseif ( $i - 0.5 <= $testimonial_rating ) {
									echo '<i class="fa fa-star-half-o"></i>';
								} else {
									echo '<i class="fa fa-star-o"></i>';
								}
							}
							?>
							<span class="rating-text"><?php echo esc_html( $testimonial_rating ); ?>/5</span>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<div class="testimonial-content">
					<div class="testimonial-quote">
						<i class="fa fa-quote-left"></i>
						<div class="testimonial-text">
							<?php the_content(); ?>
						</div>
						<i class="fa fa-quote-right"></i>
					</div>
					
					<?php if ( $testimonial_video ) : ?>
					<div class="testimonial-video">
						<h3><?php esc_html_e( 'Video Testimonial', 'oralcancerpdt' ); ?></h3>
						<div class="embed-responsive embed-responsive-16by9">
							<?php echo wp_oembed_get( $testimonial_video ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Before/After Images -->
					<?php
					$gallery_images = get_post_meta( get_the_ID(), '_pdtai_testimonial_gallery', true );
					if ( $gallery_images ) :
						$gallery_array = explode( ',', $gallery_images );
						if ( ! empty( $gallery_array ) ) :
							?>
							<div class="testimonial-gallery">
								<h3><?php esc_html_e( 'Before & After', 'oralcancerpdt' ); ?></h3>
								<div class="row">
									<?php
									foreach ( $gallery_array as $image_id ) :
										$image_url = wp_get_attachment_image_url( $image_id, 'large' );
										$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
										$image_caption = wp_get_attachment_caption( $image_id );
										
										if ( $image_url ) :
											?>
											<div class="col-md-6">
												<div class="testimonial-gallery-item">
													<a href="<?php echo esc_url( $image_url ); ?>" class="gallery-lightbox">
														<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="img-fluid">
													</a>
													<?php if ( $image_caption ) : ?>
													<div class="gallery-caption"><?php echo esc_html( $image_caption ); ?></div>
													<?php endif; ?>
												</div>
											</div>
											<?php
										endif;
									endforeach;
									?>
								</div>
							</div>
							<?php
						endif;
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
	
	<!-- More Testimonials -->
	<?php
	$testimonials_args = array(
		'post_type' => 'pdtai_testimonial',
		'posts_per_page' => 3,
		'post__not_in' => array( get_the_ID() ),
		'orderby' => 'rand',
	);
	
	// If this testimonial has a treatment, try to get related testimonials
	$treatment_filter = false;
	if ( $testimonial_treatment ) {
		$testimonials_args['meta_query'] = array(
			array(
				'key' => '_pdtai_testimonial_treatment',
				'value' => $testimonial_treatment,
				'compare' => 'LIKE',
			),
		);
		$treatment_filter = true;
	}
	
	$more_testimonials = new WP_Query( $testimonials_args );
	
	// If no related testimonials by treatment, get random ones
	if ( $treatment_filter && ! $more_testimonials->have_posts() ) {
		$testimonials_args = array(
			'post_type' => 'pdtai_testimonial',
			'posts_per_page' => 3,
			'post__not_in' => array( get_the_ID() ),
			'orderby' => 'rand',
		);
		$more_testimonials = new WP_Query( $testimonials_args );
	}
	
	if ( $more_testimonials->have_posts() ) :
		?>
		<div class="more-testimonials">
			<h2><?php esc_html_e( 'More Patient Stories', 'oralcancerpdt' ); ?></h2>
			<div class="row">
				<?php
				while ( $more_testimonials->have_posts() ) :
					$more_testimonials->the_post();
					$more_client_name = get_post_meta( get_the_ID(), '_pdtai_testimonial_client_name', true ) ?: get_the_title();
					$more_treatment = get_post_meta( get_the_ID(), '_pdtai_testimonial_treatment', true );
					$more_rating = get_post_meta( get_the_ID(), '_pdtai_testimonial_rating', true );
					?>
					<div class="col-md-4">
						<div class="testimonial-card">
							<?php if ( has_post_thumbnail() ) : ?>
							<div class="testimonial-card-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
								</a>
							</div>
							<?php endif; ?>
							
							<div class="testimonial-card-content">
								<h4 class="testimonial-card-name">
									<a href="<?php the_permalink(); ?>"><?php echo esc_html( $more_client_name ); ?></a>
								</h4>
								
								<?php if ( $more_treatment ) : ?>
								<div class="testimonial-card-treatment"><?php echo esc_html( $more_treatment ); ?></div>
								<?php endif; ?>
								
								<?php if ( $more_rating ) : ?>
								<div class="testimonial-card-rating">
									<?php
									// Display star rating
									for ( $i = 1; $i <= 5; $i++ ) {
										if ( $i <= $more_rating ) {
											echo '<i class="fa fa-star"></i>';
										} elseif ( $i - 0.5 <= $more_rating ) {
											echo '<i class="fa fa-star-half-o"></i>';
										} else {
											echo '<i class="fa fa-star-o"></i>';
										}
									}
									?>
								</div>
								<?php endif; ?>
								
								<div class="testimonial-card-excerpt">
									<?php echo wp_kses_post( wp_trim_words( get_the_content(), 20, '...' ) ); ?>
								</div>
								
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">
									<?php esc_html_e( 'Read Full Story', 'oralcancerpdt' ); ?>
								</a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			
			<div class="text-center mt-4">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'pdtai_testimonial' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'View All Testimonials', 'oralcancerpdt' ); ?>
				</a>
			</div>
		</div>
		<?php
	endif;
	?>
	
	<!-- CTA Section -->
	<div class="testimonial-cta">
		<div class="testimonial-cta-content">
			<h3><?php esc_html_e( 'Ready to Experience PDT Treatment?', 'oralcancerpdt' ); ?></h3>
			<p><?php esc_html_e( 'Join our satisfied patients and discover the benefits of Photodynamic Therapy for yourself.', 'oralcancerpdt' ); ?></p>
		</div>
		<div class="testimonial-cta-buttons">
			<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Book an Appointment', 'oralcancerpdt' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline-primary">
				<?php esc_html_e( 'Contact Us', 'oralcancerpdt' ); ?>
			</a>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->