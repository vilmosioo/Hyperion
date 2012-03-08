<?php	
	$args = array( 'post_type' => 'portfolio-item', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );
	while ( $the_query->have_posts() ) : $the_query->the_post();
		$custom_fields = get_post_custom();
		$url = $custom_fields['url'];
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-item'); ?>>			<?php $img = wp_get_attachment_image_src ( get_post_thumbnail_id(), 'portfolio' ); echo "<aside><span class='img'><img src='".$img[0]."' /></span></aside>"; ?>
			<div class='content'>
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
				<a class='button blue' href='<?php echo $url[0]; ?>'>Visit site</a>	
			</div><!--.content-->
			<div class='clear'></div>
		</article><!--portfolio-item-->
<?php 	endwhile; 	wp_reset_postdata(); ?>			
