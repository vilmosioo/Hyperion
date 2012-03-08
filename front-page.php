<?php get_header(); ?>

<div id='main'>
	<div class='container'>
		<?php $page = get_page_by_title( 'Home' ); ?>

		<?php echo $page -> post_content; ?>

		<div class='clear'></div>
		<?php dynamic_sidebar( 'H_home page' ); ?>
		<div class='clear'></div>

	</div>
</div>

<?php get_footer(); ?>
