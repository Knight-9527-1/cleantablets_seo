<?php
/**
 * Classic footer fallback for the BunJoin child theme.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>
<?php echo bunjoin_render_site_footer(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php wp_footer(); ?>
</body>
</html>
