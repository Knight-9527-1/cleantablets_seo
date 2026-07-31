<?php
/**
 * Required fallback template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_posts_loop_content( __( 'Insights', 'bunjoin-child' ), __( 'Cleaning tablet guides, OEM/ODM articles, FAQs, and approved case studies can be published here.', 'bunjoin-child' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
