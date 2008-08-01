<?php
/*
Plugin Name: Get Recent Comments
Version: 1.2
Plugin URI: http://blog.jodies.de/archiv/2004/11/13/recent-comments/
Author: Krischan Jodies
Author URI: http://blog.jodies.de
Description: Display the most recent comments or trackbacks with your own formatting in the sidebar. Visit <a href="options-general.php?page=get-recent-comments.php">Options/Recent Comments</a> after activation of the plugin.



*/

// WordPress 1.5 includes this file again on the options page. Avoid duplicate declaration:
if ( function_exists("is_plugin_page") && is_plugin_page() ) {
	kjgrc_options_page(); 
	return;
}


function kjgrc_subpage_gravatar() 
{
	$gravatar_checked[0] = '';
	$gravatar_checked[1] = '';
	$gravatar_checked[2] = '';
	$gravatar_checked[3] = '';
	$gravatar_checked[kjgrc_get_option('gravatar','rating')] = "checked=\"checked\" ";
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=5&amp;updated=true">

<input type="hidden" name="function" value="gravatar">
<fieldset class="options"> 
<legend>Settings for %gravatar</legend>
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top">
<th width="33%" scope="row"><?php _e('Size of Gravatars:') ?></th>
<td nowrap><input name="gravatar_size" type="text" value="<?php echo kjgrc_get_option("gravatar","size"); ?>" size="3" /> <?php _e('Pixel') ?><br />
Valid values are between 1 and 80 pixels.
</td>
</tr>
<tr valign="top"> 
        <th scope="row">Alternative URL:</th> 
        <td><input name="gravatar_alt_url" type="text" style="width: 95%" value="<?php echo kjgrc_get_option("gravatar","alt_url"); ?>" size="45" />
        <br />
This is an <strong>optional</strong> image that will be displayed if no gravatar is found. Enter the full URL (with http://). If left empty, gravatar.com returns a transparent pixel.</td> 
</tr> 
<tr>
        <th scope="row">Display gravatars up to this rating:</th> 
        <td> <label for="gravatar_rating0"><input name="gravatar_rating" id="gravatar_rating0" type="radio" value="0" <?php echo $gravatar_checked[0]; ?>/> G (All audiences)</label><br />
<label for="gravatar_rating1"><input name="gravatar_rating" id="gravatar_rating1" type="radio" value="1" <?php echo $gravatar_checked[1]; ?>/> PG</label><br />
<label for="gravatar_rating2"><input name="gravatar_rating" id="gravatar_rating2" type="radio" value="2" <?php echo $gravatar_checked[2]; ?>/> R</label><br />
<label for="gravatar_rating3"><input name="gravatar_rating" id="gravatar_rating3" type="radio" value="3" <?php echo $gravatar_checked[3]; ?>/> X</label></td> 
	</tr> 

</table>

</fieldset>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options') ?> &raquo;" />
</p>
</form> 
<?php
} // kjgrc_subpage_gravatar



function kjgrc_subpage_exclude_cat() 
{
	global $wpdb;
	$categories = $wpdb->get_results("SELECT * FROM $wpdb->categories ORDER BY cat_name");
	$exclude_cat = kjgrc_get_exclude_cat();
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=4&amp;updated=true">

<input type="hidden" name="function" value="exclude_cat">
<fieldset class="options"> 
<legend>Don't cite comments from the checked categories</legend>
<?php

	if ($categories) {
		foreach ($categories as $category) {
			$checked = '';
			if ($exclude_cat && in_array($category->cat_ID,$exclude_cat)) {
				$checked = 'checked="checked" ';
			}
			echo "<label for=\"\">\n";
			echo "<input name=\"exclude_category[]\" type=\"checkbox\" value=\"$category->cat_ID\" $checked/>";
			echo " $category->cat_name</label><br />\n";
		}
	}
?>
</fieldset>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options') ?> &raquo;" />
</p>
</form> 
<?php
} // kjgrc_subpage_exclude_cat

function kjgrc_subpage_grc() 
{
?>
<form method=post action="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;updated=true">
<input type="hidden" name="function" value="grc">
<fieldset class="options"> 
<legend id="grc"><?php _e('Recent Comments') ?></legend> 
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top">
<th width="33%" scope="row"><?php _e('Show the most recent:') ?></th>
<td nowrap><input name="max_comments" type="text" id="max_comments" value="<?php echo kjgrc_get_option("grc","max_comments"); ?>" size="3" /> <?php _e('comments') ?></td>
<td rowspan="3"><pre><div style='font-size: 10px; border-left: 1px solid; margin: 0px;'> %comment_excerpt - Shortened comment.
 %comment_link    - Link to the comment. 
 %comment_author  - Name left by the commenter
 %userid          - UserID of the commenter
 %gravatar        - Gravatar of the commenter, full img tag
 %gravatar_url    - Gravatar of the commenter, only url
 %comment_date    - Date of comment
 %comment_time    - Time of comment
 %author_url      - URL of author or trackback
 %post_title      - Title of the posting
 %post_link       - Link to the posting 
 %post_date       - Date of the posting</pre></div></td>
</tr>
<tr valign="top">
<th width="33%" scope="row"><?php _e('Long comments are chopped off at:') ?></th>
<td nowrap><input name="chars_per_comment" type="text" id="chars_per_comment" value="<?php echo kjgrc_get_option("grc","chars_per_comment"); ?>" size="3" /> <?php _e('characters') ?></td>
</tr>
<tr valign="top">
<th width="33%" scope="row"><?php _e('Wrap long words at:') ?></th>
<td nowrap><input name="chars_per_word" type="text" id="chars_per_word" value="<?php echo kjgrc_get_option("grc","chars_per_word"); ?>" size="3" /> <?php _e('characters') ?></td>
</tr>
<tr valign="top">
<th width="33%" scope="row">Template:
<td>&nbsp;</td>
</tr>
<tr valign="top">
<td colspan="3">
       <textarea name="format" cols="60" rows="2" id="format" style="width: 98%; font-size: 12px;" class="code"><?php echo stripslashes(htmlspecialchars(kjgrc_get_option("grc","format"))); ?></textarea><br />
<fieldset>
<legend>Result</legend>
<span class="code"><?php $result = get_recent_comments(1,1,"",1); echo htmlspecialchars(stripslashes($result)); ?></span>
</fieldset>
</td>         
</tr>
</table>
<p class="submit">
<input type="submit" id="deletepost" name="reset_template" value="<?php _e('Reset template to default') ?> &raquo;" onclick="return confirm('You are about to reset your template for \'Recent Comments\'.\n  \'Cancel\' to stop, \'OK\' to delete.')" />
<input type="submit" name="Submit" value="<?php _e('Update Recent Comments Options') ?> &raquo;" />
</p>
</fieldset>
</form>

<?php
} // kjgrc_subpage_grc 

function kjgrc_subpage_grt () 
{
?>

<form name="trackback_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;updated=true&amp;subpage=2">
<input type="hidden" name="function" value="grt">
<fieldset class="options"> 
<legend id="grt"><?php _e('Recent Trackbacks') ?></legend> 
<table width="100%" cellspacing="2" cellpadding="5" class="editform">
<tr valign="top">
<th width="33%" scope="row"><?php _e('Show the most recent:') ?></th>
<td nowrap><input name="max_comments" type="text" id="max_comments" value="<?php echo kjgrc_get_option("grt","max_comments"); ?>" size="3" /> <?php _e('Trackbacks') ?></td>
<td rowspan="3"><pre><div style='font-size: 10px; border-left: 1px solid; margin: 0px;'> %comment_excerpt - Shortened comment.
 %comment_link    - Link to the comment.
 %comment_author  - Name left by the commenter
 %comment_date    - Date of comment
 %comment_time    - Time of comment
 %author_url      - URL of author or trackback
 %trackback_title - Title of trackback
 %post_title      - Title of the posting
 %post_link       - Link to the posting
 %post_date       - Date of the posting</pre></div></td>
</tr>
<tr valign="top">
<th width="33%" scope="row"><?php _e('Long trackbacks are chopped off at:') ?></th>
<td nowrap><input name="chars_per_comment" type="text" id="chars_per_comment" value="<?php echo kjgrc_get_option("grt","chars_per_comment"); ?>" size="3" /> <?php _e('characters') ?></td>
</tr>
<tr valign="top">
<th width="33%" scope="row"><?php _e('Wrap long words at:') ?></th>
<td><input name="chars_per_word" type="text" id="chars_per_word" value="<?php echo kjgrc_get_option("grt","chars_per_word"); ?>" size="3" /> <?php _e('characters') ?></td>
</tr>
<tr valign="top">
<th width="33%" scope="row"><?php _e('Ignore trackbacks originating from this ip address:') ?></th>
<td><input name="ignore_ip" type="text" id="ignore_ip" value="<?php echo kjgrc_get_option("grt","ignore_ip"); ?>" size="16" /><br><span style='font-size: 10px;'>Insert the <a href="javascript:;" onmousedown="document.trackback_form.ignore_ip.value='<?php global $HTTP_SERVER_VARS; echo $HTTP_SERVER_VARS['SERVER_ADDR']; ?>';">address of your webserver</a> to filter pingbacks from your own posts</span></td>
</tr>
<tr valign="top">
<th width="33%" scope="row">Template:
<td>&nbsp;</td>
</tr>
<tr valign="top">
<td colspan="3">
       <textarea name="format" cols="60" rows="2" id="format" style="width: 98%; font-size: 12px;" class="code"><?php echo stripslashes(htmlspecialchars(kjgrc_get_option("grt","format"))); ?></textarea><br />
<fieldset>
<legend>Result</legend>
<span class="code"><?php $result = get_recent_trackbacks(1); echo htmlspecialchars(stripslashes($result)); ?></span>
</fieldset>
</td>         
</tr>
</table>
<p class="submit">
<input type="submit" id="deletepost" name="reset_template" value="<?php _e('Reset template to default') ?> &raquo;" onclick="return confirm('You are about to reset your template for \'Recent Trackbacks\'.\n  \'Cancel\' to stop, \'OK\' to delete.')" />
<input type="submit" name="Submit" value="<?php _e('Update Recent Trackbacks Options') ?> &raquo;" />
</p>
</form>   
</fieldset>

<?php 
} //kjgrc_subpage_grt

function kjgrc_subpage_instructions () 
{
?>   
<fieldset>
<legend><?php _e('Instructions') ?></legend>
<p><strong>1. What this plugin does</strong></p>
It offers you two functions that you can add to your template: get_recent_comments() and get_recent_trackbacks(). They fetch the most recent comments or most recent trackbacks/pingbacks from the database and display them in a configurable formatting. The formatting is configured by two templates that use a number of macros. The macros are replaced by the acutal content in the output.

<p><strong>2. Adding the Plugin to the WordPress Template</strong></p>

<p>
You need to insert one of the following  code snippets into the sidebar template. Which one is the right depends on the <a href="themes.php">theme</a> you are using.
</p>

<em>Default Theme:</em> <span class="code">wp-content/themes/default/sidebar.php</span>
<div style="border: 1px solid; border-color: #ccc; margin: 15px; background: #eee;">
<pre class="code">
&lt;?php if (function_exists('get_recent_comments')) { ?&gt;
&lt;li&gt;&lt;h2&gt;&lt;?php _e('Recent Comments:'); ?&gt;&lt;/h2&gt;
&lt;ul&gt;
&lt;?php get_recent_comments(); ?&gt;
&lt;/ul&gt;
&lt;/li&gt;
&lt;?php } ?&gt;   

&lt;?php if (function_exists('get_recent_trackbacks')) { ?&gt;
&lt;li&gt;&lt;h2&gt;&lt;?php _e('Recent Trackbacks:'); ?&gt;&lt;/h2&gt;
&lt;ul&gt;
&lt;?php get_recent_trackbacks(); ?&gt;
&lt;/ul&gt;
&lt;/li&gt;
&lt;?php } ?&gt;
</pre>
</div>

<em>Classic Theme:</em> <span class="code">wp-content/themes/classic/sidebar.php</span>
<div style="border: 1px solid; border-color: #ccc; margin: 15px; background: #eee;">
<pre class="code">
&lt;?php if (function_exists('get_recent_comments')) { ?&gt;
&lt;li&gt;&lt;?php _e('Recent Comments:'); ?&gt;
&lt;ul&gt;
&lt;?php get_recent_comments(); ?&gt;
&lt;/ul&gt;
&lt;/li&gt;
&lt;?php } ?&gt;

&lt;?php if (function_exists('get_recent_trackbacks')) { ?&gt;
&lt;li&gt;&lt;?php _e('Recent Trackbacks:'); ?&GT;
&lt;ul&gt;
&lt;?php get_recent_trackbacks(); ?&gt;
&lt;/ul&gt;
&lt;/li&gt;
&lt;?php } ?&gt;
</pre>
</div>
<p><strong>3. Using the Macros</strong></p>
The macros will be replaced by certain words, coming from the comment content itself, or the posting, that was commented.
<p/>
<table>
<tr><td valign="top">%comment_excerpt</td><td>The text of the comment. It might get shorted to the number of characters you entered in <em>"Long comments are chopped off at..."</em></td></tr>
<tr><td valign="top">%comment_link</td><td>The URL to the cited comment.</td></tr> 
<tr><td valign="top">%comment_author</td><td>The name, the commenter entered in the comment form. If she left the field empty, the name is "Anonymous".</td></tr>
<tr><td valign="top">%gravatar</td><td>This macro becomes a complete image tag. If the comment author registered a gravatar with <a href="http://www.gravatar.com">gravatar.com</a>. Example:<br />&lt;img src=&quot;http://www.gravatar.com/avatar.php?gravatar_id=1ebbd34d4e45cac&amp;size=25&amp;rating=X&quot;/&gt;  </td></tr>
<tr><td valign="top">%gravatar_url</td><td>This macro becomes only the URL to the gravatar. Example:<br />http://www.gravatar.com/avatar.php?gravatar_id=1ebbd34d4e45cac&amp;size=25&amp;rating=X</td></tr>
<tr><td valign="top">%userid</td><td>If the comment author is registered with your wordpress, and was logged in, when she wrote the comment this is replaced with the user id, she has in WordPress. The user id's are listed here: <a href="users.php">users.php</a>. You can do fancyful things with this macro. For example you may construct an image url, that points to pictures of all the authors of your blog: &lt;img src=&quot;/images/user%userid.jpg&quot;&gt;</td></tr>
<tr><td valign="top">%comment_date</td><td>The date, when the comment was posted in the style you configured as <a href="options-general.php">default date format</a>.</td></tr>
<tr><td valign="top">%comment_time</td><td>The time, when the comment was posted</td></tr>
<tr><td valign="top">%author_url</td><td>The URL, the comment author left in the comment form, or if the comment is a trackback, the URL of the site that issued the trackback.</td></tr>
<tr><td valign="top">%post_title</td><td>The title of the posting that was commented.</td></tr>
<tr><td valign="top">%post_link</td><td>The URL of the posting that was commented.</td></tr> 
<tr><td valign="top">%post_date</td><td>The date when the commented posting was published.</td></tr>
<tr><td valign="top">%trackback_title</td><td>Only applicable in trackbacks: The title of the trackback. It  might get shorted to the number of characters you entered in <em>"Long trackbacks are chopped off at..."</em></td></tr>
</table>

<p><strong>4. Miscellaneous</strong></p>
<ul>
<li>The path to the sidebar.php file may differ from the above examples if you installed a localized version of WordPress.</li>
<li>It is hard to extract title and content from pingbacks. Please contact the <a href="http://blog.jodies.de/archiv/2004/11/13/recent-comments/">author</a> if you are getting weird results.</li>
<li>The plugin treats trackbacks and pingbacks different than comments. Older versions of the plugin (and WordPress) made no difference between comments an trackbacks.</li>
<li>Pingbacks are also shown as Trackbacks.</li>
<li>Don't worry if you screwed up the template, reset the template to default and try again.</li>
<li>If you are used to an old (pre WordPress 1.5) version of the plugin, you will asked yourself, what happend to the configurable arguments in the get_recent_comments() function call. They are ignored now. You can delete them.</li>
<li><em>"Wrap long words at..."</em> means: Cited words, that exceed this length are split into fragments to prevent damage to the layout of your blog.</li>
<li>"<em>Ignore trackbacks originating from this ip address</em>" on the configuration page for recent trackbacks is useful for filtering out pingbacks that occur when you have a link to your own site in a post.</li>
</ul>
</fieLdset>
</div>  

<?php  
}

function kjgrc_subpage_header ($kjgrc_selected_tab) {
	$current_tab[$kjgrc_selected_tab] = "class=\"current\"";
?>
<style>
<!--
#adminmenu3 li {
        display: inline;
        line-height: 200%;
        list-style: none;
        text-align: center;
}

#adminmenu3 {
background: #a3a3a3;
border-top: 2px solid #707070;
border-bottom: none;
height: 21px;
margin: 0;
padding: 0 4em;
}
											   
#adminmenu3 .current {
background: #f2f2f2;
border-right: 2px solid #4f4f4f;
color: #000;
}
											   
#adminmenu3 a {
border: none;
color: #fff;
font-size: 12px;
padding: 3px 5px 4px;
}
											   
#adminmenu3 a:hover {
background: #f0f0f0;
color: #393939;
}
											   
#adminmenu3 li {
line-height: 170%;
}
-->
</style>
<ul id="adminmenu3">
   <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=1" <?php echo $current_tab[1] ?>>Comments</a></li>
   <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=2" <?php echo $current_tab[2] ?>>Trackbacks</a></li>
   <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=3" <?php echo $current_tab[3] ?>>Instructions</a></li>
   <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=4" <?php echo $current_tab[4] ?>>Excluded Categories</a></li>
   <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=get-recent-comments.php&amp;subpage=5" <?php echo $current_tab[5] ?>>Gravatars</a></li>
</ul>
<div class="wrap">
<!--<h2><?php _e('Options for Get Recent Comments Plugin') ?></h2>-->
<?php
}

function kjgrc_options_page ()
{
?>
<?php
	$function = $_POST['function'];
	if (isset($_GET['updated']) && ($_GET['updated'] == 'true') && 
		(!empty($_POST['max_comments'])) && 
		(!empty($_POST['chars_per_comment'])) &&         
		(!empty($_POST['chars_per_word'])) && 
		(!empty($_POST['format'])) &&
		(!empty($_POST['function'])) )
	{
		if (($function == 'grc') ||
		    ($function == 'grt'))
		{
			if (!empty($_POST['reset_template'])) {
				delete_option('kjgrc_'.$function.'_format');
			} else {
				update_option('kjgrc_'.$function.'_max_comments', (int)$_POST['max_comments']);
				update_option('kjgrc_'.$function.'_chars_per_comment', (int)$_POST['chars_per_comment']);
				update_option('kjgrc_'.$function.'_chars_per_word', (int)$_POST['chars_per_word']);
				update_option('kjgrc_'.$function.'_format', $_POST['format']);
			}
		} 
	}
	if (isset($_GET['updated']) && ($_GET['updated'] == 'true'))
	{
	   	if ($function == 'exclude_cat') 
        	{
			if (count($_POST['exclude_category']) == 0) {
				update_option('kjgrc_misc_exclude_cat','');
			} else {
				update_option('kjgrc_misc_exclude_cat',implode(" ",$_POST['exclude_category']));
			}
        	}
		if ($function == 'gravatar') {
			if ($_POST['gravatar_size'] > 0 && $_POST['gravatar_size'] < 81) {
				update_option('kjgrc_gravatar_size',$_POST['gravatar_size']);
			}
			update_option('kjgrc_gravatar_alt_url',$_POST['gravatar_alt_url']);
			update_option('kjgrc_gravatar_rating',$_POST['gravatar_rating']);
		}
		if ($function == 'grt' && isset($_POST['ignore_ip']))
		{
			update_option('kjgrc_grt_ignore_ip',trim($_POST['ignore_ip']));
		}
	}
	$kjgrc_subpage = 1;
	if (isset($_GET['subpage'])) {
		$kjgrc_subpage = $_GET['subpage'];
	}
	kjgrc_subpage_header($kjgrc_subpage);
	if ($kjgrc_subpage == 1) {
		kjgrc_subpage_grc(); 
	} elseif ($kjgrc_subpage == 2) {
		kjgrc_subpage_grt();
	} elseif ($kjgrc_subpage == 3) {
		kjgrc_subpage_instructions();
	} elseif ($kjgrc_subpage == 4) {
		kjgrc_subpage_exclude_cat();
	} elseif ($kjgrc_subpage == 5) {
		kjgrc_subpage_gravatar();
	}
}

function kjgrc_add_options_page() 
{
	if (function_exists('add_options_page')) {
		// WordPress 1.5 sometimes doesn't show the options page if called in the first style
		if ( $wp_version > "1.5" ) {
			add_options_page('Get Recent Comments Plugin', 'Recent Comments', 8, basename(__FILE__),'kjgrc_options_page');
		} else {
			add_options_page('Get Recent Comments Plugin', 'Recent Comments', 8, basename(__FILE__));
		}
	}
}


function kjgrc_get_option($section,$option_name)
{
	global $kjgrc_options_initialized;
	if ($kjgrc_options_initialized == 0) {
		add_option('kjgrc_grc_max_comments',5);
		add_option('kjgrc_grc_chars_per_comment',120);
		add_option('kjgrc_grc_chars_per_word',30);
		add_option('kjgrc_grc_format',
	 		'<li><a href="%comment_link" title="%post_title, %post_date">%comment_author</a>: %comment_excerpt</li>');

		add_option('kjgrc_grt_max_comments',5);
		add_option('kjgrc_grt_chars_per_comment',120);
		add_option('kjgrc_grt_chars_per_word',30);
		add_option('kjgrc_grt_format',
			'<li><a href="%comment_link" title="Trackback to &quot;%post_title&quot;: %comment_excerpt">%comment_author</a>: %trackback_title</li>');
		add_option('kjgrc_misc_exclude_cat','');
		add_option('kjgrc_gravatar_size',20);
		add_option('kjgrc_gravatar_alt_url','');
		add_option('kjgrc_gravatar_rating',0);
		$kjgrc_options_initialized = 1;
	}
	$option = get_option("kjgrc_" . $section . "_" . $option_name);
	return $option;
}

function kjgrc_get_exclude_cat ()
{
	$exclude_cat = kjgrc_get_option('misc','exclude_cat');
	if ($exclude_cat == '') {
		return FALSE;
	}
	#echo "cats: '". kjgrc_get_option('misc','exclude_cat') ."' ";
	return explode(" ",kjgrc_get_option('misc','exclude_cat'));
}

/*        if (function_exists('get_recent_trackbacks')) {
   echo "<strong>Warning: You have multiple plugins with a function &quot;get_recent_trackbacks()&quot;</strong>";
   return;
}
*/
function get_recent_trackbacks($sample=0)
{
	global $tablecomments,$tableposts,$tablepost2cat;

	// WordPress 1.2.x has no is_plugin_page
	if (! function_exists("is_plugin_page")) {
		$chars_per_word = 30;
	} else {
		$max_comments = kjgrc_get_option("grt","max_comments");
		$chars_per_comment = kjgrc_get_option("grt","chars_per_comment");
		$chars_per_word = kjgrc_get_option("grt","chars_per_word");
		$format = stripslashes(kjgrc_get_option("grt","format"));
		$exclude_cat = kjgrc_get_exclude_cat();
		if ($exclude_cat) {
			$sql_join_post2cat = "LEFT JOIN $tablepost2cat ON $tablepost2cat.post_ID=$tablecomments.comment_post_ID ";
			foreach ($exclude_cat as $cat) {
				$sql_exlude_cat .= "AND category_id  != '$cat' ";
			}
		}
	} 

	if ($sample == 1) {
		$max_comments = 1;
		$echo = 0;
	} else {
		$echo = 1;
	}

	$sql_ignore_ip = '';
	if (kjgrc_get_option("grt","ignore_ip") != '') {
		$sql_ignore_ip = "AND comment_author_IP != '". kjgrc_get_option("grt","ignore_ip") ."' ";
	}

	$query = "SELECT DISTINCT $tablecomments.* FROM $tablecomments ".
		"LEFT JOIN $tableposts ON $tableposts.ID=$tablecomments.comment_post_ID ".
		$sql_join_post2cat .
		"WHERE (post_status = 'publish' OR post_status = 'static') AND comment_approved= '1' AND  post_password = '' ".
		$sql_exlude_cat .
		"AND ( comment_type = 'trackback' OR comment_type = 'pingback' ) ".
                $sql_ignore_ip .
		"ORDER BY comment_date DESC LIMIT $max_comments";
	return kjgrc_get_entries($max_comments,$chars_per_comment,$chars_per_word,$format,$query,$echo);	
}
/*
if (function_exists('get_recent_comments')) {
   echo "<strong>Warning: You have multiple plugins with a function &quot;get_recent_comments()&quot;</strong>";
   return;
}
*/
function get_recent_comments ($max_comments=5,
				$chars_per_comment=120,
$format='<li><a href="%comment_link" title="%post_title, %post_date">%comment_author</a>: %comment_excerpt</li>',$sample=0) {
	global $tablecomments,$tableposts,$tablepost2cat;

	// WordPress 1.2.x has no is_plugin_page
	if (! function_exists("is_plugin_page")) {
		$sql_comment_type = ''; // In WP1.2 select all comments (also trackbacks)
		$chars_per_word = 30;
	}
	else {
		$max_comments = kjgrc_get_option("grc","max_comments");
		$chars_per_comment = kjgrc_get_option("grc","chars_per_comment");
		$chars_per_word = kjgrc_get_option("grc","chars_per_word");
		$format = stripslashes(kjgrc_get_option("grc","format"));
		$sql_comment_type = "AND comment_type = '' ";
		$exclude_cat = kjgrc_get_exclude_cat();
		if ($exclude_cat) {
			$sql_join_post2cat = "LEFT JOIN $tablepost2cat ON $tablepost2cat.post_ID=$tablecomments.comment_post_ID ";
			foreach ($exclude_cat as $cat) {
				$sql_exlude_cat .= "AND category_id  != '$cat' ";
			}
		}
	} 
	if ($sample == 1) {
		$max_comments = 1;
		$echo = 0;
	} else {
		$echo = 1;
	}

	$query = "SELECT DISTINCT $tablecomments.* FROM $tablecomments ".
		"LEFT JOIN $tableposts ON $tableposts.ID=$tablecomments.comment_post_ID ".
		$sql_join_post2cat .
		"WHERE (post_status = 'publish' OR post_status = 'static') AND comment_approved= '1' AND  post_password = '' ".
		$sql_exlude_cat .
		$sql_comment_type .
		"ORDER BY comment_date DESC LIMIT $max_comments";
	return kjgrc_get_entries($max_comments,$chars_per_comment,$chars_per_word,$format,$query,$echo);
}

function kjgrc_get_entries ($max_comments,$chars_per_comment,$chars_per_word,
					$format,$query,$echo=1)
{
	global $wpdb;
	if (!(strpos($format,"%gravatar") !== false))
		$has_gravatar = 0;
	else {
		$has_gravatar = 1;
		$gravatar_alt_url = kjgrc_get_option('gravatar','alt_url');
		$gravatar_size    = kjgrc_get_option('gravatar','size');
		$gravatar_rating  = kjgrc_get_option('gravatar','rating');
		$gravatar_mpaa[0] = 'G';
		$gravatar_mpaa[1] = 'PG';
		$gravatar_mpaa[2] = 'R';
		$gravatar_mpaa[3] = 'X';
		$gravatar_options .= "&amp;size=$gravatar_size";
		$gravatar_options .= "&amp;rating=" . $gravatar_mpaa[$gravatar_rating];
		if (kjgrc_get_option('gravatar','alt_url') != '') {
			$gravatar_options .= "&amp;default=" . urlencode($gravatar_alt_url);
		}
	}
	$comments = $wpdb->get_results($query);
        if (! $comments) {
		echo "<li></li>";
		return;
	}
	foreach ($comments as $comment)
	{
		$trackback_title = '';
		$comment_excerpt = $comment->comment_content;
		if (function_exists("is_plugin_page")) // be compatible to wp 1.2.x
		{
			if ($comment->comment_type == 'pingback') {
				$trackback_title = $comment->comment_author;
				if (strpos($trackback_title,'&raquo;') !== false) {
					$trackback_title = substr($trackback_title,
                                	strpos($trackback_title,'&raquo;')+7,strlen($trackback_title));
				}
				if (strpos($trackback_title,'&raquo;') !== false) {
					$trackback_title = substr($trackback_title,
                                	strpos($trackback_title,'&raquo;')+7,strlen($trackback_title));
				}
				//$trackback_title .= " '$comment->comment_author [P]'";
				//$trackback_title = "Pingback";
			}
			elseif ($comment->comment_type == 'trackback') 
			{
				$trackback_title = preg_replace("/^<strong>(.+?)<\/strong>.*/s","$1",$comment->comment_content);
				$trackback_title = strip_tags($trackback_title);
				$trackback_title = preg_replace("/[\n\t\r]/"," ",$trackback_title);
               	        	$trackback_title = preg_replace("/\s{2,}/"," ",$trackback_title);
               	        	$trackback_title = wordwrap($trackback_title,$chars_per_word,' ',1);
											
				$comment_excerpt = preg_replace("/^<strong>.+?<\/strong>/","",$comment->comment_content,1);
			
				$comment_excerpt = strip_tags($comment_excerpt); //trackbacks need htmlspecialchars. strip
									 //must come before 
				$comment_excerpt = htmlspecialchars($comment_excerpt);
			}
		}
		$comment_excerpt = strip_tags($comment_excerpt);

		$comment_excerpt = preg_replace("/[\n\t\r]/"," ",$comment_excerpt);
		$comment_excerpt = preg_replace("/\s{2,}/"," ",$comment_excerpt);
                $comment_excerpt = wordwrap($comment_excerpt,$chars_per_word,' ',1);
                
		$post_link    = get_permalink($comment->comment_post_ID);
		$comment_link = $post_link .
				"#comment-$comment->comment_ID";
		$comment_date = mysql2date(get_settings('date_format'),$comment->comment_date);
		//$comment_time = substr($comment->comment_date,11,5); // 2005-03-09 22:23:53
		$comment_time = mysql2date(get_settings('time_format'),$comment->comment_date); // Thanks to Keith
		$comment_author = $comment->comment_author;
		if ($has_gravatar && $comment_author != '') 
		{
			if ($md5_cache && array_key_exists($comment->comment_author,$md5_cache)) {
				$gravatar_md5 = $md5_cache[$comment->comment_author];
			} else {
				$gravatar_md5 = md5($comment->comment_author_email);
				$md5_cache[$comment->comment_author] = $gravatar_md5;
			}
			$comment_gravatar_url = "http://www.gravatar.com/avatar.php?" .
				"gravatar_id=$gravatar_md5" .
				$gravatar_options;
				
			$comment_gravatar = "<img src=\"" . $comment_gravatar_url .
				"\" alt=\"\" width=\"$gravatar_size\" height=\"$gravatar_size\" class=\"kjgrcGravatar\" />";
		}
		if ($comment->comment_type == 'pingback') {
			$comment_author = trim(substr($comment_author,0,strpos($comment_author,'&raquo;')));
		}
		if (! $comment_author) $comment_author = 'Anonymous';
		$post = get_postdata($comment->comment_post_ID);
		$post_date = mysql2date(get_settings('date_format'),$post['Date']);
	
		$output = $format;
		$output = str_replace("%comment_link",    $comment_link,    $output);
		$output = str_replace("%author_url",      $comment->comment_author_url, $output);
		$output = str_replace("%userid",  	  $comment->user_id,$output);
		
		$output = str_replace("%gravatar_url",    $comment_gravatar_url, $output);
		$output = str_replace("%gravatar",        $comment_gravatar, $output);
		$output = str_replace("%comment_author",  $comment_author,  $output);
		$output = str_replace("%comment_date",    $comment_date,    $output);
		$output = str_replace("%comment_time",    $comment_time,    $output);
		$output = str_replace("%post_title",      
                             trim(htmlspecialchars(stripslashes($post['Title']))), $output);
		$output = str_replace("%post_link",       $post_link,       $output);
		$output = str_replace("%post_date",       $post_date,       $output);

		//strip title or content?
		$visible = strip_tags($output);
		#echo "\t$output [[".$visible."]]\n";
		if (strpos($visible,'%comment_excerpt') !== false) {
			$comment_excerpt = kjgrc_excerpt($comment_excerpt,$chars_per_comment,$chars_per_word,'%comment_excerpt',$output);
		} 
		elseif (strpos($visible,'%trackback_title') !== false) {
			$trackback_title = kjgrc_excerpt($trackback_title,$chars_per_comment,$chars_per_word,'%trackback_title',$output);
		}
		
		
		#$comment_excerpt = kjgrc_excerpt($comment_excerpt,$len,$chars_per_word);
		#$trackback_title = kjgrc_excerpt($trackback_title,$len,$chars_per_word);
		$output = str_replace("%comment_excerpt", $comment_excerpt,$output);
		$output = str_replace("%trackback_title",   $trackback_title,  $output);
		#$len = strlen(strip_tags($output));
		//$output .= " [$comment_time]";
		if (! $echo) {
	               	return "$output"; 
		} else {
	               	echo "\t$output\n"; 
		}
	} // foreach
}

function kjgrc_excerpt ($text,$chars_per_comment,$chars_per_word,$tag,$output)
{
	$length = strlen(str_replace($tag,"",strip_tags($output)));
	$length = $chars_per_comment - $length;
	$length = $length -2; // we will add three dots at the end
	if ($length < 0) $length = 0;
	if (strlen($text) > $length) {
		$text = substr($text,0,$length);
		$text = substr($text,0,strrpos($text,' '));
		// last word exceeds max word length:
		if ((strlen($text) - strrpos($text,' ')) > $chars_per_word) {
			$text = substr($text,0,strlen($text)-3);
		} 
		$text = $text . "...";
	}
	#$text = "[EXCERPT]: '$text'";
	return "$text";
}

add_action('admin_menu', 'kjgrc_add_options_page');
?>
