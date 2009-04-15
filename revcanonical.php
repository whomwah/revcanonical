<?php
/*
Plugin Name: RevCanonical
Plugin URI: http://whomwah.com/revcanonical/ 
Description: Creates and adds support for shortened urls and the rev=canonical link tag
Version: 1.1.1
Author: Duncan Robertson 
Author URI: http://whomwah.com
*/


function revcanonical()  {
  global $post;
  if (is_single() || is_page()) {
    echo "\n".'<link rev="canonical" type="text/html" href="'.revcanonical_shorten($post->ID).'" />'; 
  }
}

function revcanonical_do_redirect() {
  $rq = spliti('/', trim($_SERVER['REQUEST_URI'],'/'));
  $id = substr($rq[0], 1, strlen($rq[0]));
  if (count($rq) == 1 && $id != '' && $pl = revcanonical_unshorten($id)) {
	  header('Location: '.$pl, true, 301);
  }
}

function revcanonical_shorten($no){
  $url = get_option('revcanonical-url');
  if ($url == '')
    $url = get_bloginfo('url');
  $id = base_convert($no, 10, 36);
  return $url.'/p'.base_convert($no, 10, 36);
}

function revcanonical_unshorten($no){
  $id = base_convert($no, 36, 10);
  return get_permalink($id); 
}

function revcanonical_management() {
	if ($_POST['submit-type'] == 'options') {
		update_option('revcanonical-url', $_POST['revcanonical-url']);
		echo("<div style='width:75%;padding:10px; margin-top:20px; color:#fff;background-color:#2d2;'>Thanks, Configuration Successfully updated!</div>");
	}

  if (get_option('revcanonical-url') == '') {
    $url = get_bloginfo('url');
		update_option('revcanonical-url', $url);
  }
?>

<div class="wrap">
  <h2>RevCanonical Settings</h2>
  <p>RevCanonical adds another link tag to the source code of your posts and pages. It also generates a working short url for that page. You can pass this shortened link around or use it on character restricted sites like <a href="http://twitter.com">Twitter</a>. As well as that, sites that understand this tag, will use it too if they require a shorter version of your pages url. This link could now still exist in 20 years, as it's in your hands now, and not a 3rd parties that could shut down. It also gives the user of the link a bit of confidence that the destination is safe.</p>
  <p>Here's an example of what gets added to your page. The link in the href part is the short version you can use:</p>
  <p><code>&#060link rev="canonical" type="text/html" href="<?php echo(get_option('revcanonical-url')) ?>/p12p" /&#062;</code></p>
  <p>Sites like <a href="http://flickr.com">Flickr</a>, <a href="http://dopplr.com/">Dopplr</a> and <a href="http://php.net/">php.net</a> are also starting to add this link tag to their pages. There is even <a href="http://simonwillison.net/2009/Apr/11/revcanonical/">a bookmarklet</a> that will returned the shortened url for a page if it's available. For more information visit <a href="http://revcanonical.appspot.com/">http://revcanonical.appspot.com/</a></p>
  <p>
  <h3>Shorten URL domain name Configuration</h3>
	<form method="post">
	<p><label for="tweetme-text">By default the shortened link will be for example <code><? echo get_bloginfo('url'); ?>/p12p</code>, but you can change this below.</label></p>
	<input type="text" name="revcanonical-url" id="revcanonical-url" class="regular-text" size="50" maxlength="122" value="<?php echo(get_option('revcanonical-url')) ?>" /><code>/p12p</code>
  <p><em>NOTE: If you change the domain, it is up to you to configure your new domain name to point to the default one. <a href="http://gist.github.com/94686">Here's an example</a></em></p> 

	<input type="hidden" name="submit-type" value="options">
  <p class="submit"><input type="submit" name="Submit" class="button-primary" value="Save Changes" /></p>
	</form>

</div>

<?php
}

function add_revcanonical_admin_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', 
      __('RevCanonical Configuration'), __('RevCanonical Config'), 
      'manage_options', 'revcanonical-config', 'revcanonical_management');
}

add_action('template_redirect','revcanonical_do_redirect');
add_action('wp_head', 'revcanonical');
add_action('admin_menu', 'add_revcanonical_admin_page');

?>
