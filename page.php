<?php
/**
 * Page fallback template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_dynamic_page_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
