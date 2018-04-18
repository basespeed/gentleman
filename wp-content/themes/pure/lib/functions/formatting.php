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

/**
 * Remove p tag from content.
 *
 * @param  string $content Content to strip. Maybe contain p tags.
 *
 * @return string Content without p tags.
 */
function pure_strip_p_tags( $content ) {

	return preg_replace( '/<p\b[^>]*>(.*?)<\/p>/i', '$1', $content );
}

add_filter( 'excerpt_more', 'pure_excerpt_more' );
/**
 * Change excerpt more.
 */
function pure_excerpt_more( $more ) {

	return '...';
}

add_filter( 'get_the_excerpt', 'pure_excerpt' );
/**
 * Safe excerpt trim. Allow adjust length of excerpt by filter.
 *
 * @param $excerpt
 *
 * @return string
 */
function pure_excerpt( $excerpt ) {

	$length = apply_filters( 'pure_excerpt_length', 20 );

	return wp_trim_words( $excerpt, $length );
}

/**
 * Custom comment display.
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function pure_comment( $comment, $args, $depth ) {

	if ( 'div' === $args[ 'style' ] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	} ?>
    <<?php echo $tag . ' ';
	comment_class( empty( $args[ 'has_children' ] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php
	if ( 'div' != $args[ 'style' ] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
    <div class="comment-author vcard"><?php
	if ( $args[ 'avatar_size' ] != 0 ) {
		echo get_avatar( $comment, $args[ 'avatar_size' ] );
	}
	printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
    </div><?php
	if ( $comment->comment_approved == '0' ) { ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'pure' ); ?></em>
        <br/><?php
	} ?>

	<?php comment_text(); ?>

    <div class="comment-meta commentmetadata">
        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
			printf(
				__( '<i class="%3$s"></i> %1$s, %2$s', 'pure' ),
				get_comment_time(),
				get_comment_date(),
				'far fa-clock'
			); ?>
        </a><?php
		edit_comment_link( __( 'Edit', 'pure' ), '  ', '' ); ?>
        <div class="reply"><?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below'  => $add_below,
						'depth'      => $depth,
						'max_depth'  => $args[ 'max_depth' ],
						'reply_text' => apply_filters( 'pure_comment_reply', __( '<i class="far fa-reply"></i> Reply', 'pure' ) ),
					)
				)
			); ?>
        </div>
    </div>
	<?php
	if ( 'div' != $args[ 'style' ] ) : ?>
        </div><?php
	endif;
}

//add_action( 'admin_init', 'pure_hide_editor' );
/**
 * Hide editor for front page.
 */
function pure_hide_editor() {

	// Get the Post ID
	if ( isset( $_GET[ 'post' ] ) ) {
		$post_id = $_GET[ 'post' ];
	} elseif ( isset( $_POST[ 'post_ID' ] ) ) {
		$post_id = $_POST[ 'post_ID' ];
	}
	if ( !isset( $post_id ) ) {
		return;
	}

	// Get the Page Template
	$template_file = get_post_meta( $post_id, '_wp_page_template', true );

	// Exclude on these templates
	$exclude_templates = array( 'template-home.php' );

	// Exclude on these IDs
	$exclude_ids = array( get_option( 'page_on_front' ) );

	if ( in_array( $template_file, $exclude_templates ) || in_array( $post_id, $exclude_ids ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}

/**
 * Fix auto p problem with shortcode.
 * For ACF WYSIWYG.
 */
add_action( 'template_redirect', function () {

	$elementor_page = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	$is_woocommerce = false;

	if ( function_exists( 'is_woocommerce' ) ) {
		if ( is_woocommerce() ) {
			$is_woocommerce = true;
		}
	}
	if ( function_exists( 'is_cart' ) ) {
		if ( is_cart() ) {
			$is_woocommerce = true;
		}
	}
	if ( function_exists( 'is_checkout' ) ) {
		if ( is_checkout() ) {
			$is_woocommerce = true;
		}
	}

	if ( !$elementor_page && !$is_woocommerce ) {
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop', 12 );
	}

	remove_filter( 'acf_the_content', 'wpautop' );
	add_filter( 'acf_the_content', 'wpautop', 12 );
}, 11 );
