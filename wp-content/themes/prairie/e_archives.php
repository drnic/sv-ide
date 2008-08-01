<?php
/*
Template Name: Extended Live Archives
*/
?>

<?php get_header(); ?>

	<div id="primary">
	<div class="inside">
<?php if (function_exists('af_ela_super_archive')) {af_ela_super_archive();} ?>
    
	<?php if (function_exists('af_ela_super_archive')) {af_ela_super_archive();} ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>