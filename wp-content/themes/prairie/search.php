<?php get_header(); ?>

	<div id="primary" class="single-post">
	
	<div class="inside">
	
		<div class="primary">

	<?php if (have_posts()) : ?>

		<h1>Search Results</h1>
		
	
                     

 <div class="spiffy_content">
			
			<div class="insidespiffy">
		
		 	<?php while (have_posts()) : the_post(); ?>
			<h4>
			<a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4> - Pubished on <span class="date"><?php the_time('n.j.y') ?></span> in <span class="catfil"><?php the_category('and ') ?></span>
			
				
			
		<?php $results++; ?>
			<?php endwhile; ?>
			
			<br />
			
			</div><!-- // insidespiffy  -->
</div>

	

<div class="navigation">
			<div class="left"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="right"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
		
	

		
	
	<?php else : ?>

		<h1>No posts found. Try a different search?</h1>

	<?php endif; ?>
		
	</div>

	
	
<!-- ////////////  left block  ////////////  -->
	
	
<div class="secondary">                     



<div class="spiffy_content">

	
	
		<div class="featured">
				
                                <h2>Search</h2>
					<p>You searched for <span>&ldquo;<?php echo wp_specialchars($s, 1); ?>&rdquo;</span> at <?php bloginfo('name'); ?>. There were
			<?php
				if (!$results) echo "no results, better luck next time.";
				elseif (1 == $results) echo "one result found. It must be your lucky day.";
				else echo $results . " results found.";
			?>
			</p>
                                       
		</div><!-- //featured -->
	
	
</div><!-- //spiffy_content -->
	


</div><!-- //secondary -->


<!-- ////////////  left block  ////////////  -->
	
	
	
	
	
	
	
	<div class="clear"></div>
	</div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>