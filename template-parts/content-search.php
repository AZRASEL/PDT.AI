<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			pdtai_posted_on();
			pdtai_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		<?php if ( 'pdtai_service' === get_post_type() ) : ?>
		<div class="entry-meta service-meta">
			<?php
			// Display service icon if available
			$service_icon = get_post_meta( get_the_ID(), '_pdtai_service_icon', true );
			if ( $service_icon ) :
				echo '<span class="service-icon"><i class="fa ' . esc_attr( $service_icon ) . '"></i></span>';
			endif;
			
			// Display service duration if available
			$service_duration = get_post_meta( get_the_ID(), '_pdtai_service_duration', true );
			if ( $service_duration ) :
				echo '<span class="service-duration"><i class="fa fa-clock-o"></i> ' . esc_html( $service_duration ) . '</span>';
			endif;
			
			// Display service price if available
			$service_price = get_post_meta( get_the_ID(), '_pdtai_service_price', true );
			if ( $service_price ) :
				echo '<span class="service-price"><i class="fa fa-tag"></i> ' . esc_html( $service_price ) . '</span>';
			endif;
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		<?php if ( 'pdtai_research' === get_post_type() ) : ?>
		<div class="entry-meta research-meta">
			<?php
			// Display research authors if available
			$research_authors = get_post_meta( get_the_ID(), '_pdtai_research_authors', true );
			if ( $research_authors ) :
				echo '<span class="research-authors"><i class="fa fa-users"></i> ' . esc_html( $research_authors ) . '</span>';
			endif;
			
			// Display research journal if available
			$research_journal = get_post_meta( get_the_ID(), '_pdtai_research_journal', true );
			if ( $research_journal ) :
				echo '<span class="research-journal"><i class="fa fa-book"></i> ' . esc_html( $research_journal ) . '</span>';
			endif;
			
			// Display research date if available
			$research_date = get_post_meta( get_the_ID(), '_pdtai_research_date', true );
			if ( $research_date ) :
				echo '<span class="research-date"><i class="fa fa-calendar"></i> ' . esc_html( $research_date ) . '</span>';
			endif;
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		<?php if ( 'pdtai_faq' === get_post_type() ) : ?>
		<div class="entry-meta faq-meta">
			<?php
			// Display FAQ categories if available
			$faq_terms = get_the_terms( get_the_ID(), 'pdtai_faq_category' );
			if ( $faq_terms && ! is_wp_error( $faq_terms ) ) :
				echo '<span class="faq-categories"><i class="fa fa-folder-open"></i> ';
				$term_names = array();
				foreach ( $faq_terms as $term ) {
					$term_names[] = $term->name;
				}
				echo esc_html( implode( ', ', $term_names ) );
				echo '</span>';
			endif;
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumbnail search-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'medium' ); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="entry-summary">
		<?php 
		// For services, display the short description if available
		if ( 'pdtai_service' === get_post_type() ) :
			$short_desc = get_post_meta( get_the_ID(), '_pdtai_service_short_desc', true );
			if ( $short_desc ) :
				echo '<p>' . esc_html( $short_desc ) . '</p>';
			else :
				the_excerpt();
			endif;
		// For FAQs, display the short answer if available
		elseif ( 'pdtai_faq' === get_post_type() ) :
			$short_answer = get_post_meta( get_the_ID(), '_pdtai_faq_short_answer', true );
			if ( $short_answer ) :
				echo '<p>' . esc_html( $short_answer ) . '</p>';
			else :
				the_excerpt();
			endif;
		// For research, display the abstract if available
		elseif ( 'pdtai_research' === get_post_type() ) :
			$abstract = get_post_meta( get_the_ID(), '_pdtai_research_abstract', true );
			if ( $abstract ) :
				echo '<p>' . wp_kses_post( wp_trim_words( $abstract, 30, '...' ) ) . '</p>';
			else :
				the_excerpt();
			endif;
		// For everything else, display the regular excerpt
		else :
			the_excerpt();
		endif;
		?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary"><?php esc_html_e( 'Read More', 'oralcancerpdt' ); ?></a>
		<?php pdtai_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->