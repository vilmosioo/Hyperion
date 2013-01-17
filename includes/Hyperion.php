<?php

/*
* Main theme class
* 
* Loads default settings for the Hyperion theme 
*/
class Hyperion{
	
	function __construct() {
		// customise theme
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );
		add_theme_support( 'menus' );
		add_theme_support( 'custom-header' );
		add_custom_background();
		add_editor_style();
	    
	    // add actions
		add_action( 'login_head', array( &$this, 'registerLoginCSS' ));
		add_action( 'admin_head', array( &$this, 'registerAdminCSS' ));
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_scripts_and_styles') );  

		//add filters
	    add_filter( 'post_thumbnail_html', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'image_send_to_editor', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'the_content', array( &$this, 'remove_thumbnail_dimensions' ), 10 );	
		add_filter( 'the_content', array( &$this, 'filter_ptags_on_images' ));
		add_filter( 'admin_footer_text', array( &$this, 'remove_footer_admin' ));
		add_filter( "pre_update_option_category_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_tag_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_permalink_structure", array( &$this, "remove_blog_slug" ));
	}

	function add_scripts_and_styles(){
		wp_register_script( 'modernizr', THEME_PATH.'/js/libs/modernizr-2.0.6.min.js', array(), '1.0', true ); 
		wp_register_script( 'default', THEME_PATH.'/js/script.js', array( 'jquery' ), '1.0', true ); 
		wp_register_style( 'font_awesome', THEME_PATH.'/css/font-awesome.min.css', array(), '1.0', 'all'); 

		wp_enqueue_script( 'modernizr' );  
		wp_enqueue_script( 'default' );  
		wp_enqueue_style( 'font_awesome' );  
	}

	// just check if the current structure begins with /blog/ remove that and return the stripped structure 
	function remove_blog_slug($tag_cat_permalink){
		if(!preg_match("/^\/blog\//",$tag_cat_permalink))
		return $tag_cat_permalink;
		$new_permalink=preg_replace ("/^\/blog\//","/",$tag_cat_permalink );
		return $new_permalink;
	}

	// Custom CSS for the login page	
	function registerLoginCSS() {
		echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/css/wp-login.css"/>';
	}

	// Customise the footer in admin area
	function remove_footer_admin () {
		echo get_avatar('cool.villi@gmail.com' , '40' );
		echo 'Theme designed and developed by <a href="http://vilmosioo.co.uk" target="_blank">Vilmos Ioo</a>';
	}

	// Custom CSS for the whole admin area (use to customise the theme options page)
	// Create wp-admin.css in your theme folder
	function registerAdminCSS() {
    	echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/css/wp-admin.css"/>';
	}
	
	// stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling
	function filter_ptags_on_images( $content ){
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}

	
	// remove attached image sizes 
	function remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
}
?>