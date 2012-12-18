 <?php
/*========================================
Page template
===========================================*/
get_header();
?>
<div id='main' role="main">
	<div class='container'>
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<header>
				<h1><?php the_title(); ?></h1>
			</header>
			<?php the_content();?>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>