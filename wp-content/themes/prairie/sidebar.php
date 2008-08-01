<hr class="hide" />

<!--<div id="togglesidebar" onClick="HideSidebar()"></div>-->

	<div id="ancillary">
	
	<div class="inside">
	<a onClick="HideSidebar()" class="toggle">Show / Hide Navigation pane</a>
	</div>
	
		<div class="inside" id="navigationpane">
		
		


<div class="first block">
				
		
				
				<ul id="sidebar">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
 <li id="about">
  <h2>About</h2>
  <p>This is my blog.</p>
 </li>
 <li id="links">
  <h2>Links</h2>
  <ul>
   <li><a href="http://example.com">Example</a></li>
  </ul>
 </li>
<?php endif; ?>
</ul>
				
			
				
				
				
				
				
				
				
				
				
				
				<!--<h3>Previously</h3>
				<ul class="dates">
					<?php
						
						query_posts('showposts=5');
					?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink() ?>"><span class="date"><?php the_time('m.j') ?></span> <?php the_title() ?> </a></li>
					<?php endwhile; endif; ?>
				</ul>
			</div>

			<div class="block">
				<h3>Interests</h3>
				 <center><script type="text/javascript" src="http://del.icio.us/feeds/js/tags/krisandapril?sort=freq;count=26;size=12-20;color=808080-ff91bc;"></script></center>			
    		 </div>
							
						
                     
                           <div class="block">
				<h3>In Other News</h3>
				<ul class="counts">
					<script type="text/javascript" src="http://del.icio.us/feeds/js/krisandapril?extended;count=1"></script>
<noscript><a href="http://del.icio.us/krisandapril">my del.icio.us</a></noscript>
				
			</div>			
			<div class="clear"></div>
			-->
			
			
			
			
			
			
			
			
			
			
			
			
		</div>
	</div>
	<!-- [END] #ancillary -->	