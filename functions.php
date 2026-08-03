<?php
/**
 * BunJoin Child theme functionality.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BUNJOIN_CHILD_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function bunjoin_child_setup() {
	load_child_theme_textdomain( 'bunjoin-child', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 90,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'search-form' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_editor_style( 'style.css' );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bunjoin-child' ),
		'footer'  => __( 'Footer Navigation', 'bunjoin-child' ),
	) );
}
add_action( 'after_setup_theme', 'bunjoin_child_setup' );

/**
 * Enqueue parent theme, child theme, fonts, and small behavior script.
 */
function bunjoin_child_enqueue_assets() {
	$parent_theme = wp_get_theme( get_template() );
	$parent_ver   = $parent_theme ? $parent_theme->get( 'Version' ) : null;

	wp_enqueue_style(
		'bunjoin-google-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Montserrat:wght@600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'bunjoin-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_ver
	);

	wp_enqueue_style(
		'bunjoin-child-style',
		get_stylesheet_uri(),
		array( 'bunjoin-google-fonts', 'bunjoin-parent-style' ),
		BUNJOIN_CHILD_VERSION
	);

	wp_enqueue_script(
		'bunjoin-theme',
		get_stylesheet_directory_uri() . '/assets/js/theme.js',
		array(),
		BUNJOIN_CHILD_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'bunjoin_child_enqueue_assets' );

/**
 * Mark product-catalog pages and avoid retail cart behavior on this B2B theme.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function bunjoin_child_body_classes( $classes ) {
	$post = get_post();
	$slug = $post instanceof WP_Post ? $post->post_name : '';

	if ( 'products' === $slug || isset( bunjoin_get_products()[ $slug ] ) ) {
		$classes[] = 'bunjoin-no-commerce';
		$classes[] = 'bunjoin-product-catalog-page';
	}

	return $classes;
}
add_filter( 'body_class', 'bunjoin_child_body_classes' );

/**
 * If WooCommerce is present, keep this site in catalog/RFQ mode.
 */
function bunjoin_disable_woocommerce_cart_flows() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_filter( 'woocommerce_is_purchasable', '__return_false' );
}
add_action( 'wp', 'bunjoin_disable_woocommerce_cart_flows' );

/**
 * Register a small pattern category for editor reuse.
 */
function bunjoin_register_pattern_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'bunjoin',
			array( 'label' => __( 'BunJoin', 'bunjoin-child' ) )
		);
	}
}
add_action( 'init', 'bunjoin_register_pattern_category' );

/**
 * Main navigation fallback.
 *
 * @return array<int, array{label:string,path:string}>
 */
function bunjoin_get_nav_items() {
	return array(
		array( 'label' => 'Home', 'path' => '/' ),
		array( 'label' => 'Products', 'path' => '/products/' ),
		array( 'label' => 'Capabilities', 'path' => '/capabilities/' ),
		array( 'label' => 'Quality', 'path' => '/quality/' ),
		array( 'label' => 'About Us', 'path' => '/about-us/' ),
		array( 'label' => 'Insights', 'path' => '/insights/' ),
		array( 'label' => 'Contact Us', 'path' => '/contact-us/' ),
	);
}

/**
 * Core product catalog.
 *
 * @return array<string, array<string, mixed>>
 */
function bunjoin_get_products() {
	return array(
		'washing-machine-cleaner-tablets'  => array(
			'title'       => 'Washing Machine Cleaner Tablets',
			'icon'        => 'WM',
			'short'       => 'Tablet formats for washing machine drum care and private label cleaning programs.',
			'uses'        => array( 'Washing machine drum care SKUs', 'Odor and residue maintenance products', 'Refill packs and e-commerce bundles' ),
			'formula'     => array( 'Dissolution profile by project brief', 'Fragrance-free or custom fragrance direction', 'Color and tablet appearance options' ),
			'specs'       => array( 'Tablet weight and size confirmed during sample development', 'Single tablet, multi-pack, pouch, jar, carton, or refill pack options', 'MOQ confirmed after formula, packaging, and market requirements are reviewed' ),
			'description' => 'Develop washing machine cleaner tablet products with OEM/ODM support from formula discussion through packaging coordination.',
		),
		'dishwasher-cleaner-tablets'       => array(
			'title'       => 'Dishwasher Cleaner Tablets',
			'icon'        => 'DW',
			'short'       => 'Private label dishwasher cleaner tablet options for routine appliance maintenance lines.',
			'uses'        => array( 'Dishwasher maintenance products', 'Retail and marketplace cleaning tablet ranges', 'Subscription or refill packaging concepts' ),
			'formula'     => array( 'Cleaning focus aligned to market positioning', 'Foaming and dissolution behavior by trial', 'Color, fragrance, and tablet shape discussion' ),
			'specs'       => array( 'Tablet size set after formulation trials', 'Blister, pouch, jar, carton, or bulk-ready packaging options', 'Documentation package confirmed per destination market' ),
			'description' => 'Create dishwasher cleaner tablet SKUs with private label packaging paths and market-ready documentation support.',
		),
		'coffee-machine-cleaner-tablets'   => array(
			'title'       => 'Coffee Machine Cleaner Tablets',
			'icon'        => 'CF',
			'short'       => 'Cleaning tablet development for coffee machine and appliance care product lines.',
			'uses'        => array( 'Coffee machine cleaning programs', 'Small appliance cleaner product ranges', 'Specialty retailer and online seller SKUs' ),
			'formula'     => array( 'Formula direction based on intended machine type', 'Tablet hardness and dissolution review', 'Fragrance and color options when appropriate' ),
			'specs'       => array( 'Tablet format reviewed against use instructions', 'Small carton, pouch, bottle, or refill pack options', 'COA and SDS support can be prepared when required' ),
			'description' => 'Support coffee machine cleaner tablet projects with formulation, tablet format, packaging, and documentation planning.',
		),
		'ice-machine-cleaner-tablets'      => array(
			'title'       => 'Ice Machine Cleaner Tablets',
			'icon'        => 'IM',
			'short'       => 'OEM/ODM tablet options for ice machine cleaning and maintenance product ranges.',
			'uses'        => array( 'Ice machine cleaning products', 'Commercial and household appliance care lines', 'Distributor and importer product portfolios' ),
			'formula'     => array( 'Formula direction based on application brief', 'Dissolution and handling properties by trial', 'Packaging language and instruction workflow support' ),
			'specs'       => array( 'Tablet size and pack count customized by project', 'Pouch, carton, jar, or bulk packaging discussion', 'Batch traceability and product documents available by project' ),
			'description' => 'Plan ice machine cleaner tablet products for brand owners, importers, distributors, and private label programs.',
		),
		'garbage-disposal-cleaner-tablets' => array(
			'title'       => 'Garbage Disposal Cleaner Tablets',
			'icon'        => 'GD',
			'short'       => 'Effervescent-style tablet programs for garbage disposal cleaner private label SKUs.',
			'uses'        => array( 'Garbage disposal cleaner products', 'Kitchen cleaning product extensions', 'Marketplace multi-pack and refill programs' ),
			'formula'     => array( 'Foaming and fragrance direction by market brief', 'Tablet color and shape options', 'Use-instruction alignment during sampling' ),
			'specs'       => array( 'Tablet dimensions set after sampling', 'Pouch, jar, carton, or display-ready packaging options', 'MOQ and lead time confirmed after packaging scope is defined' ),
			'description' => 'Build garbage disposal cleaner tablet projects with custom formula direction, tablet production, and private label packaging support.',
		),
		'bottle-cleaner-tablets'           => array(
			'title'       => 'Bottle Cleaner Tablets',
			'icon'        => 'BT',
			'short'       => 'Bottle cleaner tablet development for drinkware, hydration, and household care brands.',
			'uses'        => array( 'Bottle and drinkware cleaner SKUs', 'Lifestyle and outdoor product add-ons', 'Retail, distributor, and e-commerce programs' ),
			'formula'     => array( 'Dissolution behavior aligned to user instructions', 'Fragrance-free or light fragrance options', 'Tablet shape, color, and pack count planning' ),
			'specs'       => array( 'Tablet weight and size confirmed by sample approval', 'Compact pouch, tube, jar, carton, or refill pack options', 'Sample and quotation flow available for new projects' ),
			'description' => 'Develop bottle cleaner tablets with formulation guidance, packaging planning, and inquiry support for private label buyers.',
		),
	);
}

/**
 * Manufacturing capability data.
 *
 * @return array<int, array{title:string,copy:string}>
 */
function bunjoin_get_capabilities() {
	return array(
		array( 'title' => 'OEM/ODM Manufacturing', 'copy' => 'Support for brand-led specifications or collaborative product development from an initial cleaning tablet idea.' ),
		array( 'title' => 'Custom Formulation', 'copy' => 'Formula direction can be discussed around product use, appearance, dissolution, fragrance, and market requirements.' ),
		array( 'title' => 'Private Label Manufacturing', 'copy' => 'Packaging and label workflows are structured for brand owners, marketplace sellers, distributors, and retailers.' ),
		array( 'title' => 'Tablet Production', 'copy' => 'Tablet format, weight, size, hardness, and pack count are reviewed during sample development and production planning.' ),
		array( 'title' => 'Packaging Solutions', 'copy' => 'Pouch, jar, carton, refill, and display-ready packaging paths can be coordinated according to project scope.' ),
		array( 'title' => 'Product Development Process', 'copy' => 'A clear workflow helps move from concept, sampling, documentation, and packaging approval into production.' ),
	);
}

/**
 * Cooperation process.
 *
 * @return array<int, array{title:string,copy:string}>
 */
function bunjoin_get_process_steps() {
	return array(
		array( 'title' => 'Project Brief', 'copy' => 'Share product type, target market, positioning, formula expectations, packaging direction, and estimated order quantity.' ),
		array( 'title' => 'Formula and Format Discussion', 'copy' => 'Review cleaning objective, tablet size, color, fragrance, dissolution behavior, packaging format, and document needs.' ),
		array( 'title' => 'Sample Development', 'copy' => 'Prepare samples for buyer review, feedback, and adjustment before final production specifications are confirmed.' ),
		array( 'title' => 'Packaging and Documentation', 'copy' => 'Coordinate label files, pack structure, use instructions, COA/SDS needs, and shipment documentation requirements.' ),
		array( 'title' => 'Production and Inspection', 'copy' => 'Produce against approved specifications with process checks, finished goods inspection, and batch traceability.' ),
		array( 'title' => 'Shipment Support', 'copy' => 'Support practical export communication and documentation coordination for distributors, importers, and brand buyers.' ),
	);
}

/**
 * Quality information.
 *
 * @return array<int, array{title:string,copy:string}>
 */
function bunjoin_get_quality_items() {
	return array(
		array( 'title' => 'Raw Material Control', 'copy' => 'Incoming raw materials can be checked against agreed specifications before production use.' ),
		array( 'title' => 'Production Process Control', 'copy' => 'Tablet production parameters are monitored according to approved formula and manufacturing requirements.' ),
		array( 'title' => 'Finished Goods Inspection', 'copy' => 'Finished product checks can include appearance, weight, packaging condition, and project-specific inspection points.' ),
		array( 'title' => 'Batch Traceability', 'copy' => 'Batch records help connect production, inspection, and shipment information for each confirmed order.' ),
		array( 'title' => 'COA and SDS Support', 'copy' => 'COA, SDS, and other reasonable product documents can be prepared according to confirmed product and destination market needs.' ),
		array( 'title' => 'Certification Records', 'copy' => 'Use this area to list verified certifications only after documents are confirmed. No certification is claimed by default.' ),
	);
}

/**
 * Audience data.
 *
 * @return array<int, array{title:string,copy:string}>
 */
function bunjoin_get_audiences() {
	return array(
		array( 'title' => 'Cleaning Product Brands', 'copy' => 'Expand home care and appliance care lines with custom tablet products.' ),
		array( 'title' => 'Amazon and E-commerce Sellers', 'copy' => 'Develop differentiated SKUs, refill concepts, bundles, and packaging suited for online channels.' ),
		array( 'title' => 'Retailers', 'copy' => 'Plan private label cleaning tablet assortments with retail-ready pack structures.' ),
		array( 'title' => 'Distributors and Importers', 'copy' => 'Build product ranges with clear specifications, documentation support, and export communication.' ),
		array( 'title' => 'Private Label Buyers', 'copy' => 'Move from product concept to branded packaging through a structured development workflow.' ),
	);
}

/**
 * Internal links used by the optional setup tool.
 *
 * @return array<string, array{title:string,parent:string}>
 */
function bunjoin_get_seed_pages() {
	$pages = array(
		'home'         => array( 'title' => 'Home', 'parent' => '' ),
		'products'     => array( 'title' => 'Products', 'parent' => '' ),
		'capabilities' => array( 'title' => 'Capabilities', 'parent' => '' ),
		'quality'      => array( 'title' => 'Quality', 'parent' => '' ),
		'about-us'     => array( 'title' => 'About Us', 'parent' => '' ),
		'insights'     => array( 'title' => 'Insights', 'parent' => '' ),
		'contact-us'   => array( 'title' => 'Contact Us', 'parent' => '' ),
	);

	foreach ( bunjoin_get_products() as $slug => $product ) {
		$pages[ $slug ] = array(
			'title'  => $product['title'],
			'parent' => '',
		);
	}

	return $pages;
}

/**
 * Build a home_url for a path.
 *
 * @param string $path Path.
 * @return string
 */
function bunjoin_url( $path ) {
	return home_url( $path );
}

/**
 * Section header markup.
 *
 * @param string $eyebrow Eyebrow.
 * @param string $title Title.
 * @param string $copy Copy.
 * @return string
 */
function bunjoin_section_header( $eyebrow, $title, $copy = '' ) {
	ob_start();
	?>
	<div class="bunjoin-section-header">
		<?php if ( $eyebrow ) : ?>
			<p class="bunjoin-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php if ( $copy ) : ?>
			<p class="bunjoin-lead"><?php echo esc_html( $copy ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Wrap rendered shortcode content in a main landmark.
 *
 * @param string $content Rendered HTML.
 * @param string $class Extra class.
 * @return string
 */
function bunjoin_wrap_main( $content, $class = '' ) {
	$class_attr = trim( 'site-main bunjoin-main ' . $class );
	return '<main id="primary" class="' . esc_attr( $class_attr ) . '">' . $content . '</main>';
}

/**
 * Site header.
 *
 * @return string
 */
function bunjoin_render_site_header() {
	$quote_url = bunjoin_url( '/contact-us/#inquiry-form' );

	ob_start();
	?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bunjoin-child' ); ?></a>
	<header class="bunjoin-site-header" role="banner">
		<div class="bunjoin-container bunjoin-header-inner">
			<div class="bunjoin-brand">
				<?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="bunjoin-brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'BunJoin', 'bunjoin-child' ); ?></a>
				<?php endif; ?>
			</div>

			<button class="bunjoin-menu-toggle" type="button" data-bunjoin-menu-toggle aria-controls="bunjoin-primary-menu" aria-expanded="false">
				<span class="bunjoin-menu-icon" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'bunjoin-child' ); ?></span>
			</button>

			<nav class="bunjoin-primary-nav" id="bunjoin-primary-menu" aria-label="<?php esc_attr_e( 'Primary navigation', 'bunjoin-child' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'bunjoin-menu',
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
				} else {
					echo '<ul class="bunjoin-menu">';
					foreach ( bunjoin_get_nav_items() as $item ) {
						printf(
							'<li><a href="%1$s">%2$s</a></li>',
							esc_url( bunjoin_url( $item['path'] ) ),
							esc_html( $item['label'] )
						);
					}
					echo '</ul>';
				}
				?>
				<a class="bunjoin-btn bunjoin-mobile-quote" href="<?php echo esc_url( $quote_url ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
			</nav>

			<a class="bunjoin-btn bunjoin-header-quote" href="<?php echo esc_url( $quote_url ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
		</div>
	</header>
	<?php
	return ob_get_clean();
}

/**
 * Site footer.
 *
 * @return string
 */
function bunjoin_render_site_footer() {
	$products = bunjoin_get_products();
	ob_start();
	?>
	<footer class="bunjoin-site-footer" role="contentinfo">
		<div class="bunjoin-container bunjoin-footer-main">
			<section>
				<h2 class="bunjoin-footer-title"><?php esc_html_e( 'BunJoin', 'bunjoin-child' ); ?></h2>
				<p><?php esc_html_e( 'Cleaning tablet OEM/ODM and private label manufacturing support for brands, e-commerce sellers, retailers, distributors, and importers.', 'bunjoin-child' ); ?></p>
				<p><?php esc_html_e( 'Verified factory, certification, and address details can be added here from the WordPress editor when available.', 'bunjoin-child' ); ?></p>
			</section>

			<section>
				<h3 class="bunjoin-footer-title"><?php esc_html_e( 'Navigation', 'bunjoin-child' ); ?></h3>
				<ul class="bunjoin-footer-list">
					<?php foreach ( bunjoin_get_nav_items() as $item ) : ?>
						<li><a href="<?php echo esc_url( bunjoin_url( $item['path'] ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</section>

			<section>
				<h3 class="bunjoin-footer-title"><?php esc_html_e( 'Products', 'bunjoin-child' ); ?></h3>
				<ul class="bunjoin-footer-list">
					<?php foreach ( $products as $slug => $product ) : ?>
						<li><a href="<?php echo esc_url( bunjoin_url( '/' . $slug . '/' ) ); ?>"><?php echo esc_html( $product['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</section>

			<section>
				<h3 class="bunjoin-footer-title"><?php esc_html_e( 'Contact', 'bunjoin-child' ); ?></h3>
				<p><?php esc_html_e( 'Business email, phone, and address should be replaced with verified contact details in WordPress content or footer settings.', 'bunjoin-child' ); ?></p>
				<a class="bunjoin-btn bunjoin-btn--secondary" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
			</section>
		</div>
		<div class="bunjoin-container bunjoin-footer-bottom">
			<span><?php echo esc_html( sprintf( __( 'Copyright %s BunJoin. All rights reserved.', 'bunjoin-child' ), date_i18n( 'Y' ) ) ); ?></span>
			<span><?php esc_html_e( 'OEM/ODM cleaning tablet manufacturing website.', 'bunjoin-child' ); ?></span>
		</div>
	</footer>
	<?php
	return ob_get_clean();
}

/**
 * Product grid.
 *
 * @return string
 */
function bunjoin_render_product_grid() {
	ob_start();
	?>
	<div class="bunjoin-grid bunjoin-grid--3 bunjoin-product-catalog" aria-label="<?php esc_attr_e( 'Cleaning tablet product catalog', 'bunjoin-child' ); ?>">
		<?php foreach ( bunjoin_get_products() as $slug => $product ) : ?>
			<article class="bunjoin-card bunjoin-product-card">
				<span class="bunjoin-card-icon" aria-hidden="true"><?php echo esc_html( $product['icon'] ); ?></span>
				<h3><?php echo esc_html( $product['title'] ); ?></h3>
				<p><?php echo esc_html( $product['short'] ); ?></p>
				<ul class="bunjoin-product-meta">
					<li><?php esc_html_e( 'OEM/ODM ready', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Private label packaging', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Specs confirmed by project', 'bunjoin-child' ); ?></li>
				</ul>
				<div class="bunjoin-card-actions">
					<a class="bunjoin-btn bunjoin-btn--ghost" href="<?php echo esc_url( bunjoin_url( '/' . $slug . '/' ) ); ?>"><?php esc_html_e( 'View Details', 'bunjoin-child' ); ?></a>
					<a class="bunjoin-card-link" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request Quote', 'bunjoin-child' ); ?></a>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Capability grid.
 *
 * @return string
 */
function bunjoin_render_capability_grid() {
	ob_start();
	?>
	<div class="bunjoin-grid bunjoin-grid--3">
		<?php foreach ( bunjoin_get_capabilities() as $capability ) : ?>
			<article class="bunjoin-card">
				<h3><?php echo esc_html( $capability['title'] ); ?></h3>
				<p><?php echo esc_html( $capability['copy'] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Cooperation process markup.
 *
 * @return string
 */
function bunjoin_render_process() {
	ob_start();
	?>
	<div class="bunjoin-process">
		<?php foreach ( bunjoin_get_process_steps() as $step ) : ?>
			<article class="bunjoin-process-step">
				<div>
					<h3><?php echo esc_html( $step['title'] ); ?></h3>
					<p><?php echo esc_html( $step['copy'] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Quality grid.
 *
 * @return string
 */
function bunjoin_render_quality_grid() {
	ob_start();
	?>
	<div class="bunjoin-grid bunjoin-grid--3">
		<?php foreach ( bunjoin_get_quality_items() as $item ) : ?>
			<article class="bunjoin-card">
				<h3><?php echo esc_html( $item['title'] ); ?></h3>
				<p><?php echo esc_html( $item['copy'] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Inquiry call-to-action.
 *
 * @param string $title Title.
 * @param string $copy Copy.
 * @return string
 */
function bunjoin_render_quote_band( $title, $copy ) {
	ob_start();
	?>
	<section class="bunjoin-section bunjoin-section--compact">
		<div class="bunjoin-container">
			<div class="bunjoin-band">
				<div class="bunjoin-split">
					<div>
						<p class="bunjoin-eyebrow"><?php esc_html_e( 'Start a project', 'bunjoin-child' ); ?></p>
						<h2><?php echo esc_html( $title ); ?></h2>
						<p><?php echo esc_html( $copy ); ?></p>
					</div>
					<div class="bunjoin-actions">
						<a class="bunjoin-btn bunjoin-btn--secondary" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
						<a class="bunjoin-btn bunjoin-btn--ghost" href="<?php echo esc_url( bunjoin_url( '/products/' ) ); ?>"><?php esc_html_e( 'Explore Products', 'bunjoin-child' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Homepage content.
 *
 * @return string
 */
function bunjoin_render_home_content() {
	ob_start();
	?>
	<section class="bunjoin-hero">
		<div class="bunjoin-container bunjoin-hero-inner">
			<div class="bunjoin-hero-content">
				<p class="bunjoin-eyebrow"><?php esc_html_e( 'Cleaning Tablet OEM/ODM and Private Label', 'bunjoin-child' ); ?></p>
				<h1><?php esc_html_e( 'Custom Cleaning Tablet Manufacturer', 'bunjoin-child' ); ?></h1>
				<p class="bunjoin-lead"><?php esc_html_e( 'BunJoin supports B2B buyers with OEM, ODM, and private label cleaning tablet projects, from formulation discussion and tablet format planning to packaging coordination and production documentation.', 'bunjoin-child' ); ?></p>
				<ul class="bunjoin-hero-points">
					<li><?php esc_html_e( 'OEM/ODM manufacturing support', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Private label packaging workflow', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Custom formula and sample review', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'COA/SDS support when required', 'bunjoin-child' ); ?></li>
				</ul>
				<div class="bunjoin-actions">
					<a class="bunjoin-btn" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
					<a class="bunjoin-btn bunjoin-btn--secondary" href="<?php echo esc_url( bunjoin_url( '/products/' ) ); ?>"><?php esc_html_e( 'Explore Our Products', 'bunjoin-child' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Core product categories', 'Cleaning Tablet Product Lines', 'Build private label appliance and household cleaning tablet SKUs around clear product use cases and packaging goals.' ); ?>
			<?php echo bunjoin_render_product_grid(); ?>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Manufacturing capabilities', 'From OEM Brief to Market-Ready Packaging', 'Use BunJoin as a manufacturing partner for product development, tablet production, and private label packaging coordination.' ); ?>
			<?php echo bunjoin_render_capability_grid(); ?>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container bunjoin-split">
			<div>
				<?php echo bunjoin_section_header( 'Development process', 'From Product Concept to Mass Production', 'A structured cooperation flow helps B2B buyers move from early idea to approved formula, approved packaging, and planned production.' ); ?>
				<ul class="bunjoin-check-list">
					<li><?php esc_html_e( 'Project scope is confirmed before sampling and quotation.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Packaging and documentation needs are reviewed before production.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'No unverified certification, capacity, or client claims are presented by default.', 'bunjoin-child' ); ?></li>
				</ul>
			</div>
			<?php echo bunjoin_render_process(); ?>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Quality and documentation', 'Practical Quality Controls for B2B Orders', 'Quality content uses neutral, supportable language around material checks, process control, finished product inspection, traceability, and product documentation.' ); ?>
			<?php echo bunjoin_render_quality_grid(); ?>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Who we serve', 'Built for Cleaning Brands and Channel Buyers', 'BunJoin is positioned for business buyers who need private label cleaning tablet development and manufacturing coordination.' ); ?>
			<div class="bunjoin-grid bunjoin-grid--3">
				<?php foreach ( bunjoin_get_audiences() as $audience ) : ?>
					<article class="bunjoin-card">
						<h3><?php echo esc_html( $audience['title'] ); ?></h3>
						<p><?php echo esc_html( $audience['copy'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container bunjoin-split">
			<div>
				<?php echo bunjoin_section_header( 'Why BunJoin', 'A Focused Cleaning Tablet Manufacturing Partner', 'The site avoids unsupported numbers and keeps the buyer journey centered on product scope, samples, packaging, documentation, and inquiry conversion.' ); ?>
			</div>
			<div class="bunjoin-grid">
				<article class="bunjoin-panel">
					<h3><?php esc_html_e( 'Manufacturing-first positioning', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Content is written for OEM/ODM and private label buyers rather than consumer retail shoppers.', 'bunjoin-child' ); ?></p>
				</article>
				<article class="bunjoin-panel">
					<h3><?php esc_html_e( 'Flexible project discussion', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Formula, tablet size, packaging format, and documentation can be discussed based on the buyer brief.', 'bunjoin-child' ); ?></p>
				</article>
				<article class="bunjoin-panel">
					<h3><?php esc_html_e( 'Clear inquiry pathway', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Request forms capture product, service, quantity, formula, packaging, launch date, and market details for faster follow-up.', 'bunjoin-child' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Insights', 'Guides for Cleaning Tablet Buyers', 'Use Insights for blog posts, cleaning tablet guides, OEM/ODM explainers, FAQs, and case study placeholders that can be replaced with verified content.' ); ?>
			<div class="bunjoin-grid bunjoin-grid--4">
				<?php
				$insights = array(
					array( 'title' => 'Blog', 'copy' => 'Company updates and product development notes.', 'href' => '/insights/#blog' ),
					array( 'title' => 'Cleaning Tablet Guides', 'copy' => 'Buyer education around product types and use cases.', 'href' => '/insights/#cleaning-tablet-guides' ),
					array( 'title' => 'OEM/ODM Guides', 'copy' => 'How to prepare briefs, samples, packaging, and documentation.', 'href' => '/insights/#oem-odm-guides' ),
					array( 'title' => 'FAQ', 'copy' => 'Common questions for private label cleaning tablet projects.', 'href' => '/insights/#faq' ),
				);
				foreach ( $insights as $item ) :
					?>
					<article class="bunjoin-card">
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['copy'] ); ?></p>
						<a class="bunjoin-card-link" href="<?php echo esc_url( bunjoin_url( $item['href'] ) ); ?>"><?php esc_html_e( 'Open section', 'bunjoin-child' ); ?></a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	echo bunjoin_render_quote_band(
		'Ready to discuss a private label cleaning tablet project?',
		'Send your product type, target market, formula direction, packaging requirements, and estimated quantity so the team can review the project scope.'
	);

	echo bunjoin_render_editor_content_section();

	return ob_get_clean();
}

/**
 * Products overview page.
 *
 * @return string
 */
function bunjoin_render_products_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Products', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'Cleaning Tablet Product Catalog', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Browse BunJoin cleaning tablet categories as a B2B catalog. There is no shopping cart, retail checkout, public price table, or add-to-cart flow. Each product links to specification placeholders and an RFQ path.', 'bunjoin-child' ); ?></p>
			<div class="bunjoin-catalog-note" role="note">
				<?php esc_html_e( 'Catalog only: product specifications, MOQ, packaging, samples, and documentation are confirmed after reviewing your project brief.', 'bunjoin-child' ); ?>
			</div>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_render_product_grid(); ?>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Product development', 'What Each Product Page Covers', 'Each product page reserves editable areas for use cases, formula options, tablet weight and size, color and fragrance, packaging, MOQ, documents, samples, and quote requests.' ); ?>
			<div class="bunjoin-grid bunjoin-grid--3">
				<article class="bunjoin-card"><h3><?php esc_html_e( 'Formula and Tablet Format', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'Use the product pages to record confirmed formula direction, tablet weight, dimensions, hardness, color, and fragrance details.', 'bunjoin-child' ); ?></p></article>
				<article class="bunjoin-card"><h3><?php esc_html_e( 'Packaging and MOQ', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'Reserve packaging, label, pack count, and MOQ notes until verified with the actual project scope.', 'bunjoin-child' ); ?></p></article>
				<article class="bunjoin-card"><h3><?php esc_html_e( 'Documents and Samples', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'Add confirmed COA, SDS, sample policy, and destination-market document requirements when available.', 'bunjoin-child' ); ?></p></article>
			</div>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Need a cleaning tablet category not listed here?', 'Send the intended use, target market, formula expectation, packaging direction, and estimated order quantity for review.' );
	return ob_get_clean();
}

/**
 * Product detail page by slug.
 *
 * @param string $slug Product slug.
 * @return string
 */
function bunjoin_render_product_detail_content( $slug ) {
	$products = bunjoin_get_products();

	if ( ! isset( $products[ $slug ] ) ) {
		return bunjoin_render_products_page_content();
	}

	$product = $products[ $slug ];

	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Product development page', 'bunjoin-child' ); ?></p>
			<h1><?php echo esc_html( $product['title'] ); ?></h1>
			<p class="bunjoin-lead"><?php echo esc_html( $product['description'] ); ?></p>
			<div class="bunjoin-actions">
				<a class="bunjoin-btn" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request Product Quote', 'bunjoin-child' ); ?></a>
				<a class="bunjoin-btn bunjoin-btn--secondary" href="<?php echo esc_url( bunjoin_url( '/products/' ) ); ?>"><?php esc_html_e( 'Back to Products', 'bunjoin-child' ); ?></a>
			</div>
		</div>
	</section>

	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<table class="bunjoin-spec-table">
				<tbody>
					<tr>
						<th><?php esc_html_e( 'Typical Uses', 'bunjoin-child' ); ?></th>
						<td><?php echo esc_html( implode( '; ', $product['uses'] ) ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Formula Options', 'bunjoin-child' ); ?></th>
						<td><?php echo esc_html( implode( '; ', $product['formula'] ) ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Tablet Weight / Size', 'bunjoin-child' ); ?></th>
						<td><?php esc_html_e( 'Reserved for confirmed tablet weight, diameter, shape, hardness, and dissolution details after sample development.', 'bunjoin-child' ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Color / Fragrance', 'bunjoin-child' ); ?></th>
						<td><?php esc_html_e( 'Reserved for confirmed color, fragrance-free direction, or custom fragrance requirements.', 'bunjoin-child' ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Packaging', 'bunjoin-child' ); ?></th>
						<td><?php echo esc_html( implode( '; ', $product['specs'] ) ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'MOQ', 'bunjoin-child' ); ?></th>
						<td><?php esc_html_e( 'MOQ is not claimed by default. Confirm after formula, tablet format, packaging, and market requirements are reviewed.', 'bunjoin-child' ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Documentation', 'bunjoin-child' ); ?></th>
						<td><?php esc_html_e( 'COA, SDS, label information, and other reasonable documents can be discussed according to the confirmed product and destination market.', 'bunjoin-child' ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Samples and Quote', 'bunjoin-child' ); ?></th>
						<td><?php esc_html_e( 'Use the inquiry form to share target market, product type, formula requirements, packaging requirements, launch timing, and estimated quantity.', 'bunjoin-child' ); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Discuss this cleaning tablet project', 'Send your brief so formula, packaging, sample, MOQ, and documentation requirements can be reviewed.' );
	return ob_get_clean();
}

/**
 * Capabilities page.
 *
 * @return string
 */
function bunjoin_render_capabilities_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Capabilities', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'OEM/ODM Cleaning Tablet Manufacturing Capabilities', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Use this page to explain verified manufacturing strengths, product development steps, private label workflows, and packaging options without unsupported capacity or certification claims.', 'bunjoin-child' ); ?></p>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_render_capability_grid(); ?>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Product development process', 'A Practical Path for B2B Buyers', 'The process section can be expanded with verified lead times, sample policies, and packaging file requirements once those details are confirmed.' ); ?>
			<?php echo bunjoin_render_process(); ?>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Share your OEM/ODM project brief', 'Include product type, service type, target market, formula expectations, packaging concept, order quantity, and target launch date.' );
	echo bunjoin_render_editor_content_section();
	return ob_get_clean();
}

/**
 * Quality page.
 *
 * @return string
 */
function bunjoin_render_quality_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Quality', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'Quality Assurance and Product Documentation', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Quality language is intentionally neutral: raw material control, process control, finished product inspection, batch traceability, and document support can be edited as verified details become available.', 'bunjoin-child' ); ?></p>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_render_quality_grid(); ?>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container bunjoin-split">
			<div>
				<?php echo bunjoin_section_header( 'Certifications', 'Add Only Verified Certificates', 'This theme does not claim certifications by default. Replace this placeholder only after confirmed certificates, audit records, or product compliance documents are available.' ); ?>
			</div>
			<div class="bunjoin-panel">
				<h3><?php esc_html_e( 'Product Documentation', 'bunjoin-child' ); ?></h3>
				<ul class="bunjoin-check-list">
					<li><?php esc_html_e( 'COA support when required by the confirmed project.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'SDS support according to formula and market needs.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Batch and production records for order traceability.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Label, use instruction, and packaging information can be reviewed during development.', 'bunjoin-child' ); ?></li>
				</ul>
			</div>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Need documents for a destination market?', 'Tell us the product type, target country, buyer requirements, and any document checklist so requirements can be reviewed before quotation.' );
	echo bunjoin_render_editor_content_section();
	return ob_get_clean();
}

/**
 * About page.
 *
 * @return string
 */
function bunjoin_render_about_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'About Us', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'About BunJoin', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'BunJoin is presented as a cleaning tablet OEM/ODM and private label manufacturing partner for business buyers. Verified company history, factory size, equipment list, certificates, and customer examples should be added only after confirmation.', 'bunjoin-child' ); ?></p>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container bunjoin-split">
			<div>
				<?php echo bunjoin_section_header( 'Factory and equipment', 'Reserved for Verified Details', 'Use this section for confirmed production equipment, workshop information, inspection tools, factory photos, or audit details when they are available.' ); ?>
			</div>
			<div class="bunjoin-panel">
				<h3><?php esc_html_e( 'Do not publish until verified', 'bunjoin-child' ); ?></h3>
				<ul class="bunjoin-check-list">
					<li><?php esc_html_e( 'Factory area and production capacity.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Founded year, headcount, or export volume.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Customer names, retailer logos, patents, and certificates.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Testing standards or third-party audit claims.', 'bunjoin-child' ); ?></li>
				</ul>
			</div>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Why BunJoin', 'Focused on Private Label Cleaning Tablet Projects', 'Explain verified strengths around communication, development workflow, formula discussion, packaging coordination, sample review, and documentation support.' ); ?>
			<div class="bunjoin-grid bunjoin-grid--3">
				<article class="bunjoin-card"><h3><?php esc_html_e( 'OEM/ODM Project Support', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'A structured inquiry and sampling workflow helps buyers define product specifications before mass production.', 'bunjoin-child' ); ?></p></article>
				<article class="bunjoin-card"><h3><?php esc_html_e( 'Private Label Focus', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'The theme content is shaped for brands, sellers, retailers, distributors, and importers building cleaning tablet ranges.', 'bunjoin-child' ); ?></p></article>
				<article class="bunjoin-card"><h3><?php esc_html_e( 'Editable Proof Points', 'bunjoin-child' ); ?></h3><p><?php esc_html_e( 'Add real proof points later without changing the theme structure or inventing unsupported claims.', 'bunjoin-child' ); ?></p></article>
			</div>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Who we serve', 'Business Buyers Across Cleaning Channels', 'Use this area for confirmed buyer segments, distribution channels, or market examples.' ); ?>
			<div class="bunjoin-grid bunjoin-grid--3">
				<?php foreach ( bunjoin_get_audiences() as $audience ) : ?>
					<article class="bunjoin-card">
						<h3><?php echo esc_html( $audience['title'] ); ?></h3>
						<p><?php echo esc_html( $audience['copy'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Tell us about your cleaning tablet brand plan', 'Share the target market, product type, formula direction, packaging concept, and timeline for a practical project discussion.' );
	echo bunjoin_render_editor_content_section();
	return ob_get_clean();
}

/**
 * Insights page.
 *
 * @return string
 */
function bunjoin_render_insights_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Insights', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'Cleaning Tablet OEM/ODM Insights', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Organize educational content for private label buyers, including blog posts, cleaning tablet guides, OEM/ODM guides, FAQs, and case studies based on verified project information.', 'bunjoin-child' ); ?></p>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white" id="blog">
		<div class="bunjoin-container">
			<?php echo bunjoin_section_header( 'Blog', 'Latest Posts', 'Publish buyer education and product development articles here.' ); ?>
			<?php echo bunjoin_render_latest_posts( 3 ); ?>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--soft">
		<div class="bunjoin-container">
			<div class="bunjoin-grid bunjoin-grid--2">
				<article class="bunjoin-card" id="cleaning-tablet-guides">
					<h3><?php esc_html_e( 'Cleaning Tablet Guides', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Use this area for neutral product education: tablet types, packaging options, label planning, and use-case comparison.', 'bunjoin-child' ); ?></p>
				</article>
				<article class="bunjoin-card" id="oem-odm-guides">
					<h3><?php esc_html_e( 'OEM/ODM Guides', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Explain how buyers can prepare briefs, samples, packaging files, formula requirements, and documentation checklists.', 'bunjoin-child' ); ?></p>
				</article>
				<article class="bunjoin-card" id="faq">
					<h3><?php esc_html_e( 'FAQ', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Add common questions about samples, MOQ, packaging, lead time, labels, documents, and market requirements after confirmation.', 'bunjoin-child' ); ?></p>
				</article>
				<article class="bunjoin-card" id="case-studies">
					<h3><?php esc_html_e( 'Case Studies', 'bunjoin-child' ); ?></h3>
					<p><?php esc_html_e( 'Reserve this section for anonymized or approved customer stories only. Do not publish customer names or results without permission.', 'bunjoin-child' ); ?></p>
				</article>
			</div>
		</div>
	</section>
	<?php
	echo bunjoin_render_quote_band( 'Have a question for a cleaning tablet project?', 'Use the RFQ form to share your project brief and documentation needs.' );
	echo bunjoin_render_editor_content_section();
	return ob_get_clean();
}

/**
 * Contact page.
 *
 * @return string
 */
function bunjoin_render_contact_page_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Contact Us', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'Request a Cleaning Tablet Quote', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Share your product type, service type, target market, formula requirements, packaging direction, quantity, and launch timing. The form sends to the WordPress administrator email configured in Settings.', 'bunjoin-child' ); ?></p>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white" id="inquiry-form">
		<div class="bunjoin-container bunjoin-split">
			<div>
				<?php echo bunjoin_section_header( 'Inquiry form', 'Tell Us About Your Project', 'The more specific the brief, the easier it is to review formula, packaging, documentation, sample, and quotation requirements.' ); ?>
				<ul class="bunjoin-check-list">
					<li><?php esc_html_e( 'No fixed email address is hardcoded in the theme.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Required fields are validated before email submission.', 'bunjoin-child' ); ?></li>
					<li><?php esc_html_e( 'Inputs are cleaned before being included in the message.', 'bunjoin-child' ); ?></li>
				</ul>
			</div>
			<div class="bunjoin-form-panel">
				<?php echo bunjoin_render_contact_form(); ?>
			</div>
		</div>
	</section>
	<?php
	echo bunjoin_render_editor_content_section();
	return ob_get_clean();
}

/**
 * Editor content appended below theme-managed sections.
 *
 * @return string
 */
function bunjoin_render_editor_content_section() {
	$content = bunjoin_get_editor_content();

	if ( '' === $content ) {
		return '';
	}

	ob_start();
	?>
	<section class="bunjoin-editor-content">
		<div class="bunjoin-container">
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Get current page editor content safely for appended editable areas.
 *
 * @return string
 */
function bunjoin_get_editor_content() {
	$post = get_post();

	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$content = trim( (string) $post->post_content );

	if ( '' === $content ) {
		return '';
	}

	$theme_shortcodes = array( 'bunjoin_home', 'bunjoin_page', 'bunjoin_posts', 'bunjoin_archive', 'bunjoin_search', 'bunjoin_single', 'bunjoin_404' );
	foreach ( $theme_shortcodes as $shortcode ) {
		if ( has_shortcode( $content, $shortcode ) ) {
			return '';
		}
	}

	return apply_filters( 'the_content', $content );
}

/**
 * Dynamic page renderer.
 *
 * @return string
 */
function bunjoin_render_dynamic_page_content() {
	$post = get_post();
	$slug = $post instanceof WP_Post ? $post->post_name : '';

	if ( isset( bunjoin_get_products()[ $slug ] ) ) {
		return bunjoin_render_product_detail_content( $slug );
	}

	switch ( $slug ) {
		case 'products':
			return bunjoin_render_products_page_content();
		case 'capabilities':
			return bunjoin_render_capabilities_page_content();
		case 'quality':
			return bunjoin_render_quality_page_content();
		case 'about-us':
			return bunjoin_render_about_page_content();
		case 'insights':
			return bunjoin_render_insights_page_content();
		case 'contact-us':
			return bunjoin_render_contact_page_content();
		default:
			return bunjoin_render_standard_page_content();
	}
}

/**
 * Standard page fallback.
 *
 * @return string
 */
function bunjoin_render_standard_page_content() {
	ob_start();

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<section class="bunjoin-page-hero">
				<div class="bunjoin-container">
					<h1><?php the_title(); ?></h1>
				</div>
			</section>
			<section class="bunjoin-section bunjoin-section--white">
				<div class="bunjoin-container">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		}
	}

	return ob_get_clean();
}

/**
 * Contact field definitions.
 *
 * @return array<string, array<string, mixed>>
 */
function bunjoin_contact_fields() {
	return array(
		'name'                     => array( 'label' => 'Name', 'type' => 'text', 'required' => true ),
		'company'                  => array( 'label' => 'Company', 'type' => 'text', 'required' => true ),
		'business_email'           => array( 'label' => 'Business Email', 'type' => 'email', 'required' => true ),
		'country_market'           => array( 'label' => 'Country/Market', 'type' => 'text', 'required' => true ),
		'product_type'             => array(
			'label'    => 'Product Type',
			'type'     => 'select',
			'required' => true,
			'options'  => array(
				'Washing Machine Cleaner Tablets',
				'Dishwasher Cleaner Tablets',
				'Coffee Machine Cleaner Tablets',
				'Ice Machine Cleaner Tablets',
				'Garbage Disposal Cleaner Tablets',
				'Bottle Cleaner Tablets',
				'Other Cleaning Tablet Project',
			),
		),
		'service_type'             => array(
			'label'    => 'Service Type',
			'type'     => 'select',
			'required' => true,
			'options'  => array(
				'OEM Manufacturing',
				'ODM Product Development',
				'Private Label Manufacturing',
				'Custom Formulation',
				'Packaging Solution',
				'Other',
			),
		),
		'estimated_order_quantity' => array( 'label' => 'Estimated Order Quantity', 'type' => 'text', 'required' => false ),
		'formula_requirements'     => array( 'label' => 'Formula Requirements', 'type' => 'textarea', 'required' => false ),
		'packaging_requirements'   => array( 'label' => 'Packaging Requirements', 'type' => 'textarea', 'required' => false ),
		'target_launch_date'       => array( 'label' => 'Target Launch Date', 'type' => 'text', 'required' => false ),
		'message'                  => array( 'label' => 'Message', 'type' => 'textarea', 'required' => true ),
	);
}

/**
 * Render contact form status notice.
 *
 * @return string
 */
function bunjoin_render_contact_notice() {
	if ( empty( $_GET['bunjoin-inquiry'] ) ) {
		return '';
	}

	$status = sanitize_key( wp_unslash( $_GET['bunjoin-inquiry'] ) );

	if ( 'sent' === $status ) {
		return '<div class="bunjoin-notice bunjoin-notice--success" role="status">' . esc_html__( 'Thank you. Your inquiry has been sent successfully.', 'bunjoin-child' ) . '</div>';
	}

	if ( 'mail_failed' === $status ) {
		return '<div class="bunjoin-notice bunjoin-notice--error" role="alert">' . esc_html__( 'The form was validated, but WordPress could not send the email. Please check site mail settings.', 'bunjoin-child' ) . '</div>';
	}

	return '<div class="bunjoin-notice bunjoin-notice--error" role="alert">' . esc_html__( 'Please complete the required fields and enter a valid business email.', 'bunjoin-child' ) . '</div>';
}

/**
 * Render the contact form.
 *
 * @return string
 */
function bunjoin_render_contact_form() {
	$fields = bunjoin_contact_fields();
	$action = is_singular() ? get_permalink() : bunjoin_url( '/contact-us/' );

	ob_start();
	echo bunjoin_render_contact_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
	<form class="bunjoin-form" method="post" action="<?php echo esc_url( $action ); ?>#inquiry-form">
		<?php wp_nonce_field( 'bunjoin_contact_form', 'bunjoin_contact_nonce' ); ?>
		<input type="hidden" name="bunjoin_contact_form" value="1">
		<div class="bunjoin-honeypot" aria-hidden="true">
			<label for="bunjoin_company_website"><?php esc_html_e( 'Company website', 'bunjoin-child' ); ?></label>
			<input type="text" id="bunjoin_company_website" name="bunjoin_company_website" tabindex="-1" autocomplete="off">
		</div>

		<div class="bunjoin-form-grid">
			<?php foreach ( $fields as $key => $field ) : ?>
				<?php
				$id       = 'bunjoin_' . $key;
				$required = ! empty( $field['required'] );
				$type     = $field['type'];
				$classes  = in_array( $type, array( 'textarea' ), true ) ? 'bunjoin-field bunjoin-field--full' : 'bunjoin-field';
				?>
				<div class="<?php echo esc_attr( $classes ); ?>">
					<label for="<?php echo esc_attr( $id ); ?>">
						<?php echo esc_html( $field['label'] ); ?>
						<?php if ( $required ) : ?>
							<span class="bunjoin-required" aria-hidden="true">*</span>
						<?php endif; ?>
					</label>
					<?php if ( 'select' === $type ) : ?>
						<select id="<?php echo esc_attr( $id ); ?>" name="bunjoin_contact[<?php echo esc_attr( $key ); ?>]" <?php echo $required ? 'required' : ''; ?>>
							<option value=""><?php esc_html_e( 'Select an option', 'bunjoin-child' ); ?></option>
							<?php foreach ( $field['options'] as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'textarea' === $type ) : ?>
						<textarea id="<?php echo esc_attr( $id ); ?>" name="bunjoin_contact[<?php echo esc_attr( $key ); ?>]" <?php echo $required ? 'required' : ''; ?>></textarea>
					<?php else : ?>
						<input id="<?php echo esc_attr( $id ); ?>" type="<?php echo esc_attr( $type ); ?>" name="bunjoin_contact[<?php echo esc_attr( $key ); ?>]" <?php echo $required ? 'required' : ''; ?>>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<button type="submit"><?php esc_html_e( 'Submit Inquiry', 'bunjoin-child' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}

/**
 * Redirect helper for form result.
 *
 * @param string $status Result status.
 * @return string
 */
function bunjoin_contact_redirect_url( $status ) {
	$referer = wp_get_referer();
	$url     = $referer ? remove_query_arg( 'bunjoin-inquiry', $referer ) : bunjoin_url( '/contact-us/' );

	return add_query_arg( 'bunjoin-inquiry', rawurlencode( $status ), $url ) . '#inquiry-form';
}

/**
 * Process the contact form.
 */
function bunjoin_process_contact_form() {
	if ( empty( $_POST['bunjoin_contact_form'] ) ) {
		return;
	}

	if ( empty( $_POST['bunjoin_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bunjoin_contact_nonce'] ) ), 'bunjoin_contact_form' ) ) {
		wp_safe_redirect( bunjoin_contact_redirect_url( 'invalid' ) );
		exit;
	}

	if ( ! empty( $_POST['bunjoin_company_website'] ) ) {
		wp_safe_redirect( bunjoin_contact_redirect_url( 'sent' ) );
		exit;
	}

	$raw    = isset( $_POST['bunjoin_contact'] ) && is_array( $_POST['bunjoin_contact'] ) ? wp_unslash( $_POST['bunjoin_contact'] ) : array();
	$fields = bunjoin_contact_fields();
	$data   = array();
	$valid  = true;

	foreach ( $fields as $key => $field ) {
		$value = isset( $raw[ $key ] ) ? $raw[ $key ] : '';
		$value = is_string( $value ) ? $value : '';

		if ( 'email' === $field['type'] ) {
			$value = sanitize_email( $value );
		} elseif ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $value );
		} else {
			$value = sanitize_text_field( $value );
		}

		if ( ! empty( $field['required'] ) && '' === $value ) {
			$valid = false;
		}

		$data[ $key ] = $value;
	}

	if ( ! is_email( $data['business_email'] ) ) {
		$valid = false;
	}

	if ( ! $valid ) {
		wp_safe_redirect( bunjoin_contact_redirect_url( 'invalid' ) );
		exit;
	}

	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf(
		/* translators: %s: company name. */
		__( 'New BunJoin cleaning tablet RFQ from %s', 'bunjoin-child' ),
		$data['company']
	);

	$lines = array(
		'Name: ' . $data['name'],
		'Company: ' . $data['company'],
		'Business Email: ' . $data['business_email'],
		'Country/Market: ' . $data['country_market'],
		'Product Type: ' . $data['product_type'],
		'Service Type: ' . $data['service_type'],
		'Estimated Order Quantity: ' . $data['estimated_order_quantity'],
		'Formula Requirements: ' . $data['formula_requirements'],
		'Packaging Requirements: ' . $data['packaging_requirements'],
		'Target Launch Date: ' . $data['target_launch_date'],
		'Message: ' . $data['message'],
	);

	$body = "A new inquiry was submitted from the BunJoin website.\n\n" . implode( "\n", $lines );

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . sanitize_text_field( $data['name'] ) . ' <' . $data['business_email'] . '>',
	);

	$sent = wp_mail( $admin_email, $subject, $body, $headers );

	wp_safe_redirect( bunjoin_contact_redirect_url( $sent ? 'sent' : 'mail_failed' ) );
	exit;
}
add_action( 'template_redirect', 'bunjoin_process_contact_form' );

/**
 * Latest posts for Insights.
 *
 * @param int $limit Posts to show.
 * @return string
 */
function bunjoin_render_latest_posts( $limit = 3 ) {
	$query = new WP_Query( array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => absint( $limit ),
		'ignore_sticky_posts' => true,
	) );

	ob_start();

	if ( $query->have_posts() ) {
		echo '<div class="bunjoin-post-list">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo bunjoin_render_post_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		?>
		<div class="bunjoin-empty-state">
			<p><?php esc_html_e( 'No posts are published yet. Add blog posts for cleaning tablet guides, OEM/ODM education, FAQ content, and approved case studies.', 'bunjoin-child' ); ?></p>
		</div>
		<?php
	}

	return ob_get_clean();
}

/**
 * Post card.
 *
 * @return string
 */
function bunjoin_render_post_card() {
	ob_start();
	?>
	<article <?php post_class( 'bunjoin-post-card' ); ?>>
		<div class="bunjoin-post-meta"><?php echo esc_html( get_the_date() ); ?></div>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
		<a class="bunjoin-card-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'bunjoin-child' ); ?></a>
	</article>
	<?php
	return ob_get_clean();
}

/**
 * Posts index/archive loop.
 *
 * @param string $title Page title.
 * @param string $copy Page copy.
 * @return string
 */
function bunjoin_render_posts_loop_content( $title, $copy = '' ) {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Insights', 'bunjoin-child' ); ?></p>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $copy ) : ?>
				<p class="bunjoin-lead"><?php echo esc_html( $copy ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<section class="bunjoin-section bunjoin-section--white">
		<div class="bunjoin-container">
			<?php if ( have_posts() ) : ?>
				<div class="bunjoin-post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						echo bunjoin_render_post_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					endwhile;
					?>
				</div>
				<div class="bunjoin-pagination">
					<?php the_posts_pagination(); ?>
				</div>
			<?php else : ?>
				<div class="bunjoin-empty-state">
					<p><?php esc_html_e( 'No posts were found.', 'bunjoin-child' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Single post content.
 *
 * @return string
 */
function bunjoin_render_single_content() {
	ob_start();

	while ( have_posts() ) {
		the_post();
		?>
		<section class="bunjoin-page-hero">
			<div class="bunjoin-container">
				<p class="bunjoin-eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<article class="bunjoin-section bunjoin-section--white">
			<div class="bunjoin-container">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	}

	return ob_get_clean();
}

/**
 * Search results.
 *
 * @return string
 */
function bunjoin_render_search_content() {
	$query = get_search_query();
	return bunjoin_render_posts_loop_content(
		$query ? sprintf( __( 'Search results for "%s"', 'bunjoin-child' ), $query ) : __( 'Search Results', 'bunjoin-child' ),
		__( 'Search the BunJoin site for product, capability, quality, and OEM/ODM content.', 'bunjoin-child' )
	);
}

/**
 * 404 content.
 *
 * @return string
 */
function bunjoin_render_404_content() {
	ob_start();
	?>
	<section class="bunjoin-page-hero">
		<div class="bunjoin-container">
			<p class="bunjoin-eyebrow"><?php esc_html_e( 'Page not found', 'bunjoin-child' ); ?></p>
			<h1><?php esc_html_e( 'This page could not be found.', 'bunjoin-child' ); ?></h1>
			<p class="bunjoin-lead"><?php esc_html_e( 'Use the navigation to find cleaning tablet products, capabilities, quality information, insights, or the inquiry form.', 'bunjoin-child' ); ?></p>
			<div class="bunjoin-actions">
				<a class="bunjoin-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go Home', 'bunjoin-child' ); ?></a>
				<a class="bunjoin-btn bunjoin-btn--secondary" href="<?php echo esc_url( bunjoin_url( '/contact-us/#inquiry-form' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Shortcodes used by block templates.
 */
function bunjoin_register_shortcodes() {
	add_shortcode( 'bunjoin_site_header', 'bunjoin_render_site_header' );
	add_shortcode( 'bunjoin_site_footer', 'bunjoin_render_site_footer' );
	add_shortcode( 'bunjoin_home', 'bunjoin_home_shortcode' );
	add_shortcode( 'bunjoin_page', 'bunjoin_page_shortcode' );
	add_shortcode( 'bunjoin_contact_form', 'bunjoin_contact_form_shortcode' );
	add_shortcode( 'bunjoin_posts', 'bunjoin_posts_shortcode' );
	add_shortcode( 'bunjoin_archive', 'bunjoin_archive_shortcode' );
	add_shortcode( 'bunjoin_search', 'bunjoin_search_shortcode' );
	add_shortcode( 'bunjoin_single', 'bunjoin_single_shortcode' );
	add_shortcode( 'bunjoin_404', 'bunjoin_404_shortcode' );
}
add_action( 'init', 'bunjoin_register_shortcodes' );

/**
 * Home shortcode.
 *
 * @return string
 */
function bunjoin_home_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_home_content(), 'bunjoin-front-page' );
}

/**
 * Page shortcode.
 *
 * @return string
 */
function bunjoin_page_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_dynamic_page_content(), 'bunjoin-page' );
}

/**
 * Contact form shortcode.
 *
 * @return string
 */
function bunjoin_contact_form_shortcode() {
	return bunjoin_render_contact_form();
}

/**
 * Posts shortcode.
 *
 * @return string
 */
function bunjoin_posts_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_posts_loop_content( __( 'Insights', 'bunjoin-child' ), __( 'Cleaning tablet guides, OEM/ODM articles, FAQs, and approved case studies can be published here.', 'bunjoin-child' ) ), 'bunjoin-posts' );
}

/**
 * Archive shortcode.
 *
 * @return string
 */
function bunjoin_archive_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_posts_loop_content( wp_strip_all_tags( get_the_archive_title() ), wp_strip_all_tags( get_the_archive_description() ) ), 'bunjoin-archive' );
}

/**
 * Search shortcode.
 *
 * @return string
 */
function bunjoin_search_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_search_content(), 'bunjoin-search' );
}

/**
 * Single shortcode.
 *
 * @return string
 */
function bunjoin_single_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_single_content(), 'bunjoin-single' );
}

/**
 * 404 shortcode.
 *
 * @return string
 */
function bunjoin_404_shortcode() {
	return bunjoin_wrap_main( bunjoin_render_404_content(), 'bunjoin-404' );
}

/**
 * Admin setup page registration.
 */
function bunjoin_register_setup_page() {
	add_theme_page(
		__( 'BunJoin Setup', 'bunjoin-child' ),
		__( 'BunJoin Setup', 'bunjoin-child' ),
		'edit_pages',
		'bunjoin-child-setup',
		'bunjoin_render_setup_page'
	);
}
add_action( 'admin_menu', 'bunjoin_register_setup_page' );

/**
 * Create missing pages without overwriting existing pages.
 *
 * @return array{created:array<int, string>, existing:array<int, string>, failed:array<int, string>}
 */
function bunjoin_create_missing_pages() {
	$created = array();
	$existing = array();
	$failed = array();
	$page_ids = array();

	foreach ( bunjoin_get_seed_pages() as $slug => $page ) {
		$found = get_page_by_path( $slug, OBJECT, 'page' );

		if ( $found instanceof WP_Post ) {
			$existing[ $slug ] = $page['title'];
			$page_ids[ $slug ] = $found->ID;
			continue;
		}

		$parent_id = 0;
		if ( $page['parent'] && isset( $page_ids[ $page['parent'] ] ) ) {
			$parent_id = absint( $page_ids[ $page['parent'] ] );
		}

		$page_id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $page['title'],
			'post_name'    => $slug,
			'post_parent'  => $parent_id,
			'post_content' => '',
		), true );

		if ( is_wp_error( $page_id ) ) {
			$failed[ $slug ] = $page_id->get_error_message();
			continue;
		}

		$created[ $slug ] = $page['title'];
		$page_ids[ $slug ] = absint( $page_id );
	}

	return array(
		'created'  => $created,
		'existing' => $existing,
		'failed'   => $failed,
	);
}

/**
 * Render setup admin page.
 */
function bunjoin_render_setup_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$result = null;

	if ( isset( $_POST['bunjoin_seed_pages'] ) ) {
		check_admin_referer( 'bunjoin_seed_pages' );
		$result = bunjoin_create_missing_pages();
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'BunJoin Theme Setup', 'bunjoin-child' ); ?></h1>
		<p><?php esc_html_e( 'Create only missing pages for the BunJoin navigation and product detail structure. Existing pages, menus, homepage settings, and content are not overwritten.', 'bunjoin-child' ); ?></p>

		<?php if ( is_array( $result ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p>
					<?php
					printf(
						esc_html__( 'Created: %1$d. Already existed: %2$d. Failed: %3$d.', 'bunjoin-child' ),
						count( $result['created'] ),
						count( $result['existing'] ),
						count( $result['failed'] )
					);
					?>
				</p>
			</div>
			<?php if ( ! empty( $result['failed'] ) ) : ?>
				<div class="notice notice-error">
					<ul>
						<?php foreach ( $result['failed'] as $slug => $message ) : ?>
							<li><?php echo esc_html( $slug . ': ' . $message ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<form method="post">
			<?php wp_nonce_field( 'bunjoin_seed_pages' ); ?>
			<input type="hidden" name="bunjoin_seed_pages" value="1">
			<?php submit_button( __( 'Create Missing BunJoin Pages', 'bunjoin-child' ) ); ?>
		</form>

		<h2><?php esc_html_e( 'Pages included', 'bunjoin-child' ); ?></h2>
		<ul>
			<?php foreach ( bunjoin_get_seed_pages() as $slug => $page ) : ?>
				<li><code><?php echo esc_html( '/' . $slug . '/' ); ?></code> <?php echo esc_html( $page['title'] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
