<?php/*========================================
Main loop used in every section of the theme (pages, posts, archives etc.)
To override this code, create the appropriate template in your theme folder. 
===========================================*/?>

<div id='main' role="main">
<div class='container'>

	<section class='content'>
	<header>
	<h1>

	<?php // Set the title ?>
	<?php if ( is_singular() || is_home() ) : ?> <?php single_post_title(); ?>
	<?php elseif ( is_category() ) : ?> Currently browsing: <?php single_cat_title(); ?>
	<?php elseif ( is_tag() ) : ?> Talking about: <?php single_cat_title(); ?>
	<?php elseif ( is_day() ) : ?><?php printf( __( '<span>Daily Archive</span>: %s' ), get_the_date() ); ?>
	<?php elseif ( is_month() ) : ?><?php printf( __( '<span>Monthly Archive</span>: %s' ), get_the_date('F Y') ); ?>
	<?php elseif ( is_year() ) : ?><?php printf( __( '<span>Yearly Archive</span>: %s' ), get_the_date('Y') ); ?>
	<?php elseif ( is_search() ) : ?> <?php printf( __( 'Search Results for: %s' ), '<span>' . get_search_query() . '</span>' ); ?>
	<?php endif; ?>

	</h1>
	</header>
	
	<?php 
	        // The query 
		global $wp_query;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array_merge( $wp_query->query, array( 'paged' => $paged ) );
		query_posts( $args ); 
			
		// The loop
		if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php if ( is_page() ) : ?>

			<?php the_content();?>
			<?php
				if( get_the_title() == 'Custom post index' ) get_template_part( 'loop' , 'custom' ); 
			?>

		<?php elseif ( is_single() ) : ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<aside class='aside meta'>Posted on <?php the_time(get_option('date_format')); ?> in <?php the_category(', '); ?> <?php the_tags(' &#8226; Talking about ', ', '); ?> &#8226; <a href='#comments'><?php comments_number('No Comments :(', 'One Comment', '% Comments' ); ?></a> &#8226; <a title="Permalink to <?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">Permalink</a> 
			</aside>

			<?php post_thumbdail( 'full' ); ?>
			<?php the_content();?>
			
			<aside class='share'>
				<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="segoe ui"></div>					<a href="https://twitter.com/share" class="twitter-share-button" data-via="ioowilly">Tweet</a>
			</aside>
			<aside class='aside' id='post-navigation'>
				<span class='fleft'><?php previous_post_link(); ?></span> 
				<span class='fright'><?php next_post_link(); ?></span> 
				<div class='clear'></div>
			</aside>

			<?php get_template_part( 'loop' , 'related' ); ?>
			
			<aside class='aside author'>
				<?php echo get_avatar( get_the_author_meta( 'email' ), '100' ); ?>
				<h4> About <strong><?php the_author_meta( 'display_name' ); ?></strong> </h4>
				<p> 
					<?php the_author_meta( 'description' ); ?>
					<a href='#' rel='canonical'>Find out more &rarr;</a> 
				</p>
				<div class='clear'></div>
			</aside>
			
			<?php comments_template(); ?>

			</article>

		<?php elseif ( is_archive() || is_home() || is_search() ) : ?>
				
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry entry article' ); ?>>

				<?php 
				if( is_sticky() && is_home() ){ post_thumbdail( 'full' ); }
				else post_thumbdail( 'thumbnail' ); 
				?>
					
				<header>
					<h2 class='entry-title'><a href='<?php the_permalink(); ?>' rel='canonical'><?php the_title();?></a></h2>
				</header>

				<div class='entry-content'>
					<?php the_excerpt(); ?> 
				</div>

				<a href='<?php the_permalink(); ?>' rel='canonical'>Continue reading &rarr;</a>
				<div class='clear'></div>

			</article>
			<?php endif; ?>
		
		<?php endwhile; ?>
		<?php if( function_exists( 'wp_pagenavi' ) ){ wp_pagenavi( array ( 'query' => $wp_query ) ); } ?>	
		<?php if ( $wp_query->max_num_pages > 1 && ( is_archive() || is_home() || is_search() ) ) : ?>
			<aside class='aside' id='post-navigation'>
				<span class='fleft'><?php previous_posts_link(); ?></span> 
				<span class='fright'><?php next_posts_link(); ?></span> 
				<div class='clear'></div>
			</aside>
		<?php endif; ?>
		
		<?php wp_reset_postdata(); ?>
		</section>

		<?php get_sidebar(); ?>
		<div class='clear'></div>
	</div>
</div>