<?php
/**
 * Accessible search form.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="bunjoin-form bunjoin-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="bunjoin-search-field"><?php esc_html_e( 'Search for:', 'bunjoin-child' ); ?></label>
	<div class="bunjoin-form-grid">
		<div class="bunjoin-field">
			<input id="bunjoin-search-field" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="<?php esc_attr_e( 'Search', 'bunjoin-child' ); ?>">
		</div>
		<button type="submit"><?php esc_html_e( 'Search', 'bunjoin-child' ); ?></button>
	</div>
</form>
