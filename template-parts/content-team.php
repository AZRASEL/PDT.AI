<?php
/**
 * Template part for displaying single team member posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

// Get team member meta data
$team_position = get_post_meta( get_the_ID(), '_pdtai_team_position', true );
$team_specialty = get_post_meta( get_the_ID(), '_pdtai_team_specialty', true );
$team_education = get_post_meta( get_the_ID(), '_pdtai_team_education', true );
$team_experience = get_post_meta( get_the_ID(), '_pdtai_team_experience', true );
$team_research = get_post_meta( get_the_ID(), '_pdtai_team_research', true );
$team_email = get_post_meta( get_the_ID(), '_pdtai_team_email', true );
$team_phone = get_post_meta( get_the_ID(), '_pdtai_team_phone', true );
$team_social = get_post_meta( get_the_ID(), '_pdtai_team_social', true );

// Get team roles
$team_roles = get_the_terms( get_the_ID(), 'pdtai_team_role' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('team-single'); ?>>
	<div class="team-profile">
		<div class="row">
			<div class="col-md-4">
				<div class="team-profile-image">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
					<?php endif; ?>
				</div>
				
				<div class="team-contact-info">
					<h3><?php esc_html_e( 'Contact Information', 'oralcancerpdt' ); ?></h3>
					
					<?php if ( $team_email ) : ?>
					<div class="team-contact-item team-email">
						<i class="fa fa-envelope"></i>
						<a href="mailto:<?php echo esc_attr( $team_email ); ?>"><?php echo esc_html( $team_email ); ?></a>
					</div>
					<?php endif; ?>
					
					<?php if ( $team_phone ) : ?>
					<div class="team-contact-item team-phone">
						<i class="fa fa-phone"></i>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $team_phone ) ); ?>"><?php echo esc_html( $team_phone ); ?></a>
					</div>
					<?php endif; ?>
					
					<?php if ( $team_social ) : ?>
					<div class="team-social-links">
						<?php
						$social_links = explode( '\n', $team_social );
						foreach ( $social_links as $link ) :
							$parts = explode( '|', $link );
							if ( count( $parts ) === 2 ) :
								$platform = trim( $parts[0] );
								$url = trim( $parts[1] );
								$icon = '';
								
								switch ( strtolower( $platform ) ) :
									case 'facebook':
										$icon = 'fa-facebook';
										break;
									case 'twitter':
										$icon = 'fa-twitter';
										break;
									case 'linkedin':
										$icon = 'fa-linkedin';
										break;
									case 'instagram':
										$icon = 'fa-instagram';
										break;
									case 'researchgate':
										$icon = 'fa-flask';
										break;
									case 'google scholar':
										$icon = 'fa-graduation-cap';
										break;
									default:
										$icon = 'fa-link';
								endswitch;
								?>
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" class="team-social-link">
									<i class="fa <?php echo esc_attr( $icon ); ?>"></i> <?php echo esc_html( $platform ); ?>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
					
					<div class="team-appointment-cta">
						<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-primary btn-block">
							<?php esc_html_e( 'Book an Appointment', 'oralcancerpdt' ); ?>
						</a>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					
					<div class="team-meta">
						<?php if ( $team_position ) : ?>
						<div class="team-position"><?php echo esc_html( $team_position ); ?></div>
						<?php endif; ?>
						
						<?php if ( $team_roles && ! is_wp_error( $team_roles ) ) : ?>
						<div class="team-roles">
							<?php
							$role_names = array();
							foreach ( $team_roles as $role ) {
								$role_names[] = $role->name;
							}
							echo esc_html( implode( ', ', $role_names ) );
							?>
						</div>
						<?php endif; ?>
						
						<?php if ( $team_specialty ) : ?>
						<div class="team-specialty">
							<span class="specialty-label"><?php esc_html_e( 'Specialty:', 'oralcancerpdt' ); ?></span>
							<span class="specialty-value"><?php echo esc_html( $team_specialty ); ?></span>
						</div>
						<?php endif; ?>
					</div>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<div class="team-bio">
						<?php the_content(); ?>
					</div>
					
					<?php if ( $team_education ) : ?>
					<div class="team-section team-education">
						<h3><?php esc_html_e( 'Education', 'oralcancerpdt' ); ?></h3>
						<div class="team-education-content">
							<?php echo wp_kses_post( wpautop( $team_education ) ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<?php if ( $team_experience ) : ?>
					<div class="team-section team-experience">
						<h3><?php esc_html_e( 'Professional Experience', 'oralcancerpdt' ); ?></h3>
						<div class="team-experience-content">
							<?php echo wp_kses_post( wpautop( $team_experience ) ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<?php if ( $team_research ) : ?>
					<div class="team-section team-research">
						<h3><?php esc_html_e( 'Research & Publications', 'oralcancerpdt' ); ?></h3>
						<div class="team-research-content">
							<?php echo wp_kses_post( wpautop( $team_research ) ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<?php
					// Get services provided by this team member
					$services_args = array(
						'post_type' => 'pdtai_service',
						'posts_per_page' => 4,
						'meta_query' => array(
							array(
								'key' => '_pdtai_service_team_members',
								'value' => get_the_ID(),
								'compare' => 'LIKE',
							),
						),
					);
					
					$services = new WP_Query( $services_args );
					
					if ( $services->have_posts() ) :
						?>
						<div class="team-section team-services">
							<h3><?php esc_html_e( 'Services Provided', 'oralcancerpdt' ); ?></h3>
							<div class="team-services-list row">
								<?php
								while ( $services->have_posts() ) :
									$services->the_post();
									$service_icon = get_post_meta( get_the_ID(), '_pdtai_service_icon', true );
									$service_short_desc = get_post_meta( get_the_ID(), '_pdtai_service_short_desc', true );
									?>
									<div class="col-md-6">
										<div class="team-service-item">
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
												<?php echo wp_kses_post( wpautop( $service_short_desc ) ); ?>
											</div>
											<?php endif; ?>
										</div>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</div>
							
							<?php if ( $services->found_posts > 4 ) : ?>
							<div class="team-services-more">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'pdtai_service' ) ); ?>" class="btn btn-outline-primary">
									<?php esc_html_e( 'View All Services', 'oralcancerpdt' ); ?>
								</a>
							</div>
							<?php endif; ?>
						</div>
						<?php
					endif;
					?>
				</div><!-- .entry-content -->
			</div>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->