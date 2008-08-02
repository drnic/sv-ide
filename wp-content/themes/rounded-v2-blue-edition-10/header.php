<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->


		

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />

	</style>
	<script src="<?php bloginfo('template_directory'); ?>/js/lib/prototype.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/scriptaculous.js" type="text/javascript"></script>
		<script src="<?php bloginfo('template_directory'); ?>/js/sifr.js" type="text/javascript"></script>
	<!--link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /-->
	<!--link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" /-->
	<!--link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" /-->
	<link rel="alternate" href="http://feeds.feedburner.com/SV-IDE" type="application/atom+xml" title="Feedburner Feed">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>

<!--[if lt IE 7.]>
<script defer type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/pngfix.js"></script>
<![endif]-->

</head>

<body>


<div id="rap">




<div id="masthead">
		
		<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
							
				<h2><?php bloginfo('description'); ?></h2>
				

</div><!-- end MASTHEAD -->

<div id="main">

<div id="content">
<!-- end header -->