<?php get_header(); ?>





	<div id="primary" class="single-post">
		<div class="inside">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="primary">
				<h1><?php the_title(); ?></h1>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
			</div>
			<hr class="hide" />
			
<div class="secondary">                     


<div class="spiffy_content">

							
				<div class="featured">
				
                                <h2 id="about-entry">About this post</h2>
					<p>You&rsquo;re currently reading &ldquo;<?php the_title(); ?>,&rdquo; an entry on <?php bloginfo('name'); ?></p>
					<dl>
						<dt>Published:</dt>
						<dd><?php the_time('n.j.y') ?> / <?php the_time('ga') ?></dd>
					</dl>
					<dl>
						<dt>Category:</dt>
						<dd><?php the_category(', ') ?></dd>
					</dl>
                                      <?php edit_post_link('Edit this entry.', '<dl><dt>Edit:</dt><dd> ', '</dd></dl>'); ?>
                                       
				</div><!-- //featured -->
			
</div><!-- //spiffy content -->

</div><!--//secondary  -->




			<div class="clear"></div>
			
			
		</div><!-- //inside -->
	</div><!-- // primary -->
	<!-- [END] #primary -->
	
	
	
	<hr class="hide" />
	
	<!--<div id="togglecomments" onClick="HideComments()"></div>-->
	
	
	
	<div id="secondary">
		<div class="inside">
			
			<?php if ('open' == $post-> comment_status) {
				// Comments are open ?>
				<div class="comment-head">
					<h2><?php comments_number('No comments','1 Comment','% Comments'); ?></h2>
					<span class="details"><a href="#comment-form">Jump to comment form</a> | <?php comments_rss_link('comments rss'); ?>  <?php if ('open' == $post->ping_status): ?>| <a href="<?php trackback_url(true); ?>">trackback uri</a> <br /><br /><br />
					
					<a onClick="HideComments()" class="toggle">Show / Hide Comments</a>
					
					
					<?php endif; ?></span>
				</div>
			<?php } elseif ('open' != $post-> comment_status) {
				// Neither Comments, nor Pings are open ?>
				<div class="comment-head">
					<h2>Comments are closed</h2>
					<span class="details">Comments are currently closed on this entry.</span>
				</div>	
			<?php } ?>
			
			<?php comments_template(); ?>
			
			<?php endwhile; else: ?>
			<h1>Sorry, no posts matched your criteria.</h1>
			<?php endif; ?>
		</div>
	</div>
	
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
