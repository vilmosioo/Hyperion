<?php

/*
* Main theme class
* 
* Loads default settings for the Hyperion theme 
*/
class Hyperion{
	
	function __construct() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );
		add_theme_support( 'menus' );
		add_theme_support( 'custom-header' );
		add_custom_background();
		add_editor_style();
		
		add_filter( 'post_thumbnail_html', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'image_send_to_editor', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'the_content', array( &$this, 'remove_thumbnail_dimensions' ), 10 );	
		add_filter( 'the_content', array( &$this, 'filter_ptags_on_images' ));
		add_action( 'login_head', array( &$this, 'registerLoginCSS' ));
		add_filter( 'admin_footer_text', array( &$this, 'remove_footer_admin' ));
		add_action( 'admin_head', array( &$this, 'registerAdminCSS' ));
		add_filter( "pre_update_option_category_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_tag_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_permalink_structure", array( &$this, "remove_blog_slug" ));
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
		echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/wp-login.css"/>';
	}

	// Customise the footer in admin area
	function remove_footer_admin () {
		echo get_avatar('cool.villi@gmail.com' , '40' );
		echo 'Theme designed and developed by <a href="http://vilmosioo.co.uk" target="_blank">Vilmos Ioo</a>';
	}

	// Custom CSS for the whole admin area (use to customise the theme options page)
	// Create wp-admin.css in your theme folder
	function registerAdminCSS() {
    	echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/admin/wp-admin.css"/>';
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

	// STATIC RESOURCES

	/* 
	* Nice arrays
	*
	* This function will print out a nicely formatted array
	*/
	static function print_pre($s) {
		echo '<pre>';
		print_r( $s );
		echo '</pre>';
	}

	/* 
	* A smart way to get the post thumbnail
	* 
	* If found, the function will retur the post thumbnail, 
	* else it will return the first image attached to the post
	*/
	static function post_thumbnail($full){
		if ( has_post_thumbnail() ) { 
			echo "<aside><a href='".get_permalink()."' title='".get_the_title()."' rel='canonical'>";
			the_post_thumbnail($full);
			echo "</a></aside>";
		} else { 
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

	/* 
	* Get a custom length excerpt
	*/
	static function custom_excerpt($s, $length){
		$temp = substr(strip_tags($s), 0, $length);
		if(strlen(strip_tags( $s ) ) > $length) $temp .= "&#0133;";
		return $temp; 
	}

	static function related_posts($id){
		$categories = get_the_category($id);
		$tags = get_the_tags($id);
		if ($categories || $tags) {
			$category_ids = array();
			if($categories) foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		 
			$tag_ids = array();
			if($tags) foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		 
			$args=array(
		 		'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => $category_ids
					),
					array(
						'taxonomy' => 'post_tag',
						'field' => 'id',
						'terms' => $tag_ids
					)
				),
		 		'post__not_in' => array($post->ID),
		 		'posts_per_page'=> 4, // Number of related posts that will be shown.
		 	);
		 
			$my_query = new WP_Query( $args );
		 	if( $my_query->have_posts() ) {
				echo "<h3>Related posts</h3><ul class='list related'>";
		 		while( $my_query->have_posts() ) {
		 			$my_query->the_post(); ?>
					<li>
						<?php Hyperion::post_thumbnail( 'thumbnail' ); ?>
						<a href='<?php the_permalink(); ?>' rel='canonical'><?php the_title();?></a>
					</li>
		 			<?php
		 		}
				echo "</ul><div class='clear'></div>";
			}
		}
		wp_reset_postdata();
	} 
}
?>