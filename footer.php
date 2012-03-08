		<footer role="contentinfo">
		<div class='container'>
			<?php dynamic_sidebar('H_footer'); ?>
			<div class='clear'></div>
			<hr/>
			<div class='fright'>
				<?php wp_nav_menu( array('menu' => 'H_main', 'container' => false, )); ?>
			</div>
			<p>Copyright Vilmos Ioo 2012</p>
		</div>
		</footer>

		<script defer src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
		<script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/twitter.json?callback=twitterCallback2&count=3"></script>

		<script> // Change UA-XXXXX-X to be your site's ID
		window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
		Modernizr.load({
		  load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
		});
		</script>
		
		<!--[if lt IE 7 ]>
		  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); ?>
	
	</body>
</html>
