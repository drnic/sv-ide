</div><!-- end MAIN -->
</div><!-- end CONTENT -->



<?php get_sidebar(); ?>

<div id="clearer">&nbsp;</div>

<div id="footer">


	 
	  <div class="fboxhead"><div class="fheadfill">&nbsp;</div></div> 

		<div id="footercontent">

				
				
				<div class="credit">
				<!--<?php echo $wpdb->num_queries; ?> queries. <?php timer_stop(1); ?> seconds. --> <?php echo sprintf(__("<a href='http://www.templatesbrowser.com/wordpress-themes/' title='Wordpress Themes'>Theme</a> downloaded from <a href='http://www.templatesbrowser.com/' title='Website Templates'>Templates Browser</a>"), __("Powered by WordPress, state-of-the-art semantic personal publishing platform.")); ?>
 - 
				<?php echo sprintf(__("<a href='http://www.itcouldbethisone.com' title='%s'>It could be this one</a>"), __("Cute, Fresh and Sweet themes to dress your wordpress")); ?>

				</div> <!-- end credit -->
	
	
				<!-- SITE CREDITS -->
				<div class="footermeta">

					<span class="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">Posts RSS</abbr>'); ?></a></span>
						<span class="rss"><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></span>
					
						

						<a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a>
						<a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>"><abbr title="WordPress">WP</abbr></a>
						<?php wp_meta(); ?>
						
					</div><!-- end footer meta -->
					<div class="resetfoot">&nbsp;</div>
		</div><!-- end footercontent-->


	

</div><!-- end FOOTER -->




<div class="reset2">&nbsp;</div>






</div><!-- end RAP -->


<?php credits(); do_action('wp_footer'); ?>


</body>
</html>