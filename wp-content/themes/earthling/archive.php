<?php 
get_header();
?>




<div id="content">
<div id="colOne">



<!---the loop--->

			<?php if (have_posts()) : ?>
	
			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h3>Archive for the '<?php echo single_cat_title(); ?>' Category </h3> <h4>(<em>Chronologically Listed</em>)</h4>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
			
		 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2>Archive for <?php the_time('F, Y'); ?></h2>
	
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2>Archive for <?php the_time('Y'); ?></h2>
			
			<?php /* If this is a search */ } elseif (is_search()) { ?>
			<h2>Search Results</h2>
			
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h2>Author Archive</h2>
	
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2>Blog Archives</h2>
	
			<?php } ?>

		 <ul class="dates">

		 	<?php while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> |
			<small>
			Posted by <?php the_author() ?> on <?php the_time('M d Y');?>
			</small>
			 
			</li>
		
			<?php endwhile; ?>
		</ul>
		
		<div class="navigation">
			<div class="left"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="right"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	
	<?php else : ?>

		<h1>Not Found</h1>

	<?php endif; ?>



<div class="clear"><p><br></p></div>

<!---end loop--->





</div>




<?php get_sidebar(); ?>

<?php get_footer(); ?>

