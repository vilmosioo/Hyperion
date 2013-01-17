<?php
// STATIC RESOURCES

class Utils{
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
						<?php Utils::post_thumbnail( 'thumbnail' ); ?>
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