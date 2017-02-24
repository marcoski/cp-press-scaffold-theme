<?php
/**
 * CpPress theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Grandecocomero_theme
 */

require_once 'vendor/autoload.php';

function plugin_is_active($plugin_path) {
    $return_var = in_array( $plugin_path, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
    return $return_var;
}

function register_custom_post_types(\Commonhelp\DI\ContainerInterface $container){

}

if(plugin_is_active('cp-press'.DIRECTORY_SEPARATOR.'cp-press.php') && !is_admin()){
    $container = \CpPress\CpPress::$App->getContainer();
    /**
     * SET CUSTOM FILTERS HERE
     * i.e \CpPressTheme\Filters\WidgetFilters::add();
     */

}else if(plugin_is_active('cp-press'.DIRECTORY_SEPARATOR.'cp-press.php') && is_admin()){
    $container = \CpPress\CpPress::$App->getContainer();

    \CpPress\CpPress::$App->registerHook('admin_init', function() use ($container){
        /**
         * ADD SUPPORT FOR CUSTOM POST TYPE HERE
         * i.e
         * $course = $container->query('CoursePostType');
         * $course->addSupport(\CpPressTheme\PostTypes\Feature\GcFeatureFactory::course($container));
         */
    });

}

if(plugin_is_active('cp-press'.DIRECTORY_SEPARATOR.'cp-press.php')){
    $container = \CpPress\CpPress::$App->getContainer();
    /** unregister unused post types */

    /**
     * REGISTER CUSTOM POST TYPE SERVICE HERE
     * i.e
     * $container->registerService('CoursePostType', function($c){
     *  return new \CpPressTheme\PostTypes\CoursePostType();
     * });
     */

    \CpPress\CpPress::$App->registerHook('cppress_backend_setup', function() use ($container){
        register_custom_post_types($container);
    });
    \CpPress\CpPress::$App->registerHook('cppress_frontend_setup', function() use ($container){
        /**
         * SET CUSTOM FILTERS HERE
         * i.e \CpPressTheme\Filters\WidgetFilters::add();
         */
        register_custom_post_types($container);
    });
    \CpPress\CpPress::$App->registerHook('init', function() use ($container){
        /**
         * UN-REGISTER UNUSED CPPRESS POST TYPE
         * i.e
         * $news = $container->query('NewsPostType');
         * $news->unregister();
         */

    });
    \CpPress\CpPress::$App->execHooks();
}

if ( ! function_exists( 'cppress_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cppress_theme_setup() {
    /**
     * CHANGE cppress TEXT DOMAIN WITH YOUR SITE HERE
     */
	load_theme_textdomain( 'cppress', get_template_directory() . '/languages' );

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

    /**
     * REGISTER cppress PRIMARY NAV MENU WITH YOUR SITE NAME HERE
     */
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'cppress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
}
endif;
add_action( 'after_setup_theme', 'cppress_theme_setup' );


/**
 * Register widget area.
 * Change cppress with your site name
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cppress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cppress' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cppress' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'cppress_widgets_init' );

/**
 * Enqueue scripts and styles.
 * Register your custom script and plugin here.
 *
 * Change cppress with your site name both wp_enqueue_(style|script) and scripts or (style|less) filenames
 *
 * REMEMER TO SET CP_ENV CONSTANT TO THE RIGHT ENVIROMENT:
 *      - 'development': to load javascript less compiler for development
 *      - 'production': to load less css compiled stylesheet
 */
function cppress_scripts() {
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'selectbox', get_template_directory_uri() . '/plugin/selectbox/select_option.css' );

    wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
    wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.4.3', true );
    wp_enqueue_script( 'countdown', get_template_directory_uri() . '/plugins/countdown/jquery.syotimer.js', array('jquery'), '', true );
    wp_enqueue_script( 'counter-up', get_template_directory_uri() . '/plugins/counter-up/jquery.counterup.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'selectbox', get_template_directory_uri() . '/plugins/selectbox/jquery.selectbox.min.js', array('jquery'), '', true );

    wp_enqueue_script( 'cppress', get_template_directory_uri() . '/js/cppress.js', array('jquery'), '1.0.0', true );

    if(defined("CP_ENV") && CP_ENV == 'development'){
        wp_enqueue_style( 'cppress', get_stylesheet_directory_uri() . '/css/cppress.less', array(), '1.0.0' );
    }else if(defined("CP_ENV") && CP_ENV == 'presentation'){
        wp_enqueue_style( 'cppress', get_stylesheet_directory_uri() . '/css/cppress.css', array(), '1.0.0' );
    }
    if(defined("CP_ENV") && CP_ENV == 'development'){
        wp_enqueue_script( 'less', get_template_directory_uri() . '/js/less/less.min.js');
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'cppress_scripts' );

add_filter('style_loader_tag', function($tag, $handle){
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
        $tag = "<link rel='stylesheet/less' id='$handle' $title href='$href' type='text/css' media='$media' />\r\n";
    }
    return $tag;
}, 5, 2);

