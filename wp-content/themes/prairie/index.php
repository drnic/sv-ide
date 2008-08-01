<?php get_header(); ?>


	<div id="primary" class="twocol-stories">
		<div class="inside">
		
		
		
			<?php
				// Here is the call to only make two posts show up on the homepage REGARDLESS of your options in the control panel
				query_posts('showposts=2');
			?>
			<?php if (have_posts()) : ?>
				<?php $first = true; ?>
				<?php while (have_posts()) : the_post(); ?>
				
				
				
					<div class="story<?php if($first == true) echo " first" ?>">
					
					
						<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
						<?php the_excerpt() ?>
						
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="readthis"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/readthis.png" /></a>
						
						<div class="clear"></div>
						
						<div class="details">
							Posted at <?php the_time('ga \o\n n/j/y') ?> | <span class="commentlink"><?php comments_popup_link('<span>no comments</span>', '<span>1 comment</span>', '<span>% comments</span>'); ?></span> | Filed Under: <?php the_category(', ') ?>
						</div>
					</div>
					<?php $first = false; ?>
				<?php endwhile; ?>
				
			<?php else : ?>
		
				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		
			<?php endif; ?>
				
			<div class="clear"></div>
		</div>
	</div>
	<!-- [END] #primary -->



<?php get_sidebar(); ?>

<?php get_footer(); ?>
