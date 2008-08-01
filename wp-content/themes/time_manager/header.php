<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<?php if(is_single()) : ?>
	<script type="text/javascript">
		imgLoading = '<?php bloginfo("stylesheet_directory"); ?>/images/loading.gif';
		urlComments = '<?php bloginfo("stylesheet_directory");  ?>/php/comments_ajax.php';
		urlImages = '<?php bloginfo("stylesheet_directory"); ?>/img/';
		newComent = '<?php echo get_settings('home'); ?>/wp-comments-post.php';
	</script>	
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body>
<!--TopPan-->
<div id="topPan">
	<ul>
		<li><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></li>
		<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
		<?php wp_register('<li>','</li>'); ?>
	</ul>
	<h1><?php bloginfo('name'); ?></h1>
	<div id="toplinkPan">
    <div id="toplinkfastPan">
		<p><?php bloginfo('name'); ?></p>
		<a href="<?php echo get_settings('home'); ?>/">&nbsp;</a>
		
	</div>
	<div id="toplinksecondPan">
	<p>Full RSS</p>
		<a href="<?php bloginfo('rss2_url'); ?>">&nbsp;</a>
	</div>
	
    <div id="toplinkthirdPan">
		<p>Comments RSS</p>
		<a href="<?php bloginfo('comments_rss2_url'); ?>">&nbsp;</a>
	</div>
	</div>
</div>
<!--TopPan Close-->
