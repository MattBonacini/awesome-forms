<?php
/**
 * Awesome Forms functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Awesome_Forms
 */

if ( ! defined( 'AF_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'AF_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function awesome_forms_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Awesome Forms, use a find and replace
		* to change 'awesome-forms' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'awesome-forms', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'awesome-forms' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'awesome_forms_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'awesome_forms_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function awesome_forms_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'awesome_forms_content_width', 640 );
}
add_action( 'after_setup_theme', 'awesome_forms_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function awesome_forms_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'awesome-forms' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'awesome-forms' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'awesome_forms_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function awesome_forms_scripts() {
	wp_enqueue_style( 'awesome-forms-style', get_stylesheet_uri(), array(), AF_VERSION );
	wp_style_add_data( 'awesome-forms-style', 'rtl', 'replace' );

	wp_enqueue_script( 'awesome-forms-navigation', get_template_directory_uri() . '/js/navigation.js', array(), AF_VERSION, true );
	
	wp_enqueue_script( 'af-scripts', get_template_directory_uri() . '/js/scripts.js', array(), AF_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue necessary Google fonts assets, and fonts used in the theme.
	wp_enqueue_style( 'af-google-apis', 'https://fonts.googleapis.com/', array(), '' );

	wp_enqueue_style( 'af-google-gstatic', 'https://fonts.gstatic.com/', array(), '' );

	wp_enqueue_style( 'af-google-fonts', 'https://fonts.googleapis.com/css2?family=Arvo&family=Lato:wght@400;700&display=swap', array(), NULL);
}
add_action( 'wp_enqueue_scripts', 'awesome_forms_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Include necessary attribute to <link> for Google APIs
 * 
 * @since 1.0.0
 */
function af_loader_tag_filter_api($html, $handle) {
	if ($handle === 'af-google-apis') {
		return str_replace("rel='stylesheet'",
		"rel='preconnect'", $html);
	}
	return $html;
}
add_filter('style_loader_tag', 'af_loader_tag_filter_api', 10, 2);

/**
 * Include necessary attributes to <link> for Google GStatic
 * 
 * @since 1.0.0
 */
function af_loader_tag_filter_gstatic($html, $handle) {
	if ($handle === 'af-google-gstatic') {
		return str_replace("rel='stylesheet'",
		"rel='preconnect' crossorigin", $html);
	}
	return $html;
}
add_filter('style_loader_tag', 'af_loader_tag_filter_gstatic', 10, 2);

/**
 * Create a shortcode to display the video element.
 * 
 * @since 1.0.0
 */
function af_display_video($atts = []) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// Specifiy some default values that will be used if user doesn't use these parameters.
	$short_atts = shortcode_atts(
			array(
					'url' => '/wp-content/uploads/2022/08/Form-Pages-Addon-by-WPForms.mp4',
					'poster' => '/wp-content/uploads/2022/08/video-thumbnail-1.jpg',
			), $atts
	);
	ob_start();
	 	get_template_part( 'template-parts/video', null, array( 
			'url' => $short_atts['url'],
			'poster' => $short_atts['poster'],
		  )
		);
  return ob_get_clean();
}
add_shortcode('af-video' , 'af_display_video');


/**
 * Create a shortcode to display an icon.
 * 
 * @since 1.0.0
 */
function af_display_icon ($atts = []) {
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	
	// Specifiy some default values that will be used if user doesn't use these parameters.
	$short_atts = shortcode_atts(
		array(
			'icon' => 'eye'
		), $atts
	);
	
	ob_start();
		echo	af_get_inline_svg($short_atts['icon'] . '.svg');
	return ob_get_clean();

}
add_shortcode('af-icon' , 'af_display_icon');

/**
 * Global ACF Functions
 *
 * @since 1.0
 */

// Define path and URL to the ACF plugin.
define( 'AF_ACF_PATH', get_stylesheet_directory() . '/inc/acf/' );
define( 'AF_ACF_URL', get_stylesheet_directory_uri() . '/inc/acf/' );

// Include the ACF plugin.
include_once( AF_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'apc_acf_settings_url');
function apc_acf_settings_url($url)
{
	return AF_ACF_URL;
}

  /**
  * Register AF Blocks
  */
  function af_register_blocks() {
	/**
	 * Register Testimonial Block
	 */
	acf_register_block_type(array(
		'name'              => 'af-testimonial',
		'title'             => __('AF Testimonial'),
		'description'       => __('The testimonial block.'),
		'render_template'   => get_stylesheet_directory()  . '/template-parts/af-testimonial.php',
		'category'          => 'text',
		'icon'              => 'testimonial',
		'keywords'          => array( 'testimonial', 'testimonials', 'reviews' ),
		'mode' => 'auto',
		'supports' => array(
		'align' => false,
		),
	));
	}

add_action('acf/init', 'af_register_blocks');
