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

function pure() {

	get_header();

	do_action( 'pure_before_content_sidebar_wrap' );

	pure_tag( array(
		'open'    => '<div %s>',
		'context' => 'content-sidebar-wrap',
	) );

		do_action( 'pure_before_content' );

		pure_tag( array(
			'open'    => '<main %s>',
			'context' => 'content',
			'params'  => array(
				'id' => 'pure-content',
			),
		) );

			/**
			 * Hook: pure_before_loop
			 *
			 * @hooked pure_title - 5
			 * @hooked pure_loop_wrapper_open - 10
			 */
			do_action( 'pure_before_loop' );
			/**
			 * Hook: pure_loop
			 *
			 * @hooked pure_standard_loop - 10
			 */
			do_action( 'pure_loop'        );
			/**
			 * Hook: pure_after_loop
			 *
			 * @hooked pure_loop_wrapper_close - 10
			 */
			do_action( 'pure_after_loop'  );

		pure_tag( array(
			'close'   => '</main>',
			'context' => 'content',
		) );

	/**
	 * Hook: pure_after_content
	 *
	 * @hooked pure_get_sidebar           - 10
	 * @hooked pure_get_sidebar_secondary - 10
	 */
		do_action( 'pure_after_content' );

	pure_tag( array(
		'close'    => '</div>',
		'context' => 'content-sidebar-wrap',
	) );

	do_action( 'pure_after_content_sidebar_wrap' );

	get_footer();
}
