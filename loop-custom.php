<?php	
	$args = array( 'post_type' => 'custom-post', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );
	while ( $the_query->have_posts() ) : $the_query->the_post();
?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry entry article' ); ?>>

					<?php 
					if( is_sticky() ){ post_thumbdail( 'full' ); }
					else post_thumbdail( 'thumbnail' ); 
					?>

					<header>
						<h2 class='entry-title'><a href='<?php the_permalink(); ?>' rel='canonical'><?php the_title();?></a></h2>
					</header>
					
					<div class='entry-content'>
						<?php the_excerpt(); ?> 
					</div><!--.entry-content-->

					<a href='<?php the_permalink(); ?>' rel='canonical'>Continue reading &rarr;</a>
					<div class='clear'></div>

				</article><!--.hentry-->

<?php endwhile; wp_reset_postdata(); ?>			
