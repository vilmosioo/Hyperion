<?php
// define constants
define( 'THEME_PATH', get_bloginfo( 'stylesheet_directory' ) );
define( 'HOME_URL', home_url() );
if ( ! isset( $content_width ) ) $content_width = 1200;

require_once 'includes/Hyperion.php';
require_once 'includes/Theme_Options.php';
require_once 'includes/Utils.php';

class HyperionBasedTheme extends Hyperion{
	private $theme_options;
	
	/*
	The class constructor, fired after setup theme event.
	Will load all settings of the theme 
	*/
	function __construct(){	
		parent::__construct();

		add_shortcode('shortcode', array( &$this, 'some_shortcode' ));
		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );

		$this->theme_options = new Theme_Options();
		$this->theme_options->addTab(array(
			'name' => 'General',
			'slug' => 'general',
			'options' => array(
				'option1' => 'Option 1',
				'option2' => 'Option 2'
			)
		));

		$this->theme_options->addTab(array(
			'name' => 'Help',
			'slug' => 'help',
			'options' => array(
				'option3' => array(
					'name' => 'Option 3',
					'desc' => 'Some description'
				),
				'option4' => 'Option 4'
			)
		));
		$this->theme_options->render();

		$this->registerPostTypes(); 
	}

	// create custom shortcodes
	function some_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array('attribute' => 'default_value'), $atts));
		return "<div $attribute>".do_shortcode($content)."</div>";
	}

	// register post types
	function registerPostTypes(){
		register_post_type('custom', array(
			'label' => __('Custom post'),
			'singular_label' => __('Custom post'),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'has_archive' => 'custom',
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields'),
		));
	}

	/*
	* Register theme sidebars.
	*
	* Will register the main sidebar used for the blog,
	* the front page sidebar and the footer sidebar. 
	*/
	function register_sidebars(){
		if ( function_exists('register_sidebar') ) {
			register_sidebar(array(
				'name' => 'Main',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
			register_sidebar(array(
				'name' => 'Footer',
				'before_widget' => '<div id="%1$s" class="widget grid-3 %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			));
			register_sidebar(array(
				'name' => 'Front Page',
				'before_widget' => '<div id="%1$s" class="widget grid-3 %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}
	}
}

// Initialize the above class after theme setup
add_action( 'after_setup_theme', create_function( '', 'global $theme; $theme = new HyperionBasedTheme();' ) );

?>