<?php
/**
 * Search fallback template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_search_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
