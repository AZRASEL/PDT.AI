<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package PDT.AI
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<div class="container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'oralcancerpdt' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'oralcancerpdt' ); ?></p>

				<?php get_search_form(); ?>

				<div class="error-suggestions">
					<h2><?php esc_html_e( 'Here are some helpful links:', 'oralcancerpdt' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oralcancerpdt' ); ?></a></li>
						<?php
						// Display links to key pages
						$key_pages = array(
							'about'    => esc_html__( 'About PDT', 'oralcancerpdt' ),
							'services' => esc_html__( 'Our Services', 'oralcancerpdt' ),
							'team'     => esc_html__( 'Our Team', 'oralcancerpdt' ),
							'contact'  => esc_html__( 'Contact Us', 'oralcancerpdt' ),
							'faq'      => esc_html__( 'FAQs', 'oralcancerpdt' ),
						);

						foreach ( $key_pages as $slug => $title ) :
							$page = get_page_by_path( $slug );
							if ( $page ) :
								?>
								<li><a href="<?php echo esc_url( get_permalink( $page->ID ) ); ?>"><?php echo esc_html( $title ); ?></a></li>
								<?php
							endif;
						endforeach;
						?>
					</ul>
				</div>

				<div class="error-image">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 300" width="300" height="180">
						<style>
							.st0{fill:var(--pdt-color-primary-light);}
							.st1{fill:var(--pdt-color-primary);}
							.st2{fill:var(--pdt-color-secondary);}
							.st3{fill:var(--pdt-color-accent);}
						</style>
						<path class="st0" d="M91.2,155.1c0,0-10.5,43.7,27.3,64.8c0,0,48.4,12.1,54.7-36.2c0,0,10.5-53.1-41-53.1
							C132.2,130.6,93.3,124.3,91.2,155.1z"/>
						<path class="st0" d="M329.4,155.1c0,0,10.5,43.7-27.3,64.8c0,0-48.4,12.1-54.7-36.2c0,0-10.5-53.1,41-53.1
							C288.4,130.6,327.3,124.3,329.4,155.1z"/>
						<path class="st1" d="M164.3,81.6c0,0-52.6-5.3-58.9,42c0,0-4.2,42,37.8,49.9c0,0,31.5,6.3,42-21c0,0,6.3-15.8-8.4-15.8
							c0,0-10.5,0-10.5,8.4c0,0,0,10.5,10.5,10.5c0,0-21,21-42-4.2c0,0-21-21-4.2-42c0,0,21-21,42,0c0,0,15.8,10.5,15.8-4.2
							C188.5,105.3,188.5,81.6,164.3,81.6z"/>
						<path class="st1" d="M256.3,81.6c0,0,52.6-5.3,58.9,42c0,0,4.2,42-37.8,49.9c0,0-31.5,6.3-42-21c0,0-6.3-15.8,8.4-15.8
							c0,0,10.5,0,10.5,8.4c0,0,0,10.5-10.5,10.5c0,0,21,21,42-4.2c0,0,21-21,4.2-42c0,0-21-21-42,0c0,0-15.8,10.5-15.8-4.2
							C232.1,105.3,232.1,81.6,256.3,81.6z"/>
						<path class="st2" d="M210.6,219.9c0,0,21,10.5,42,0c0,0,15.8,21,4.2,31.5c0,0-15.8,10.5-25.2,0c0,0-15.8,10.5-25.2,0
							C206.4,251.4,194.8,235.7,210.6,219.9z"/>
						<path class="st3" d="M210.6,219.9c0,0,21-10.5,42,0C252.6,219.9,236.9,235.7,210.6,219.9z"/>
					</svg>
				</div>

			</div><!-- .page-content -->
		</div><!-- .container -->
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();