<?php
/**
 * Archive fallback template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_posts_loop_content( wp_strip_all_tags( get_the_archive_title() ), wp_strip_all_tags( get_the_archive_description() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
