<?php 
get_header();
?>


<!-- Hello you -->




	<? if (array_key_exists("sitemap", $_GET)) : ?>
     
            <?= all_posts_by_cat(); ?>
			<a href="./">Back to Home page</a>
 
<? else : ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>





<div class="post">
	 <div class="postop"><div class="pheadfill">&nbsp;</div></div>

							
							
							<div class="storycontent">

									 <h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> </h3>

									

								<div class="thecontent"><?php the_content(__('(more...)')); ?></div>
								
								<div class="themeta" id="d1"><span class="where">Filed under :</span> <?php the_category(',') ?><br /><span class="who">By</span> <?php the_author() ?><br />
								<span class="when-date">On</span> <?php the_date(); ?><br />
								<span class="when-hour">At</span> <?php the_time() ?><br />
								<!--<a href="<?php the_permalink(); ?>">Permalink for this post</a> <br />-->
								<span class="com">Comments :</span><?php comments_popup_link(__('<span class="noflavor"> 0</span>'), __('<span class="oneflavor">1 </span>'), __('<span class="areflavor"> % </span>')); ?><br />
								
								 <?php
								if (function_exists('related_posts')) {
								 ?><span class="related">Relative posts :</span> <ul><? related_posts(); ?></ul><br /><?
								}
								?>
									<?php if (is_single() && function_exists(UTW_ShowTagsForCurrentPost)) { ?>
									<span>Tags: <?php UTW_ShowTagsForCurrentPost("commalist") ?>.</span>
								<?php } ?>
								
								<?php edit_post_link('You can edit this post', '<span class="su">', '</span>'); ?>
								</div>

<div class="reset">&nbsp;</div>

							</div><!-- end STORYCONTENT -->

						

							
							
						
							


</div><!-- end POST -->





<?php comments_template(); // Get wp-comments.php template ?>


<?php endwhile; else: ?>
<p class="noposts"><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php
ob_start();
	bloginfo('template_directory');
	$path = ob_get_clean();
?>
<div id="pagination">
<?php posts_nav_link('&nbsp;','<img src="'.$path.'/img/previous.gif" alt="Previous page"/>','<img src="'.$path.'/img/next.gif" alt="Next page" />') ?>
</div>

<?php get_footer(); ?>

<? endif ?>