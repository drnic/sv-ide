<?
/* 
Plugin Name: Sideblog
Plugin URI: http://katesgasis.com/2005/10/24/sideblog/
Description: A simple aside plugin. <br/>Licensed under the <a href="http://www.fsf.org/licensing/licenses/gpl.txt">GPL</a>
Version: 2.0
Author: Kates Gasis
Author URI: http://katesgasis.com
*/

/****** EDIT THIS FIRST *********/
$cat_to_hide = 1;
/********************************/

function sideblog_where($query) {
	global $cat_to_hide;
	$now = current_time('mysql');
	if(is_home()){
		return $query . ' AND category_id <> ' . $cat_to_hide . ' ';
	}
	
	return $query;
}

add_filter('posts_where','sideblog_where',10);

function sideblog_join($query) {
	global $wpdb;
	if(is_home()){
		$newquery = $query . " LEFT JOIN $wpdb->post2cat ON ($wpdb->posts.ID = $wpdb->post2cat.post_id) ";
		return $newquery;
	}
	return $query;
}

add_filter('posts_join','sideblog_join',10);



function sideblog($params="title=no&permalinks=no&limit=1") {
	global $wpdb, $cat_to_hide;

	$cat_to_show = $cat_to_hide;

	$title = "";
	$permalinks = "";
	$limit = "1";

	$side_blog_queries = explode("&", $params);

	foreach($side_blog_queries as $side_blog_query){
		$attributes = explode("=", $side_blog_query);
		$name = strtolower($attributes[0]);
		$value = strtolower($attributes[1]);
		switch($name){
			case "title": $title = $value; break;
			case "permalinks": $permalinks = $value; break;
			case "limit": $value=(int) $value; if($value <> 0 && !empty($value) && !is_null($value)){ $limit=$value; } break;
		}
	}

	$now = current_time('mysql');
	$side_blog_contents = $wpdb->get_results("SELECT $wpdb->posts.ID, $wpdb->posts.post_title, $wpdb->posts.post_content FROM $wpdb->posts, $wpdb->post2cat WHERE $wpdb->posts.ID = $wpdb->post2cat.post_id AND $wpdb->post2cat.category_id=" . $cat_to_show . " AND $wpdb->posts.post_status='publish' AND $wpdb->posts.post_password='' AND $wpdb->posts.post_date < '" . $now . "' ORDER BY $wpdb->posts.post_date DESC LIMIT " . $limit);

	foreach($side_blog_contents as $side_blog_content) {

		$side_blog_output = "<li>";
		if($title == "true"){ $side_blog_output .= "<div class=\"asidetitle\">$side_blog_content->post_title</div>\n";}
		$side_blog_output .= "<div class=\"asidecontent\">$side_blog_content->post_content\n";
		if($permalinks == "true"){ $side_blog_output = "$side_blog_output - <span class=\"asidepermalink\"><a href=\"" . get_permalink($side_blog_content->ID) . "\" title=\"Permalink to $side_blog_content->post_title\">#</a></span>\n";}
		$side_blog_output .= "</div></li>\n";

		echo $side_blog_output;
	}

}

?>