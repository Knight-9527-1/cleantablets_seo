<?php
/**
 * BunJoin Child theme functionality.
 *
 * @package BunJoin_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BUNJOIN_CHILD_VERSION', '1.1.0' );
define( 'BUNJOIN_PAGE_KEY_META', '_bunjoin_page_key' );

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
 * SEO title and description data by managed page.
 *
 * @return array<string, array<string, array{title:string,description:string}>>
 */
function bunjoin_get_seo_map() {
	$default = array(
		'en' => array(
			'title'       => 'Custom Cleaning Tablet Manufacturer | OEM/ODM & Private Label',
			'description' => 'BunJoin supports B2B cleaning tablet OEM/ODM and private label projects, including formulation discussion, tablet production, packaging coordination, COA/SDS support, and RFQ workflows.',
		),
		'zh' => array(
			'title'       => '定制清洁片制造商 | OEM/ODM 与自有品牌',
			'description' => 'BunJoin 为 B2B 买家提供清洁片 OEM/ODM 与自有品牌项目支持，覆盖配方讨论、片剂生产、包装协同、COA/SDS 文件支持和询盘流程。',
		),
		'es' => array(
			'title'       => 'Fabricante de Tabletas de Limpieza | OEM/ODM y Marca Privada',
			'description' => 'BunJoin apoya proyectos B2B OEM/ODM y de marca privada para tabletas de limpieza, con formulación, producción, empaque, documentación COA/SDS y solicitudes de cotización.',
		),
	);

	$pages = array(
		'home'         => $default,
		'products'     => array(
			'en' => array( 'title' => 'Cleaning Tablet Product Catalog | BunJoin OEM/ODM', 'description' => 'Browse BunJoin cleaning tablet product categories for B2B private label buyers, including washing machine, dishwasher, coffee machine, ice machine, garbage disposal, and bottle cleaner tablets.' ),
			'zh' => array( 'title' => '清洁片产品目录 | BunJoin OEM/ODM', 'description' => '浏览 BunJoin 面向 B2B 自有品牌买家的清洁片产品分类，包括洗衣机、洗碗机、咖啡机、制冰机、厨余处理器和水杯清洁片。' ),
			'es' => array( 'title' => 'Catálogo de Tabletas de Limpieza | BunJoin OEM/ODM', 'description' => 'Explore categorías de tabletas de limpieza BunJoin para compradores B2B de marca privada: lavadoras, lavavajillas, cafeteras, máquinas de hielo, trituradores y botellas.' ),
		),
		'capabilities' => array(
			'en' => array( 'title' => 'OEM/ODM Cleaning Tablet Manufacturing Capabilities | BunJoin', 'description' => 'Review BunJoin manufacturing capabilities for custom formulation, private label manufacturing, tablet production, packaging solutions, and product development process.' ),
			'zh' => array( 'title' => 'OEM/ODM 清洁片制造能力 | BunJoin', 'description' => '了解 BunJoin 在定制配方、自有品牌制造、片剂生产、包装方案和产品开发流程方面的制造能力。' ),
			'es' => array( 'title' => 'Capacidades OEM/ODM para Tabletas de Limpieza | BunJoin', 'description' => 'Revise las capacidades de BunJoin en formulación personalizada, fabricación de marca privada, producción de tabletas, empaque y desarrollo de producto.' ),
		),
		'quality'      => array(
			'en' => array( 'title' => 'Quality Assurance & Documentation for Cleaning Tablets | BunJoin', 'description' => 'BunJoin quality content covers raw material control, process control, finished goods inspection, batch traceability, and COA/SDS documentation support without unsupported certification claims.' ),
			'zh' => array( 'title' => '清洁片质量保证与文件支持 | BunJoin', 'description' => 'BunJoin 质量内容涵盖原料控制、过程控制、成品检查、批次追溯和 COA/SDS 文件支持，不发布未经确认的认证声明。' ),
			'es' => array( 'title' => 'Calidad y Documentación para Tabletas de Limpieza | BunJoin', 'description' => 'La calidad de BunJoin cubre control de materias primas, proceso, inspección final, trazabilidad por lote y documentación COA/SDS sin afirmar certificaciones no verificadas.' ),
		),
		'about-us'     => array(
			'en' => array( 'title' => 'About BunJoin | Cleaning Tablet OEM/ODM Manufacturer', 'description' => 'Learn about BunJoin as a cleaning tablet OEM/ODM and private label manufacturing partner for brands, sellers, retailers, distributors, importers, and private label buyers.' ),
			'zh' => array( 'title' => '关于 BunJoin | 清洁片 OEM/ODM 制造商', 'description' => '了解 BunJoin 作为清洁片 OEM/ODM 与自有品牌制造伙伴，服务品牌方、电商卖家、零售商、分销商、进口商和自有品牌买家。' ),
			'es' => array( 'title' => 'Sobre BunJoin | Fabricante OEM/ODM de Tabletas de Limpieza', 'description' => 'Conozca BunJoin como socio de fabricación OEM/ODM y marca privada para marcas, vendedores, retailers, distribuidores, importadores y compradores B2B.' ),
		),
		'insights'     => array(
			'en' => array( 'title' => 'Cleaning Tablet OEM/ODM Insights, Guides & FAQ | BunJoin', 'description' => 'Read cleaning tablet guides, OEM/ODM resources, FAQs, blog posts, and case study placeholders for private label cleaning tablet buyers.' ),
			'zh' => array( 'title' => '清洁片 OEM/ODM 洞察、指南与 FAQ | BunJoin', 'description' => '阅读面向自有品牌清洁片买家的清洁片指南、OEM/ODM 资源、FAQ、博客和案例栏目。' ),
			'es' => array( 'title' => 'Recursos OEM/ODM, Guías y FAQ de Tabletas de Limpieza | BunJoin', 'description' => 'Lea guías de tabletas de limpieza, recursos OEM/ODM, preguntas frecuentes, blog y ejemplos para compradores de marca privada.' ),
		),
		'contact-us'   => array(
			'en' => array( 'title' => 'Request a Cleaning Tablet Quote | BunJoin', 'description' => 'Send BunJoin your cleaning tablet project brief with product type, service type, market, quantity, formula, packaging, launch date, and message for B2B RFQ review.' ),
			'zh' => array( 'title' => '提交清洁片报价需求 | BunJoin', 'description' => '向 BunJoin 提交清洁片项目需求，包括产品类型、服务类型、市场、数量、配方、包装、上市时间和留言，用于 B2B 报价评估。' ),
			'es' => array( 'title' => 'Solicitar Cotización de Tabletas de Limpieza | BunJoin', 'description' => 'Envíe a BunJoin su brief con tipo de producto, servicio, mercado, cantidad, fórmula, empaque, fecha de lanzamiento y mensaje para revisión B2B.' ),
		),
	);

	foreach ( bunjoin_get_products() as $slug => $product ) {
		$translations = bunjoin_translation_map();
		$zh_product_title = isset( $translations['zh'][ $product['title'] ] ) ? $translations['zh'][ $product['title'] ] : $product['title'];
		$es_product_title = isset( $translations['es'][ $product['title'] ] ) ? $translations['es'][ $product['title'] ] : $product['title'];
		$pages[ $slug ] = array(
			'en' => array(
				'title'       => $product['title'] . ' | Private Label Cleaning Tablets',
				'description' => $product['description'] . ' Request formula, packaging, MOQ, documentation, sample, and quotation review for B2B projects.',
			),
			'zh' => array(
				'title'       => $zh_product_title . ' | 自有品牌清洁片',
				'description' => '面向 B2B 买家的' . $zh_product_title . '产品开发页面，预留配方、包装、MOQ、文件、样品和报价评估内容。',
			),
			'es' => array(
				'title'       => $es_product_title . ' | Tabletas de Limpieza de Marca Privada',
				'description' => 'Página de desarrollo B2B para ' . $es_product_title . ', con revisión de fórmula, empaque, MOQ, documentación, muestras y cotización.',
			),
		);
	}

	return $pages;
}

/**
 * Current SEO data.
 *
 * @return array{title:string,description:string}
 */
function bunjoin_get_current_seo_data() {
	$lang = bunjoin_current_language();
	$key = is_front_page() ? 'home' : bunjoin_get_current_page_key();
	$map = bunjoin_get_seo_map();

	if ( isset( $map[ $key ][ $lang ] ) ) {
		return $map[ $key ][ $lang ];
	}

	if ( isset( $map['home'][ $lang ] ) ) {
		return $map['home'][ $lang ];
	}

	return $map['home']['en'];
}

/**
 * Improve the document title for theme-managed pages.
 *
 * @param array<string, string> $parts Title parts.
 * @return array<string, string>
 */
function bunjoin_filter_document_title_parts( $parts ) {
	if ( is_admin() ) {
		return $parts;
	}

	$seo = bunjoin_get_current_seo_data();
	$parts['title'] = $seo['title'];
	unset( $parts['site'] );

	return $parts;
}
add_filter( 'document_title_parts', 'bunjoin_filter_document_title_parts', 20 );

/**
 * Output lightweight SEO metadata.
 */
function bunjoin_output_seo_meta() {
	if ( is_admin() || is_feed() ) {
		return;
	}

	$seo = bunjoin_get_current_seo_data();
	$key = is_front_page() ? 'home' : bunjoin_get_current_page_key();
	$canonical = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );

	if ( function_exists( 'wp_get_canonical_url' ) && is_singular() ) {
		$wp_canonical = wp_get_canonical_url();
		if ( $wp_canonical ) {
			$canonical = $wp_canonical;
		}
	}

	echo "\n" . '<meta name="description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";

	foreach ( bunjoin_supported_languages() as $slug => $language ) {
		$url = bunjoin_get_language_url_for_key( $key, $slug );
		echo '<link rel="alternate" hreflang="' . esc_attr( str_replace( '_', '-', $language['locale'] ) ) . '" href="' . esc_url( $url ) . '">' . "\n";
	}

	echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( bunjoin_get_language_url_for_key( $key, 'en' ) ) . '">' . "\n";

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'Organization',
		'name'            => 'BunJoin',
		'url'             => home_url( '/' ),
		'description'     => $seo['description'],
		'knowsAbout'      => array(
			'Cleaning tablet manufacturing',
			'OEM cleaning tablets',
			'ODM cleaning tablets',
			'Private label cleaning tablets',
			'Effervescent cleaning tablets',
		),
		'areaServed'      => array( 'United States', 'International B2B Markets' ),
		'availableLanguage' => array( 'English', 'Chinese', 'Spanish' ),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bunjoin_output_seo_meta', 2 );
remove_action( 'wp_head', 'rel_canonical' );

/**
 * Mark product-catalog pages and avoid retail cart behavior on this B2B theme.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function bunjoin_child_body_classes( $classes ) {
	$key = bunjoin_get_current_page_key();

	if ( 'products' === $key || isset( bunjoin_get_products()[ $key ] ) ) {
		$classes[] = 'bunjoin-no-commerce';
		$classes[] = 'bunjoin-product-catalog-page';
	}

	$classes[] = 'bunjoin-lang-' . bunjoin_current_language();

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
 * Supported public languages for the BunJoin site.
 *
 * @return array<string, array{name:string,locale:string,prefix:string}>
 */
function bunjoin_supported_languages() {
	return array(
		'en' => array( 'name' => 'English', 'locale' => 'en_US', 'prefix' => '' ),
		'zh' => array( 'name' => '中文', 'locale' => 'zh_CN', 'prefix' => 'zh-' ),
		'es' => array( 'name' => 'Español', 'locale' => 'es_ES', 'prefix' => 'es-' ),
	);
}

/**
 * Current language slug.
 *
 * @return string
 */
function bunjoin_current_language() {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );

		if ( is_string( $lang ) && isset( bunjoin_supported_languages()[ $lang ] ) ) {
			return $lang;
		}
	}

	return 'en';
}

/**
 * Translate a short theme string for the current language.
 *
 * @param string $text English source text.
 * @return string
 */
function bunjoin_t( $text ) {
	$lang = bunjoin_current_language();

	if ( 'en' === $lang ) {
		return $text;
	}

	$translations = bunjoin_translation_map();

	return isset( $translations[ $lang ][ $text ] ) ? $translations[ $lang ][ $text ] : $text;
}

/**
 * Translate rendered static theme copy when no gettext files are present yet.
 *
 * @param string $html Rendered HTML.
 * @return string
 */
function bunjoin_localize_rendered_html( $html ) {
	$lang = bunjoin_current_language();

	if ( 'en' === $lang || '' === $html ) {
		return $html;
	}

	$map = isset( bunjoin_translation_map()[ $lang ] ) ? bunjoin_translation_map()[ $lang ] : array();

	if ( empty( $map ) ) {
		return $html;
	}

	uksort( $map, static function ( $a, $b ) {
		return strlen( $b ) <=> strlen( $a );
	} );

	return strtr( $html, $map );
}

/**
 * Translation map for public static content.
 *
 * @return array<string, array<string, string>>
 */
function bunjoin_translation_map() {
	return array(
		'zh' => array(
			'Home' => '首页',
			'Products' => '产品',
			'Capabilities' => '制造能力',
			'Quality' => '质量',
			'About Us' => '关于我们',
			'Insights' => '行业洞察',
			'Contact Us' => '联系我们',
			'Request a Quote' => '获取报价',
			'Explore Our Products' => '查看产品',
			'Explore Products' => '查看产品',
			'View Details' => '查看详情',
			'Request Product Quote' => '获取产品报价',
			'Back to Products' => '返回产品',
			'Open section' => '打开栏目',
			'BunJoin' => 'BunJoin',
			'Cleaning Tablet OEM/ODM and Private Label' => '清洁片 OEM/ODM 与自有品牌',
			'Custom Cleaning Tablet Manufacturer' => '定制清洁片制造商',
			'BunJoin supports B2B buyers with OEM, ODM, and private label cleaning tablet projects, from formulation discussion and tablet format planning to packaging coordination and production documentation.' => 'BunJoin 为 B2B 买家提供 OEM、ODM 和自有品牌清洁片项目支持，覆盖配方讨论、片剂规格规划、包装协同和生产文件支持。',
			'OEM/ODM manufacturing support' => 'OEM/ODM 制造支持',
			'Private label packaging workflow' => '自有品牌包装流程',
			'Custom formula and sample review' => '定制配方与样品评估',
			'COA/SDS support when required' => '按项目需求支持 COA/SDS',
			'Core product categories' => '核心产品分类',
			'Cleaning Tablet Product Lines' => '清洁片产品线',
			'Build private label appliance and household cleaning tablet SKUs around clear product use cases and packaging goals.' => '围绕明确用途和包装目标，开发家电及家清清洁片自有品牌产品。',
			'Manufacturing capabilities' => '制造能力',
			'From OEM Brief to Market-Ready Packaging' => '从 OEM 需求到可上市包装',
			'Use BunJoin as a manufacturing partner for product development, tablet production, and private label packaging coordination.' => 'BunJoin 可作为产品开发、片剂生产和自有品牌包装协同的制造伙伴。',
			'Development process' => '开发流程',
			'From Product Concept to Mass Production' => '从产品概念到量产',
			'A structured cooperation flow helps B2B buyers move from early idea to approved formula, approved packaging, and planned production.' => '结构化合作流程帮助 B2B 买家从初步想法推进到配方确认、包装确认和生产计划。',
			'Quality and documentation' => '质量与文件',
			'Practical Quality Controls for B2B Orders' => '面向 B2B 订单的质量控制',
			'Who we serve' => '服务对象',
			'Built for Cleaning Brands and Channel Buyers' => '面向清洁品牌与渠道买家',
			'Why BunJoin' => '为什么选择 BunJoin',
			'A Focused Cleaning Tablet Manufacturing Partner' => '专注清洁片项目的制造伙伴',
			'Guides for Cleaning Tablet Buyers' => '清洁片买家指南',
			'Ready to discuss a private label cleaning tablet project?' => '准备讨论自有品牌清洁片项目？',
			'Send your product type, target market, formula direction, packaging requirements, and estimated quantity so the team can review the project scope.' => '请提供产品类型、目标市场、配方方向、包装要求和预估数量，以便评估项目范围。',
			'Cleaning Tablet Product Catalog' => '清洁片产品目录',
			'Product development' => '产品开发',
			'What Each Product Page Covers' => '每个产品页包含的内容',
			'Need a cleaning tablet category not listed here?' => '需要其他清洁片品类？',
			'OEM/ODM Cleaning Tablet Manufacturing Capabilities' => 'OEM/ODM 清洁片制造能力',
			'Quality Assurance and Product Documentation' => '质量保证与产品文件',
			'About BunJoin' => '关于 BunJoin',
			'Cleaning Tablet OEM/ODM Insights' => '清洁片 OEM/ODM 洞察',
			'Request a Cleaning Tablet Quote' => '提交清洁片报价需求',
			'Inquiry form' => '询盘表单',
			'Tell Us About Your Project' => '告诉我们你的项目',
			'Washing Machine Cleaner Tablets' => '洗衣机清洁片',
			'Dishwasher Cleaner Tablets' => '洗碗机清洁片',
			'Coffee Machine Cleaner Tablets' => '咖啡机清洁片',
			'Ice Machine Cleaner Tablets' => '制冰机清洁片',
			'Garbage Disposal Cleaner Tablets' => '厨余处理器清洁片',
			'Bottle Cleaner Tablets' => '水杯清洁片',
			'Navigation' => '导航',
			'Contact' => '联系方式',
			'Name' => '姓名',
			'Company' => '公司',
			'Business Email' => '商务邮箱',
			'Country/Market' => '国家/市场',
			'Product Type' => '产品类型',
			'Service Type' => '服务类型',
			'Estimated Order Quantity' => '预计订单数量',
			'Formula Requirements' => '配方要求',
			'Packaging Requirements' => '包装要求',
			'Target Launch Date' => '目标上市时间',
			'Message' => '留言',
			'Submit Inquiry' => '提交询盘',
		),
		'es' => array(
			'Home' => 'Inicio',
			'Products' => 'Productos',
			'Capabilities' => 'Capacidades',
			'Quality' => 'Calidad',
			'About Us' => 'Sobre Nosotros',
			'Insights' => 'Recursos',
			'Contact Us' => 'Contacto',
			'Request a Quote' => 'Solicitar Cotización',
			'Explore Our Products' => 'Ver Productos',
			'Explore Products' => 'Ver Productos',
			'View Details' => 'Ver Detalles',
			'Request Product Quote' => 'Solicitar Cotización',
			'Back to Products' => 'Volver a Productos',
			'Open section' => 'Abrir sección',
			'Cleaning Tablet OEM/ODM and Private Label' => 'Tabletas de limpieza OEM/ODM y marca privada',
			'Custom Cleaning Tablet Manufacturer' => 'Fabricante de Tabletas de Limpieza Personalizadas',
			'BunJoin supports B2B buyers with OEM, ODM, and private label cleaning tablet projects, from formulation discussion and tablet format planning to packaging coordination and production documentation.' => 'BunJoin apoya a compradores B2B con proyectos OEM, ODM y de marca privada para tabletas de limpieza, desde la formulación y el formato de la tableta hasta la coordinación del empaque y la documentación de producción.',
			'OEM/ODM manufacturing support' => 'Soporte de fabricación OEM/ODM',
			'Private label packaging workflow' => 'Flujo de empaque para marca privada',
			'Custom formula and sample review' => 'Fórmula personalizada y revisión de muestras',
			'COA/SDS support when required' => 'Soporte COA/SDS cuando se requiera',
			'Core product categories' => 'Categorías principales',
			'Cleaning Tablet Product Lines' => 'Líneas de Tabletas de Limpieza',
			'Build private label appliance and household cleaning tablet SKUs around clear product use cases and packaging goals.' => 'Desarrolle SKUs de marca privada para electrodomésticos y limpieza del hogar según usos claros y objetivos de empaque.',
			'Manufacturing capabilities' => 'Capacidades de fabricación',
			'From OEM Brief to Market-Ready Packaging' => 'Del brief OEM al empaque listo para mercado',
			'Use BunJoin as a manufacturing partner for product development, tablet production, and private label packaging coordination.' => 'Use BunJoin como socio de fabricación para desarrollo de productos, producción de tabletas y coordinación de empaque de marca privada.',
			'Development process' => 'Proceso de desarrollo',
			'From Product Concept to Mass Production' => 'Del concepto a la producción en masa',
			'A structured cooperation flow helps B2B buyers move from early idea to approved formula, approved packaging, and planned production.' => 'Un flujo estructurado ayuda a compradores B2B a avanzar desde la idea inicial hasta la fórmula, empaque y producción aprobados.',
			'Quality and documentation' => 'Calidad y documentación',
			'Practical Quality Controls for B2B Orders' => 'Controles de calidad prácticos para pedidos B2B',
			'Who we serve' => 'A quién servimos',
			'Built for Cleaning Brands and Channel Buyers' => 'Creado para marcas de limpieza y compradores de canal',
			'Why BunJoin' => 'Por qué BunJoin',
			'A Focused Cleaning Tablet Manufacturing Partner' => 'Un socio enfocado en tabletas de limpieza',
			'Guides for Cleaning Tablet Buyers' => 'Guías para compradores de tabletas de limpieza',
			'Ready to discuss a private label cleaning tablet project?' => '¿Listo para hablar de un proyecto de marca privada?',
			'Send your product type, target market, formula direction, packaging requirements, and estimated quantity so the team can review the project scope.' => 'Envíe el tipo de producto, mercado objetivo, dirección de fórmula, requisitos de empaque y cantidad estimada para revisar el alcance del proyecto.',
			'Cleaning Tablet Product Catalog' => 'Catálogo de Tabletas de Limpieza',
			'Product development' => 'Desarrollo de producto',
			'What Each Product Page Covers' => 'Qué cubre cada página de producto',
			'Need a cleaning tablet category not listed here?' => '¿Necesita otra categoría de tableta de limpieza?',
			'OEM/ODM Cleaning Tablet Manufacturing Capabilities' => 'Capacidades OEM/ODM para Tabletas de Limpieza',
			'Quality Assurance and Product Documentation' => 'Aseguramiento de Calidad y Documentación',
			'About BunJoin' => 'Sobre BunJoin',
			'Cleaning Tablet OEM/ODM Insights' => 'Recursos OEM/ODM de Tabletas de Limpieza',
			'Request a Cleaning Tablet Quote' => 'Solicitar Cotización de Tabletas de Limpieza',
			'Inquiry form' => 'Formulario de consulta',
			'Tell Us About Your Project' => 'Cuéntenos sobre su proyecto',
			'Washing Machine Cleaner Tablets' => 'Tabletas Limpiadoras para Lavadoras',
			'Dishwasher Cleaner Tablets' => 'Tabletas Limpiadoras para Lavavajillas',
			'Coffee Machine Cleaner Tablets' => 'Tabletas Limpiadoras para Cafeteras',
			'Ice Machine Cleaner Tablets' => 'Tabletas Limpiadoras para Máquinas de Hielo',
			'Garbage Disposal Cleaner Tablets' => 'Tabletas Limpiadoras para Trituradores',
			'Bottle Cleaner Tablets' => 'Tabletas Limpiadoras para Botellas',
			'Navigation' => 'Navegación',
			'Contact' => 'Contacto',
			'Name' => 'Nombre',
			'Company' => 'Empresa',
			'Business Email' => 'Correo empresarial',
			'Country/Market' => 'País/Mercado',
			'Product Type' => 'Tipo de producto',
			'Service Type' => 'Tipo de servicio',
			'Estimated Order Quantity' => 'Cantidad estimada',
			'Formula Requirements' => 'Requisitos de fórmula',
			'Packaging Requirements' => 'Requisitos de empaque',
			'Target Launch Date' => 'Fecha objetivo de lanzamiento',
			'Message' => 'Mensaje',
			'Submit Inquiry' => 'Enviar consulta',
		),
	);
}

/**
 * Main navigation fallback.
 *
 * @return array<int, array{label:string,path:string}>
 */
function bunjoin_get_nav_items() {
	return array(
		array( 'label' => bunjoin_t( 'Home' ), 'path' => '/' ),
		array( 'label' => bunjoin_t( 'Products' ), 'path' => '/products/' ),
		array( 'label' => bunjoin_t( 'Capabilities' ), 'path' => '/capabilities/' ),
		array( 'label' => bunjoin_t( 'Quality' ), 'path' => '/quality/' ),
		array( 'label' => bunjoin_t( 'About Us' ), 'path' => '/about-us/' ),
		array( 'label' => bunjoin_t( 'Insights' ), 'path' => '/insights/' ),
		array( 'label' => bunjoin_t( 'Contact Us' ), 'path' => '/contact-us/' ),
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
		'home'         => array( 'title' => 'Home', 'parent' => '', 'key' => 'home' ),
		'products'     => array( 'title' => 'Products', 'parent' => '', 'key' => 'products' ),
		'capabilities' => array( 'title' => 'Capabilities', 'parent' => '', 'key' => 'capabilities' ),
		'quality'      => array( 'title' => 'Quality', 'parent' => '', 'key' => 'quality' ),
		'about-us'     => array( 'title' => 'About Us', 'parent' => '', 'key' => 'about-us' ),
		'insights'     => array( 'title' => 'Insights', 'parent' => '', 'key' => 'insights' ),
		'contact-us'   => array( 'title' => 'Contact Us', 'parent' => '', 'key' => 'contact-us' ),
	);

	foreach ( bunjoin_get_products() as $slug => $product ) {
		$pages[ $slug ] = array(
			'title'  => $product['title'],
			'parent' => '',
			'key'    => $slug,
		);
	}

	return $pages;
}

/**
 * Get seed page title by language.
 *
 * @param string $key Page key.
 * @param string $lang Language slug.
 * @return string
 */
function bunjoin_get_seed_page_title( $key, $lang = 'en' ) {
	$pages = bunjoin_get_seed_pages();
	$title = isset( $pages[ $key ]['title'] ) ? $pages[ $key ]['title'] : ucwords( str_replace( '-', ' ', $key ) );

	if ( 'en' === $lang ) {
		return $title;
	}

	return isset( bunjoin_translation_map()[ $lang ][ $title ] ) ? bunjoin_translation_map()[ $lang ][ $title ] : $title;
}

/**
 * Get the slug used for a seed page in a language.
 *
 * @param string $key Page key.
 * @param string $lang Language slug.
 * @return string
 */
function bunjoin_get_seed_page_slug( $key, $lang = 'en' ) {
	if ( 'en' === $lang ) {
		return $key;
	}

	$languages = bunjoin_supported_languages();
	$prefix = isset( $languages[ $lang ]['prefix'] ) ? $languages[ $lang ]['prefix'] : $lang . '-';

	return $prefix . $key;
}

/**
 * Get a managed page key from a post or current query.
 *
 * @param WP_Post|null $post Optional post.
 * @return string
 */
function bunjoin_get_current_page_key( $post = null ) {
	$post = $post instanceof WP_Post ? $post : get_post();

	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$key = (string) get_post_meta( $post->ID, BUNJOIN_PAGE_KEY_META, true );

	if ( '' !== $key ) {
		return $key;
	}

	$slug = $post->post_name;
	$seed_pages = bunjoin_get_seed_pages();

	if ( isset( $seed_pages[ $slug ] ) ) {
		return $slug;
	}

	foreach ( bunjoin_supported_languages() as $lang => $language ) {
		$prefix = $language['prefix'];

		if ( '' !== $prefix && str_starts_with( $slug, $prefix ) ) {
			$maybe_key = substr( $slug, strlen( $prefix ) );

			if ( isset( $seed_pages[ $maybe_key ] ) ) {
				return $maybe_key;
			}
		}
	}

	return $slug;
}

/**
 * Find a managed page by key and language.
 *
 * @param string $key Page key.
 * @param string $lang Language slug.
 * @return int
 */
function bunjoin_get_page_id_by_key( $key, $lang = '' ) {
	$lang = $lang ? $lang : bunjoin_current_language();

	if ( 'home' === $key ) {
		$front_id = (int) get_option( 'page_on_front' );

		if ( $front_id ) {
			if ( function_exists( 'pll_get_post' ) ) {
				$translated_id = (int) pll_get_post( $front_id, $lang );

				if ( $translated_id ) {
					return $translated_id;
				}
			}

			if ( 'en' === $lang ) {
				return $front_id;
			}
		}
	}

	$query = new WP_Query( array(
		'post_type'              => 'page',
		'post_status'            => 'publish',
		'posts_per_page'         => 1,
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'meta_query'             => array(
			array(
				'key'   => BUNJOIN_PAGE_KEY_META,
				'value' => $key,
			),
		),
		'lang'                   => $lang,
	) );

	if ( ! empty( $query->posts[0] ) ) {
		return (int) $query->posts[0];
	}

	$page = get_page_by_path( $key, OBJECT, 'page' );

	if ( $page instanceof WP_Post ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$translated_id = (int) pll_get_post( $page->ID, $lang );

			if ( $translated_id ) {
				return $translated_id;
			}
		}

		if ( 'en' === $lang ) {
			return (int) $page->ID;
		}
	}

	$language_slug = bunjoin_get_seed_page_slug( $key, $lang );
	$page = get_page_by_path( $language_slug, OBJECT, 'page' );

	if ( $page instanceof WP_Post ) {
		return (int) $page->ID;
	}

	return 0;
}

/**
 * Render Polylang-aware language switcher.
 *
 * @return string
 */
function bunjoin_render_language_switcher() {
	$languages = bunjoin_supported_languages();
	$current = bunjoin_current_language();

	ob_start();
	?>
	<nav class="bunjoin-language-switcher" aria-label="<?php esc_attr_e( 'Language selector', 'bunjoin-child' ); ?>">
		<ul>
			<?php foreach ( $languages as $slug => $language ) : ?>
				<?php
				$url = '';
				if ( function_exists( 'pll_the_languages' ) ) {
					$pll_languages = pll_the_languages( array(
						'raw' => 1,
						'hide_if_empty' => 0,
					) );
					if ( isset( $pll_languages[ $slug ]['url'] ) ) {
						$url = $pll_languages[ $slug ]['url'];
					}
				}

				if ( ! $url ) {
					$url = bunjoin_get_language_url_for_key( bunjoin_get_current_page_key(), $slug );
				}
				?>
				<li>
					<a class="<?php echo esc_attr( $slug === $current ? 'is-active' : '' ); ?>" href="<?php echo esc_url( $url ); ?>" hreflang="<?php echo esc_attr( str_replace( '_', '-', $language['locale'] ) ); ?>">
						<?php echo esc_html( $language['name'] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<?php
	return ob_get_clean();
}

/**
 * Get a URL for a managed key in a target language.
 *
 * @param string $key Page key.
 * @param string $lang Language slug.
 * @return string
 */
function bunjoin_get_language_url_for_key( $key, $lang ) {
	$key = $key ? $key : 'home';
	$post_id = bunjoin_get_page_id_by_key( $key, $lang );

	if ( $post_id ) {
		return get_permalink( $post_id );
	}

	if ( function_exists( 'pll_home_url' ) ) {
		return pll_home_url( $lang );
	}

	$languages = bunjoin_supported_languages();
	$prefix = isset( $languages[ $lang ]['prefix'] ) ? $languages[ $lang ]['prefix'] : '';

	if ( 'en' === $lang ) {
		return 'home' === $key ? home_url( '/' ) : home_url( '/' . $key . '/' );
	}

	return home_url( '/' . $prefix . $key . '/' );
}

/**
 * Build a home_url for a path.
 *
 * @param string $path Path.
 * @return string
 */
function bunjoin_url( $path ) {
	$parts = wp_parse_url( $path );
	$clean_path = isset( $parts['path'] ) ? $parts['path'] : $path;
	$hash = isset( $parts['fragment'] ) ? '#' . $parts['fragment'] : '';
	$query = isset( $parts['query'] ) ? '?' . $parts['query'] : '';
	$key = trim( $clean_path, '/' );

	if ( '' === $key ) {
		if ( function_exists( 'pll_home_url' ) ) {
			return pll_home_url( bunjoin_current_language() ) . $query . $hash;
		}

		return home_url( '/' ) . $query . $hash;
	}

	$post_id = bunjoin_get_page_id_by_key( $key, bunjoin_current_language() );

	if ( $post_id ) {
		return get_permalink( $post_id ) . $query . $hash;
	}

	if ( function_exists( 'pll_home_url' ) ) {
		return trailingslashit( pll_home_url( bunjoin_current_language() ) ) . ltrim( $clean_path, '/' ) . $query . $hash;
	}

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
	return '<main id="primary" class="' . esc_attr( $class_attr ) . '">' . bunjoin_localize_rendered_html( $content ) . '</main>';
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

			<?php echo bunjoin_render_language_switcher(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a class="bunjoin-btn bunjoin-header-quote" href="<?php echo esc_url( $quote_url ); ?>"><?php esc_html_e( 'Request a Quote', 'bunjoin-child' ); ?></a>
		</div>
	</header>
	<?php
	return bunjoin_localize_rendered_html( ob_get_clean() );
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
	return bunjoin_localize_rendered_html( ob_get_clean() );
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
	return ob_get_clean();
}

/**
 * Dynamic page renderer.
 *
 * @return string
 */
function bunjoin_render_dynamic_page_content() {
	$key = bunjoin_get_current_page_key();

	if ( isset( bunjoin_get_products()[ $key ] ) ) {
		return bunjoin_render_product_detail_content( $key );
	}

	switch ( $key ) {
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
	$target_languages = array_keys( bunjoin_supported_languages() );
	$polylang_languages = array();

	if ( function_exists( 'pll_languages_list' ) ) {
		$polylang_languages = pll_languages_list( array( 'fields' => 'slug' ) );
		$target_languages = array_values( array_intersect( $target_languages, $polylang_languages ) );

		if ( empty( $target_languages ) ) {
			$target_languages = array( 'en' );
			$failed['polylang-languages'] = __( 'Polylang is active but English, Chinese, and Spanish languages are not configured yet.', 'bunjoin-child' );
		}
	}

	foreach ( bunjoin_get_seed_pages() as $slug => $page ) {
		$page_key = isset( $page['key'] ) ? $page['key'] : $slug;
		$translations = array();

		foreach ( $target_languages as $lang ) {
			$page_slug = bunjoin_get_seed_page_slug( $page_key, $lang );
			$page_title = bunjoin_get_seed_page_title( $page_key, $lang );
			$found = null;

			if ( 'en' === $lang && 'home' === $page_key ) {
				$front_id = (int) get_option( 'page_on_front' );
				$found = $front_id ? get_post( $front_id ) : get_page_by_path( $page_slug, OBJECT, 'page' );
			} else {
				$found = get_page_by_path( $page_slug, OBJECT, 'page' );
			}

			if ( $found instanceof WP_Post ) {
				update_post_meta( $found->ID, BUNJOIN_PAGE_KEY_META, $page_key );

				if ( function_exists( 'pll_set_post_language' ) ) {
					pll_set_post_language( $found->ID, $lang );
				}

				$existing[ $lang . ':' . $page_key ] = $page_title;
				$translations[ $lang ] = (int) $found->ID;

				if ( 'en' === $lang ) {
					$page_ids[ $page_key ] = (int) $found->ID;
				}

				continue;
			}

			$parent_id = 0;
			if ( $page['parent'] && isset( $page_ids[ $page['parent'] ] ) ) {
				$parent_id = absint( $page_ids[ $page['parent'] ] );
			}

			$page_id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page_title,
				'post_name'    => $page_slug,
				'post_parent'  => $parent_id,
				'post_content' => '',
			), true );

			if ( is_wp_error( $page_id ) ) {
				$failed[ $lang . ':' . $page_key ] = $page_id->get_error_message();
				continue;
			}

			update_post_meta( $page_id, BUNJOIN_PAGE_KEY_META, $page_key );

			if ( function_exists( 'pll_set_post_language' ) ) {
				pll_set_post_language( $page_id, $lang );
			}

			$created[ $lang . ':' . $page_key ] = $page_title;
			$translations[ $lang ] = absint( $page_id );

			if ( 'en' === $lang ) {
				$page_ids[ $page_key ] = absint( $page_id );
			}
		}

		if ( function_exists( 'pll_save_post_translations' ) && count( $translations ) > 1 ) {
			pll_save_post_translations( $translations );
		}
	}

	flush_rewrite_rules();

	return array(
		'created'  => $created,
		'existing' => $existing,
		'failed'   => $failed,
	);
}

/**
 * Check whether Polylang is installed.
 *
 * @return bool
 */
function bunjoin_is_polylang_installed() {
	return file_exists( WP_PLUGIN_DIR . '/polylang/polylang.php' );
}

/**
 * Install and activate the free Polylang plugin from WordPress.org.
 *
 * @return true|WP_Error
 */
function bunjoin_install_and_activate_polylang() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return new WP_Error( 'bunjoin_permissions', __( 'Current user cannot install plugins.', 'bunjoin-child' ) );
	}

	if ( ! bunjoin_is_polylang_installed() ) {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';

		$api = plugins_api( 'plugin_information', array(
			'slug'   => 'polylang',
			'fields' => array( 'sections' => false ),
		) );

		if ( is_wp_error( $api ) ) {
			return $api;
		}

		$upgrader = new Plugin_Upgrader( new Automatic_Upgrader_Skin() );
		$result = $upgrader->install( $api->download_link );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		if ( ! $result ) {
			return new WP_Error( 'bunjoin_polylang_install_failed', __( 'Polylang installation failed.', 'bunjoin-child' ) );
		}
	}

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( ! is_plugin_active( 'polylang/polylang.php' ) ) {
		$result = activate_plugin( 'polylang/polylang.php' );

		if ( is_wp_error( $result ) ) {
			return $result;
		}
	}

	return true;
}

/**
 * Get Polylang status for the setup screen.
 *
 * @return array{installed:bool,active:bool,languages:array<int,string>}
 */
function bunjoin_get_polylang_status() {
	$languages = array();

	if ( function_exists( 'pll_languages_list' ) ) {
		$languages = pll_languages_list( array( 'fields' => 'slug' ) );
	}

	return array(
		'installed' => bunjoin_is_polylang_installed(),
		'active'    => function_exists( 'pll_current_language' ),
		'languages' => is_array( $languages ) ? $languages : array(),
	);
}

/**
 * Ensure the three required Polylang languages exist.
 *
 * @return array{created:array<int,string>,existing:array<int,string>,failed:array<string,string>}
 */
function bunjoin_ensure_polylang_languages() {
	$created = array();
	$existing = array();
	$failed = array();

	if ( ! function_exists( 'PLL' ) || ! isset( PLL()->model ) ) {
		$failed['polylang'] = __( 'Polylang is not loaded yet. Reload the setup page and run the action again.', 'bunjoin-child' );
		return compact( 'created', 'existing', 'failed' );
	}

	$desired = array(
		'en' => array( 'locale' => 'en_US', 'name' => 'English', 'slug' => 'en', 'rtl' => 0, 'term_group' => 0, 'flag' => 'us' ),
		'zh' => array( 'locale' => 'zh_CN', 'name' => '中文', 'slug' => 'zh', 'rtl' => 0, 'term_group' => 1, 'flag' => 'cn' ),
		'es' => array( 'locale' => 'es_ES', 'name' => 'Español', 'slug' => 'es', 'rtl' => 0, 'term_group' => 2, 'flag' => 'es' ),
	);

	foreach ( $desired as $slug => $args ) {
		if ( PLL()->model->get_language( $slug ) ) {
			$existing[] = $slug;
			continue;
		}

		$language = PLL()->model->add_language( $args );

		if ( is_wp_error( $language ) ) {
			$failed[ $slug ] = $language->get_error_message();
			continue;
		}

		$created[] = $slug;
	}

	if ( method_exists( PLL()->model, 'update_default_lang' ) ) {
		PLL()->model->update_default_lang( 'en' );
	}

	flush_rewrite_rules();

	return compact( 'created', 'existing', 'failed' );
}

/**
 * Temporary admin-only autorun endpoint for this setup pass.
 */
function bunjoin_maybe_autorun_multilingual_setup() {
	if ( ! is_admin() || empty( $_GET['bunjoin_autorun'] ) || empty( $_GET['page'] ) || 'bunjoin-child-setup' !== $_GET['page'] ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$step = sanitize_text_field( wp_unslash( $_GET['bunjoin_autorun'] ) );

	if ( 'install' === $step ) {
		$result = bunjoin_install_and_activate_polylang();
		set_transient( 'bunjoin_autorun_plugin_result', is_wp_error( $result ) ? $result->get_error_message() : 'ok', 5 * MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'themes.php?page=bunjoin-child-setup&bunjoin_autorun=configure' ) );
		exit;
	}

	if ( 'configure' === $step ) {
		$language_result = bunjoin_ensure_polylang_languages();
		$page_result = bunjoin_create_missing_pages();
		set_transient( 'bunjoin_autorun_language_result', $language_result, 5 * MINUTE_IN_SECONDS );
		set_transient( 'bunjoin_autorun_page_result', $page_result, 5 * MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'themes.php?page=bunjoin-child-setup&bunjoin_autorun_done=1' ) );
		exit;
	}
}
add_action( 'admin_init', 'bunjoin_maybe_autorun_multilingual_setup' );

/**
 * Render setup admin page.
 */
function bunjoin_render_setup_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$result = null;
	$plugin_result = null;

	if ( isset( $_POST['bunjoin_seed_pages'] ) ) {
		check_admin_referer( 'bunjoin_seed_pages' );
		$result = bunjoin_create_missing_pages();
	}

	if ( isset( $_POST['bunjoin_install_polylang'] ) ) {
		check_admin_referer( 'bunjoin_install_polylang' );
		$plugin_result = bunjoin_install_and_activate_polylang();
	}

	$polylang_status = bunjoin_get_polylang_status();
	$autorun_plugin_result = get_transient( 'bunjoin_autorun_plugin_result' );
	$autorun_language_result = get_transient( 'bunjoin_autorun_language_result' );
	$autorun_page_result = get_transient( 'bunjoin_autorun_page_result' );

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'BunJoin Theme Setup', 'bunjoin-child' ); ?></h1>
		<p><?php esc_html_e( 'Create only missing pages for the BunJoin navigation, multilingual structure, SEO page keys, and product detail structure. Existing pages, menus, homepage settings, and content are not overwritten.', 'bunjoin-child' ); ?></p>

		<?php if ( ! empty( $_GET['bunjoin_autorun_done'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Autorun completed. Review Polylang status and page counts below.', 'bunjoin-child' ); ?></p>
				<p><?php echo esc_html( 'Plugin: ' . ( $autorun_plugin_result ? $autorun_plugin_result : 'not run in this request' ) ); ?></p>
				<?php if ( is_array( $autorun_language_result ) ) : ?>
					<p><?php echo esc_html( 'Languages created: ' . count( $autorun_language_result['created'] ) . '. Existing: ' . count( $autorun_language_result['existing'] ) . '. Failed: ' . count( $autorun_language_result['failed'] ) . '.' ); ?></p>
				<?php endif; ?>
				<?php if ( is_array( $autorun_page_result ) ) : ?>
					<p><?php echo esc_html( 'Pages created: ' . count( $autorun_page_result['created'] ) . '. Existing: ' . count( $autorun_page_result['existing'] ) . '. Failed: ' . count( $autorun_page_result['failed'] ) . '.' ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Polylang', 'bunjoin-child' ); ?></h2>
		<p>
			<?php
			printf(
				esc_html__( 'Installed: %1$s. Active: %2$s. Languages detected: %3$s.', 'bunjoin-child' ),
				$polylang_status['installed'] ? esc_html__( 'yes', 'bunjoin-child' ) : esc_html__( 'no', 'bunjoin-child' ),
				$polylang_status['active'] ? esc_html__( 'yes', 'bunjoin-child' ) : esc_html__( 'no', 'bunjoin-child' ),
				$polylang_status['languages'] ? esc_html( implode( ', ', $polylang_status['languages'] ) ) : esc_html__( 'none', 'bunjoin-child' )
			);
			?>
		</p>

		<?php if ( null !== $plugin_result ) : ?>
			<?php if ( is_wp_error( $plugin_result ) ) : ?>
				<div class="notice notice-error"><p><?php echo esc_html( $plugin_result->get_error_message() ); ?></p></div>
			<?php else : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Polylang is installed and active.', 'bunjoin-child' ); ?></p></div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! $polylang_status['active'] ) : ?>
			<form method="post">
				<?php wp_nonce_field( 'bunjoin_install_polylang' ); ?>
				<input type="hidden" name="bunjoin_install_polylang" value="1">
				<?php submit_button( __( 'Install and Activate Free Polylang', 'bunjoin-child' ) ); ?>
			</form>
			<p><?php esc_html_e( 'After activation, configure English, Chinese, and Spanish in Languages before creating multilingual pages.', 'bunjoin-child' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Recommended Polylang language slugs: en, zh, es.', 'bunjoin-child' ); ?></p>
		<?php endif; ?>

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
			<?php submit_button( __( 'Create Missing BunJoin Pages and Translations', 'bunjoin-child' ) ); ?>
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
