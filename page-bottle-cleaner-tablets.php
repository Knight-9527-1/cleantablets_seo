<?php
/**
 * Bottle cleaner tablets page template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_product_detail_content( 'bottle-cleaner-tablets' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
