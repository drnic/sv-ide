<?php get_header(); ?>
		
<!--BodyPan-->
<div id="bodyPan">
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
			<h1><a href="<?php the_permalink() ?>"><span><?php the_title(); ?></span></a></h1>
			<p class="bigtext"><?php the_time('F jS, Y') ?> <span><?php comments_popup_link('0', '1', '%'); ?></span></p>
			<div class="text">
				<?php the_content('continuar...'); ?>
			</div>
		  <?php if(is_home()): ?><p class="more"><a href="<?php the_permalink() ?>/#more">more</a></p><?php endif; ?>
		

		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries') ?></div>
		</div>

	<?php else : ?>

		<h3 class="center">Not Found</h3>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>

<?php if (is_single()) comments_template(); ?>
</div>
<div id="bodybottomPan">&nbsp;</div>

<!--BodyPan Close-->
<?php get_footer(); ?>







