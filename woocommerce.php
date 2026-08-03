<?php
/**
 * WooCommerce fallback template for catalog-only BunJoin product pages.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$slug = get_post() instanceof WP_Post ? get_post()->post_name : '';

if ( isset( bunjoin_get_products()[ $slug ] ) ) {
	echo bunjoin_render_product_detail_content( $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	echo bunjoin_render_products_page_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

get_footer();
