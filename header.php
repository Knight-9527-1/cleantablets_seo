<?php
/**
 * Classic header fallback for the BunJoin child theme.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php echo bunjoin_render_site_header(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<main id="primary" class="site-main bunjoin-main">
