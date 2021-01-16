<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class OSPerformance extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
        add_action( 'init', array( $this, 'register_menus' ) );
        add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
        add_action( 'enqeueue_block_editor_assets', array( $this, 'setup_editor_styles' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

    }

    public function block_render_callback( $block, $content = '', $is_preview = false ) {
        $context = Timber::context();

        // Store block values.
        $context['block'] = $block;

        // Store field values.
        $context['fields'] = get_fields();

        // Store $is_preview value.
        $context['is_preview'] = $is_preview;

        $block_template = strtolower($block["title"]);
        // Render the block.
        Timber::render( "templates/blocks/$block_template.twig", $context );
    }

    public function setup_editor_styles() {
        wp_enqueue_style(
            'main-stylesheet',
            get_template_directory_uri() . '/dist/css/editor.css'
        );
    }

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
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

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

        add_theme_support( 'menus' );

        add_theme_support( 'align-wide' );


        /** Theme Colour Palette */
        add_theme_support( 'editor-color-palette', array(
            array(
                'name' => 'Light Grey',
                'slug' => 'light-grey',
                'color' => '#EEF1F0',
            ),
            array(
                'name' => 'grey',
                'slug' => 'grey',
                'color' => '#838CA2',
            ),
            array(
                'name' => 'Dark Grey',
                'slug' => 'dark-grey',
                'color' => '#272933',
            ),
            array(
                'name' => 'Gold',
                'slug' => 'gold',
                'color' => '#CA9750',
            ),
            array(
                'name' => 'Red',
                'slug' => 'red',
                'color' => '#E83333',
            ),
            array(
                'name' => 'Green',
                'slug' => 'green',
                'color' => '#5da569',
            ),
            array(
                'name' => 'White',
                'slug' => 'white',
                'color' => '#FFFFFF',
            ),
            array(
                'name' => 'Black',
                'slug' => 'black',
                'color' => '#000000',
            ),
        ) );
        add_theme_support( 'disable-custom-colors' );

    }

    /** Get colours formatted */
    public function output_the_colours() {
        // get the colors
        $colour_palette = current( (array) get_theme_support( 'editor-color-palette' ) );

        // bail if there aren't any colors found
        if ( !$colour_palette )
            return;

        // output begins
        ob_start();

        // output the names in a string
        echo '[';
            foreach ( $colour_palette as $colour ) {
                echo "'" . $colour['color'] . "', ";
            }
        echo ']';

        return ob_get_clean();
    }

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new OSPerformance();
