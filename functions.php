<?php

// ========================
// = nice formated arrays =
// ========================
if( !function_exists( 'print_pre' ) ) {
	function print_pre( $s ) {
		echo '<pre>';
		print_r( $s );
		echo '</pre>';
	}
}

// ========================
// = get a custom length excerpt
// ========================
if( !function_exists( 'custom_excerpt' ) ) {
	function custom_excerpt($s, $length){
		$temp = substr(strip_tags($s), 0, $length);
		if(strlen(strip_tags( $s ) ) > $length) $temp .= "&#0133;";
		return $temp; 
	}
}

// ========================
// = Removes attached image sizes 
// ========================
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

// Custom CSS for the login page
function LoginCSS() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/wp-login.css"/>';
}
add_action('login_head', 'LoginCSS');

// Customise the footer in admin area
function remove_footer_admin () {
	echo get_avatar('youremail@gmail.com' , '40' );
	echo 'Theme designed and developed by <a href="#" target="_blank">[Your name]</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Custom CSS for the whole admin area (use to customise the theme options page)
// Create wp-admin.css in your theme folder
function AdminCSS() {
    	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/wp-admin.css"/>';
}
add_action('admin_head', 'AdminCSS');

// Stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling
function filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// set up the theme options page
get_template_part( 'theme-options-page' ); 

// a smart way to get the post thumbnail
function post_thumbdail($full){
	if ( has_post_thumbnail() ) { 
		echo "<aside><a href='".get_permalink()."' title='".get_the_title()."' rel='canonical'>";
		the_post_thumbnail($full);
		echo "</a></aside>";
	}else{ 
		if( $full == 'full' ) return;
		
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'numberposts'     => 1,
			'post_parent' => get_the_ID(),
			'exclude'     => get_post_thumbnail_id()
		) );

		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$href = wp_get_attachment_image_src( $attachment->ID, $full);
			}
			echo "<aside><a class='default' href='".get_permalink()."' title='".get_the_title()."' rel='canonical'>";
			echo "<img src='".$href[0]."' alt='".get_the_title()."'/>"; 
			echo "</a></aside>";
		}
	
	}
}

//remove inline width and height added to images
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

// Removes attached image sizes as well
add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'H_main',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'H_footer',
		'before_widget' => '<div id="%1$s" class="widget grid-3 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}

function wpe_excerptlength_news($length) {
    return 15;
}

function wpe_excerptlength_teaser($length) {
    return 35;
}
function wpe_excerptlength_index($length) {
    return 160;
}
function wpe_excerptmore($more) {
    return '...<a href="'. get_permalink().'">Read More ></a>';
}

function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

if ( ! isset( $content_width ) ) $content_width = 1040;
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true );
add_theme_support( 'menus' );
add_theme_support( 'custom-header' );
add_custom_background();
add_editor_style();
 
register_post_type('custom-post', array(
	'label' => __('Custom post'),
	'singular_label' => __('Custom post'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'has_archive' => 'custom-post-index',
	'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields'),
));

?>