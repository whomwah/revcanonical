<?php
/*
Plugin Name: RevCanonical
Plugin URI: http://whomwah.github.com/revcanonical/ 
Description: Creates and adds support for shortened urls plus the shortlink auto-discovery tag
Version: 1.2.4
Author: Duncan Robertson 
Author URI: http://whomwah.com
*/


function revcanonical()
{
  global $post;
  if (is_single() || is_page()) {
    echo "\n".revcanonical_html($post->ID); 
  }
}

function revcanonical_link($no=null)
{
  $url = revcanonical_shorten($no);
  return ((!empty($url))?"\n\n":'').$url;
}

function get_revcanonical_link($no=null)
{
  echo revcanonical_shorten($no);
}

function revcanonical_attr()
{
  $default = 'rev="canonical" type="text/html"'; 
  $opt = get_option('revcanonical-attributes');
  return $opt == '' ? "$default " : "$opt ";
}

function revcanonical_html($id) 
{
  return '<link '.revcanonical_attr().'href="'.revcanonical_shorten($id).'" />'; 
}

function revcanonical_do_redirect($qv)
{
  if (!array_key_exists('pagename', $qv)) {
    return $qv;
  }

  if (isset($GLOBALS["HTTP_SERVER_VARS"]["REQUEST_URI"])) {
    $uri = $GLOBALS["HTTP_SERVER_VARS"]["REQUEST_URI"];
  } else {
    $uri = $GLOBALS["_SERVER"]["REQUEST_URI"];
  }

  $rq = spliti('/', trim($uri,'/'));
  $rq = $rq[count($rq)-1];
  $id = substr($rq, 1, strlen($rq));
  if ($id != '' && $pl = revcanonical_unshorten($id)) {
	  header('Location: '.$pl, true, 301);
	  exit;
  }

  return $qv;
}

function revcanonical_shorten($no)
{
  $url = get_option('revcanonical-url');
  if ($url == '')
    $url = get_bloginfo('url');
  if (!$no)
    return "$url/xx";
  $id = base_convert($no, 10, 36);
  return $url.'/p'.base_convert($no, 10, 36);
}

function revcanonical_unshorten($no)
{
  $id = base_convert($no, 36, 10);
  return get_permalink($id); 
}

function revcanonical_management()
{
	if ($_POST['submit-type'] == 'options') {
		update_option('revcanonical-url', $_POST['revcanonical-url']);
		update_option('revcanonical-attributes', stripslashes($_POST['revcanonical-attributes']));
		echo("<div style='width:75%;padding:10px; margin-top:20px; color:#fff;background-color:#2d2;'>Thanks, Configuration Successfully updated!</div>");
	}

  if (get_option('revcanonical-url') == '') {
    $url = get_bloginfo('url');
		update_option('revcanonical-url', $url);
  }

  if (get_option('revcanonical-attributes') == '') {
    $attr = revcanonical_attr();
		update_option('revcanonical-attributes', $attr);
  }
?>

<div class="wrap">
  <h2>RevCanonical Settings</h2>
  <p><a href="http://whomwah.github.com/revcanonical/">RevCanonical</a> generates a short url for your pages, as well as adding link shortening discovery. You can use this url on character restricted sites like <a href="http://twitter.com">Twitter</a>, in IM, or anytime you need a short link to your webpages. The discovery part means that other sites can also use the short url should they need it. Oh and this short url is yours, from your website. It does not use any external service.</p>
  <p>Here's what gets added to your pages. The link in the <code>href</code> is the short version you can use. You can customise this tag using the settings below:</p>
  <p><code><?php echo htmlspecialchars(revcanonical_html('')) ?></code></p>
  <p>Sites like <a href="http://flickr.com">Flickr</a>, <a href="http://dopplr.com/">Dopplr</a> and <a href="http://php.net/">php.net</a> now add this link tag to their pages. There is even <a href="http://simonwillison.net/2009/Apr/11/revcanonical/">a bookmarklet</a> that will returned the shortened url for a page if it's available. For more information visit <a href="http://revcanonical.appspot.com/">http://revcanonical.appspot.com/</a></p>
  <p>And finally... there are a couple of tags you can use in your own templates, that will return the short link for that page. You need to pass them the post ID. </p>
  <p><code><?php echo(htmlspecialchars("<?php get_revcanonical_link(\$post->ID) ?>  ===> Echo the shorturl to the screen")) ?></code></p>
  <p><code><?php echo(htmlspecialchars("<?php \$url = revcanonical_link(\$post->ID) ?>  ===> Assign the shorturl to a variable")) ?></code></p>
  <h2>Advanced Configuration</h2>
  <p>I suggest only changing these if you know what you're doing. If you think you made a mistake, then changing a setting to empty and re-saving will revert back to the defaults.</p>
  <h3>Custom Shortened Domain Name</h3>
	<form method="post">
	<p><label for="tweetme-text">By default the shortened link will be <code><? bloginfo('url'); ?>/xx</code>, but you can change this below. It's up to you to configure your new domain name if you do.</label></p>
	<input type="text" name="revcanonical-url" id="revcanonical-url" class="regular-text" size="50" maxlength="122" value="<?php echo(get_option('revcanonical-url')) ?>" /> 

	<input type="hidden" name="submit-type" value="options">
  <h3>Custom Link Tag</h3>
	<p><label for="tweetme-text">There are many ongoing conversations on the web about how to describe shortened links in HTML. There appears to be no absolute right way, so by default if will be rev=canonical. Should you want to use another way, you can do so below.</label></p>
	<input type="text" name="revcanonical-attributes" id="revcanonical-attributes" class="regular-text" size="50" value="<?php echo(htmlspecialchars(get_option('revcanonical-attributes'))) ?>" />
  <p class="submit"><input type="submit" name="Submit" class="button-primary" value="Save Changes" /></p>
	</form>

</div>

<?php
}

function add_revcanonical_admin_page() 
{
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', 
      __('RevCanonical Configuration'), __('RevCanonical Config'), 
      'manage_options', 'revcanonical-config', 'revcanonical_management');
}

add_action('wp_head', 'revcanonical');
add_action('admin_menu', 'add_revcanonical_admin_page');
add_filter('request','revcanonical_do_redirect');

?>
