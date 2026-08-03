<?php
/**
 * Ice machine cleaner tablets page template.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
echo bunjoin_render_product_detail_content( 'ice-machine-cleaner-tablets' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
