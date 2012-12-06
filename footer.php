		<footer role="contentinfo">
			<div class='container clearfix'>
				<?php dynamic_sidebar('Footer'); ?>
				<div class='clear'></div>
				<hr/>
				<div class='fright'>
					<?php wp_nav_menu( array('menu' => 'H_main', 'container' => false, )); ?>
				</div>
				<p>Copyright Vilmos Ioo 2012</p>
			</div>
		</footer>

		<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo THEME_PATH; ?>/js/lib/jquery-latest.min.js"%3E%3C/script%3E'))</script>
		<script src="<?php echo THEME_PATH; ?>/js/lib/modernizr2.6.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script defer src="<?php echo THEME_PATH; ?>/js/script.js"></script>
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
		<!--[if lte IE 8]>
  			<script src="<?php echo THEME_PATH; ?>/js/lib/selectivizr-min.js" type="text/javascript" charset="utf-8"></script>
		<![endif]-->

		<?php wp_footer(); ?>
	
	</body>
</html>
