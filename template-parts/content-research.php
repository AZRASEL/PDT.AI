<?php
/**
 * Template part for displaying single research publication posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

// Get research meta data
$research_authors = get_post_meta( get_the_ID(), '_pdtai_research_authors', true );
$research_journal = get_post_meta( get_the_ID(), '_pdtai_research_journal', true );
$research_date = get_post_meta( get_the_ID(), '_pdtai_research_date', true );
$research_doi = get_post_meta( get_the_ID(), '_pdtai_research_doi', true );
$research_abstract = get_post_meta( get_the_ID(), '_pdtai_research_abstract', true );
$research_citation = get_post_meta( get_the_ID(), '_pdtai_research_citation', true );
$research_link = get_post_meta( get_the_ID(), '_pdtai_research_link', true );

// Get research categories
$research_categories = get_the_terms( get_the_ID(), 'pdtai_research_category' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('research-single'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		
		<div class="research-meta">
			<?php if ( $research_authors ) : ?>
			<div class="research-meta-item research-authors">
				<span class="meta-label"><?php esc_html_e( 'Authors:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value"><?php echo esc_html( $research_authors ); ?></span>
			</div>
			<?php endif; ?>
			
			<?php if ( $research_journal ) : ?>
			<div class="research-meta-item research-journal">
				<span class="meta-label"><?php esc_html_e( 'Journal:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value"><?php echo esc_html( $research_journal ); ?></span>
			</div>
			<?php endif; ?>
			
			<?php if ( $research_date ) : ?>
			<div class="research-meta-item research-date">
				<span class="meta-label"><?php esc_html_e( 'Publication Date:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value"><?php echo esc_html( $research_date ); ?></span>
			</div>
			<?php endif; ?>
			
			<?php if ( $research_doi ) : ?>
			<div class="research-meta-item research-doi">
				<span class="meta-label"><?php esc_html_e( 'DOI:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value">
					<a href="https://doi.org/<?php echo esc_attr( $research_doi ); ?>" target="_blank">
						<?php echo esc_html( $research_doi ); ?>
					</a>
				</span>
			</div>
			<?php endif; ?>
			
			<?php if ( $research_categories && ! is_wp_error( $research_categories ) ) : ?>
			<div class="research-meta-item research-categories">
				<span class="meta-label"><?php esc_html_e( 'Categories:', 'oralcancerpdt' ); ?></span>
				<span class="meta-value">
					<?php
					$category_links = array();
					foreach ( $research_categories as $category ) {
						$category_links[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
					}
					echo implode( ', ', $category_links );
					?>
				</span>
			</div>
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="research-featured-image">
		<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( $research_abstract ) : ?>
		<div class="research-section research-abstract">
			<h2><?php esc_html_e( 'Abstract', 'oralcancerpdt' ); ?></h2>
			<div class="research-abstract-content">
				<?php echo wp_kses_post( wpautop( $research_abstract ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="research-section research-content">
			<h2><?php esc_html_e( 'Research Details', 'oralcancerpdt' ); ?></h2>
			<div class="research-main-content">
				<?php the_content(); ?>
			</div>
		</div>
		
		<?php if ( $research_citation ) : ?>
		<div class="research-section research-citation">
			<h2><?php esc_html_e( 'How to Cite', 'oralcancerpdt' ); ?></h2>
			<div class="research-citation-content">
				<div class="citation-box">
					<?php echo wp_kses_post( wpautop( $research_citation ) ); ?>
					<button class="btn btn-sm btn-outline-primary copy-citation" data-citation="<?php echo esc_attr( $research_citation ); ?>">
						<i class="fa fa-copy"></i> <?php esc_html_e( 'Copy Citation', 'oralcancerpdt' ); ?>
					</button>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if ( $research_link ) : ?>
		<div class="research-section research-link">
			<h2><?php esc_html_e( 'Access the Publication', 'oralcancerpdt' ); ?></h2>
			<div class="research-link-content">
				<a href="<?php echo esc_url( $research_link ); ?>" target="_blank" class="btn btn-primary">
					<i class="fa fa-external-link"></i> <?php esc_html_e( 'View Full Publication', 'oralcancerpdt' ); ?>
				</a>
				
				<?php if ( $research_doi ) : ?>
				<a href="https://doi.org/<?php echo esc_attr( $research_doi ); ?>" target="_blank" class="btn btn-outline-primary">
					<i class="fa fa-link"></i> <?php esc_html_e( 'Access via DOI', 'oralcancerpdt' ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		
		<!-- Research Team -->
		<?php
		// Get team members associated with this research
		$team_args = array(
			'post_type' => 'pdtai_team',
			'posts_per_page' => 4,
			'meta_query' => array(
				array(
					'key' => '_pdtai_team_research',
					'value' => get_the_ID(),
					'compare' => 'LIKE',
				),
			),
		);
		
		$team_members = new WP_Query( $team_args );
		
		if ( $team_members->have_posts() ) :
			?>
			<div class="research-section research-team">
				<h2><?php esc_html_e( 'Research Team', 'oralcancerpdt' ); ?></h2>
				<div class="research-team-list row">
					<?php
					while ( $team_members->have_posts() ) :
						$team_members->the_post();
						$team_position = get_post_meta( get_the_ID(), '_pdtai_team_position', true );
						?>
						<div class="col-md-6 col-lg-3">
							<div class="team-card">
								<div class="team-card-image">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) ); ?>
										</a>
									<?php else : ?>
										<a href="<?php the_permalink(); ?>">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
										</a>
									<?php endif; ?>
								</div>
								<div class="team-card-content">
									<h4 class="team-card-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h4>
									<?php if ( $team_position ) : ?>
									<div class="team-card-position"><?php echo esc_html( $team_position ); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
		end;
		?>
		
		<!-- Related Research -->
		<?php
		// Get related research based on categories
		if ( $research_categories && ! is_wp_error( $research_categories ) ) :
			$category_ids = array();
			foreach ( $research_categories as $category ) {
				$category_ids[] = $category->term_id;
			}
			
			$related_args = array(
				'post_type' => 'pdtai_research',
				'posts_per_page' => 3,
				'post__not_in' => array( get_the_ID() ),
				'tax_query' => array(
					array(
						'taxonomy' => 'pdtai_research_category',
						'field' => 'term_id',
						'terms' => $category_ids,
					),
				),
			);
			
			$related_research = new WP_Query( $related_args );
			
			if ( $related_research->have_posts() ) :
				?>
				<div class="research-section related-research">
					<h2><?php esc_html_e( 'Related Research', 'oralcancerpdt' ); ?></h2>
					<div class="related-research-list row">
						<?php
						while ( $related_research->have_posts() ) :
							$related_research->the_post();
							$rel_research_authors = get_post_meta( get_the_ID(), '_pdtai_research_authors', true );
							$rel_research_journal = get_post_meta( get_the_ID(), '_pdtai_research_journal', true );
							$rel_research_date = get_post_meta( get_the_ID(), '_pdtai_research_date', true );
							?>
							<div class="col-md-4">
								<div class="related-research-item">
									<?php if ( has_post_thumbnail() ) : ?>
									<div class="related-research-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) ); ?>
										</a>
									</div>
									<?php endif; ?>
									<div class="related-research-content">
										<h4 class="related-research-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										<?php if ( $rel_research_authors ) : ?>
										<div class="related-research-authors"><?php echo esc_html( $rel_research_authors ); ?></div>
										<?php endif; ?>
										<?php if ( $rel_research_journal ) : ?>
										<div class="related-research-journal"><?php echo esc_html( $rel_research_journal ); ?></div>
										<?php endif; ?>
										<?php if ( $rel_research_date ) : ?>
										<div class="related-research-date"><?php echo esc_html( $rel_research_date ); ?></div>
										<?php endif; ?>
										<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">
											<?php esc_html_e( 'Read More', 'oralcancerpdt' ); ?>
										</a>
									</div>
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
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->