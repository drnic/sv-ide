<div id="sidebar">

<div id="colTwo">

<!---first/center column--->

<h4>site <span>search</span></h4>
<form method="get" id="sform" action="<?php bloginfo('home'); ?>/">
<div id="search"> <input type="text" id="q" value="<?php echo wp_specialchars($s, 1); ?>" name="s" size="15" > <input
class="button" value="Go" type="submit"> <br class="clear">
</div>
</form>


<h4><span>about</span> me</h4>
<p><?php query_posts('pagename=about');?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<p><?php the_excerpt();?></p>
<?php endwhile; endif; ?>  		
<br>
</p>


<h4>post <span>categories</span></h4>
<ul class="links">
<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
<li>
</li>
</ul>

<h4>monthly <span>archives</span></h4>
<ul class="links">
<?php wp_get_archives('type=monthly'); ?>
<li>
</li>
</ul>



<h4>recent <span>posts</span></h4>
<ul class="links">
<?php
// I love Wordpress so
query_posts('showposts=10');
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<li>
<a href="<?php the_permalink() ?>"><?php the_title() ?></a> on <span class="date"><?php the_time('M.d') ?></span> 
</li>
<?php endwhile; endif; ?>
</ul>
<br/>

<h4>recent <span>comments</span></h4>

<ul class="links">
<?php if (function_exists('get_recent_comments')) { ?>
<?php get_recent_comments(); ?>
<li>
</li>
<?php } ?>   

<br/>
<br/>

<h4>my <span>flickr</span></h4>
<br/>
<div id="flickr">
<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=4&amp;display=random&amp;size=s&amp;layout=x&amp;source=all_tag&amp;tag=art"></script>
</div>	
<br/>


</div>
</div>



