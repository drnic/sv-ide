<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>

				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>

				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->
<div id="ajax_comments">
<?php if ($comments) : ?>
	<h1>Comentarios</h1>
	<dl>

	<?php foreach ($comments as $comment) : ?>

		<dt class="autor <?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
				<span><cite><?php comment_author_link() ?></cite></span>
			<span class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('d/m/y') ?>(<?php comment_time() ?>)</a> <?php edit_comment_link('e','',''); ?></span>
		</dt>
		<dd class="text <?php echo $oddcomment; ?>">
				<?php if ($comment->comment_approved == '0') : ?>
				<em>Your comment is awaiting moderation.</em>
				<?php endif; ?>
				<br />
				<?php comment_text() ?>
		</dd>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>
</dl>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>
</div>

<?php if ('open' == $post->comment_status) : ?>


<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<h2 id="respond">Leave a Reply</h2>

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo ($comment_author)?$comment_author:"Name"; ?>" size="22" tabindex="1" />  <input type="text" name="email" id="email" value="<?php echo ($comment_author_email)?$comment_author_email:"eMail"; ?>" size="22" tabindex="2" /></p>

<p><input type="text" name="url" id="url" value="<?php echo ($comment_author_url)?$comment_author_url:"Url"; ?>" size="50" tabindex="3" /></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/utiles.js"></script>


<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
