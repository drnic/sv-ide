	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	
<meta name="description" content="Headsetoptions: Activism, Webdesign for Non-Profits & a Socio-political Blog" />

	<meta name="keywords" content="Wordpress, theme, viewer, new, blog, socio-political, ultraminima, ultra minima, ism, 3k2, redux, klee, klein, Orange, rothko, warhol, Easy, Black, tree, Enterprise, Activism, Webdesign, Non-Profits, blog, political blog, headsetoptions, news, politics, media, history, analysis, oddities, spin, headsetoptions.org, weblog"/>
	<meta name="author" content="headsetoptions" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->


	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>

	<?php wp_head(); ?>


</head>

<body>



<div id="wrapper">
<div id="header">
<h1><?php bloginfo('name'); ?></h1>
<h2><?php bloginfo('description'); ?></h2>
<ul>
<li><a href="<?php echo get_settings('home'); ?>/">Home</a>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?></li>
</ul>
</div>
</div>






<!-- end header -->
