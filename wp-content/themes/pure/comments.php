<?php
/**
 * Pure Framework.
 *
 * WARNING: This is part of the Pure Framework. DO NOT EDIT this file under any circumstances.
 * Please do all your modifications in a child theme.
 *
 * @package Pure
 * @author  Boong
 * @link    https://boongstudio.com/themes/pure
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'pure' ); ?></p>
<?php endif; ?>

<div id="comments" class="comments-area">

	<?php pure_tag( array(
		'context' => 'comments-header',
		'open'    => '<div %s>',
	) );

	pure_tag( array(
		'context' => 'comments-title',
		'open'    => '<h2 %s>',
		'close'   => '</h2>',
		'content' => esc_html__( 'Comments', 'pure' ),
	) );
	pure_tag( array(
		'context' => 'comments-number',
		'open'    => '<span %s>',
		'close'   => '</span>',
		'content' => sprintf( __( '%d comments', 'pure' ), get_comments_number() ),
	) );

	pure_tag( array(
		'context' => 'comments-header',
		'close'   => '</div>',
	) );

	comment_form(); ?>

	<?php if ( have_comments() ) : ?>
		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => 69,
				'callback'   => 'pure_comment',
			) );
			?>
		</ul><!-- .comment-list -->

		<?php the_comments_pagination(); ?>

	<?php endif; // have_comments() ?>

</div><!-- .comments-area -->
