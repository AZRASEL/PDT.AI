<?php
/**
 * Template part for displaying single service posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

// Get service meta data
$service_icon = get_post_meta( get_the_ID(), '_pdtai_service_icon', true );
$service_short_desc = get_post_meta( get_the_ID(), '_pdtai_service_short_desc', true );
$service_duration = get_post_meta( get_the_ID(), '_pdtai_service_duration', true );
$service_price = get_post_meta( get_the_ID(), '_pdtai_service_price', true );
$service_benefits = get_post_meta( get_the_ID(), '_pdtai_service_benefits', true );
$service_procedure = get_post_meta( get_the_ID(), '_pdtai_service_procedure', true );
$service_aftercare = get_post_meta( get_the_ID(), '_pdtai_service_aftercare', true );
$service_faq = get_post_meta( get_the_ID(), '_pdtai_service_faq', true );

// Get treatment types
$treatment_types = get_the_terms( get_the_ID(), 'pdtai_treatment_type' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('service-single'); ?>>
	<header class="entry-header">
		<div class="service-header-content">
			<?php if ( $service_icon ) : ?>
			<div class="service-icon">
				<i class="fa <?php echo esc_attr( $service_icon ); ?>"></i>
			</div>
			<?php endif; ?>
			
			<div class="service-title-wrap">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				
				<?php if ( $treatment_types && ! is_wp_error( $treatment_types ) ) : ?>
				<div class="service-categories">
					<?php foreach ( $treatment_types as $type ) : ?>
					<span class="service-category"><?php echo esc_html( $type->name ); ?></span>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
		<?php if ( $service_short_desc ) : ?>
		<div class="service-short-description">
			<?php echo wp_kses_post( wpautop( $service_short_desc ) ); ?>
		</div>
		<?php endif; ?>
		
		<div class="service-meta">
			<?php if ( $service_duration ) : ?>
			<div class="service-meta-item service-duration">
				<i class="fa fa-clock-o"></i>
				<span class="meta-label"><?php esc_html_e( 'Duration:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value"><?php echo esc_html( $service_duration ); ?></span>
			</div>
			<?php endif; ?>
			
			<?php if ( $service_price ) : ?>
			<div class="service-meta-item service-price">
				<i class="fa fa-tag"></i>
				<span class="meta-label"><?php esc_html_e( 'Price:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value"><?php echo esc_html( $service_price ); ?></span>
			</div>
			<?php endif; ?>
			
			<div class="service-meta-item service-booking">
				<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-primary">
					<i class="fa fa-calendar"></i> <?php esc_html_e( 'Book Now', 'oralcancerpdt' ); ?>
				</a>
			</div>
		</div>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="service-featured-image">
		<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content">
		<div class="service-main-content">
			<?php the_content(); ?>
		</div>
		
		<?php if ( $service_benefits ) : ?>
		<div class="service-section service-benefits">
			<h2><?php esc_html_e( 'Benefits', 'oralcancerpdt' ); ?></h2>
			<div class="service-benefits-content">
				<?php echo wp_kses_post( wpautop( $service_benefits ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if ( $service_procedure ) : ?>
		<div class="service-section service-procedure">
			<h2><?php esc_html_e( 'Procedure', 'oralcancerpdt' ); ?></h2>
			<div class="service-procedure-content">
				<?php echo wp_kses_post( wpautop( $service_procedure ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if ( $service_aftercare ) : ?>
		<div class="service-section service-aftercare">
			<h2><?php esc_html_e( 'Aftercare', 'oralcancerpdt' ); ?></h2>
			<div class="service-aftercare-content">
				<?php echo wp_kses_post( wpautop( $service_aftercare ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if ( $service_faq ) : ?>
		<div class="service-section service-faq">
			<h2><?php esc_html_e( 'Frequently Asked Questions', 'oralcancerpdt' ); ?></h2>
			<div class="service-faq-content">
				<?php echo wp_kses_post( wpautop( $service_faq ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<!-- Service CTA -->
		<div class="service-cta">
			<div class="service-cta-content">
				<h3><?php esc_html_e( 'Ready to Schedule Your Treatment?', 'oralcancerpdt' ); ?></h3>
				<p><?php esc_html_e( 'Our specialists are ready to help you with your PDT treatment journey.', 'oralcancerpdt' ); ?></p>
			</div>
			<div class="service-cta-buttons">
				<a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Book an Appointment', 'oralcancerpdt' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline-primary">
					<?php esc_html_e( 'Contact Us', 'oralcancerpdt' ); ?>
				</a>
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->