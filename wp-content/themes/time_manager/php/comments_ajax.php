<?
if ($_POST['comment_post_ID'])
{
require( '../../../../wp-config.php' );
global $userdata;
      get_currentuserinfo();
$comment_post_ID = (int) $_POST['comment_post_ID'];

$status= $wpdb->get_row("SELECT post_status, comment_status FROM $wpdb->posts WHERE ID = '".$_POST['comment_post_ID']."'");
$commentCount = 1;
}

$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '".$_POST['comment_post_ID']."' ORDER BY comment_date");
	$oddcomment = 'alt';

if ($comments) : ?>
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
