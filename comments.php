<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

/*
 * If the current post is protected by a password and
 * the visitor has not entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$oralcancerpdt_comment_count = get_comments_number();
			if ( '1' === $oralcancerpdt_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'oralcancerpdt' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $oralcancerpdt_comment_count, 'comments title', 'oralcancerpdt' ) ),
					number_format_i18n( $oralcancerpdt_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 60,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'oralcancerpdt' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	// Custom comment form with Bootstrap styling
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$fields = array(
		'author' => '<div class="comment-form-author form-group"><label for="author">' . __( 'Name', 'oralcancerpdt' ) . 
					( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
					'<input id="author" class="form-control" name="author" type="text" value="' . 
					esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div>',
		'email'  => '<div class="comment-form-email form-group"><label for="email">' . __( 'Email', 'oralcancerpdt' ) . 
					( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
					'<input id="email" class="form-control" name="email" type="email" value="' . 
					esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div>',
		'url'    => '<div class="comment-form-url form-group"><label for="url">' . __( 'Website', 'oralcancerpdt' ) . '</label>' .
					'<input id="url" class="form-control" name="url" type="url" value="' . 
					esc_attr( $commenter['comment_author_url'] ) . '" /></div>',
		'cookies' => '<div class="comment-form-cookies-consent form-group"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
					'<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'oralcancerpdt' ) . '</label></div>',
	);

	$comments_args = array(
		'fields'               => $fields,
		'comment_field'        => '<div class="comment-form-comment form-group"><label for="comment">' . _x( 'Comment', 'noun', 'oralcancerpdt' ) . 
								' <span class="required">*</span></label><textarea id="comment" class="form-control" name="comment" rows="5" aria-required="true"></textarea></div>',
		'class_form'          => 'comment-form needs-validation',
		'class_submit'        => 'submit btn btn-primary',
		'title_reply'         => __( 'Leave a Comment', 'oralcancerpdt' ),
		'title_reply_to'      => __( 'Leave a Reply to %s', 'oralcancerpdt' ),
		'cancel_reply_link'   => __( 'Cancel Reply', 'oralcancerpdt' ),
		'label_submit'        => __( 'Post Comment', 'oralcancerpdt' ),
		'format'              => 'html5',
	);

	comment_form( $comments_args );
	?>

</div><!-- #comments -->