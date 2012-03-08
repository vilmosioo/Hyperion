<?php	
	$args = array( 'post_type' => 'testimonial', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );
	while ( $the_query->have_posts() ) : $the_query->the_post();
?>
<blockquote id="post-<?php the_ID(); ?>" <?php post_class('hreview'); ?>>
	<p class='description item'><?php the_content(); ?></p>	<p class='name reviewer'><?php the_title(); ?></p>	
</blockquote>
<?php endwhile; wp_reset_postdata(); ?>			
