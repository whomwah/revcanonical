=== RevCanonical ===
Contributors: whomwah 
Donate Link: http://pledgie.org/campaigns/3803 
Tags: revcanonical, simple, post, url
Requires at least: 2.6
Tested up to: 2.7.2
Stable tag: 1.1.1 

A Wordpress plugin that creates localized shortened urls and adds support for the rev=canonical link tag 

== Description ==

RevCanonical creates and adds support for shortened urls as per <a href="http://laughingmeme.org/2009/04/03/url-shortening-hinting/">this rev=canonical blog post</a>. It not only creates short urls for all your posts and pages, but once you install the plugin, you will get a tag added to the source of your page that will contain that shortened version of the url for the page it sits in.

`<link rev="canonical" type="text/html" href="http://domain.me/p12p" />` 

That’s it! You can now, not only use this url to pass around and in sites like [Twitter](http://twitter.com) without having to go via a url shortening service, but [services](http://revcanonical.appspot.com/) or people that understand the rev=canonical link tag, will be able to use this shortened version over the longer canonical version. It also means that it’s persistence is down to you, and not to a 3rd party.

Oh and there's [a great bookmarklet](http://simonwillison.net/2009/Apr/11/revcanonical/) that makes hunting for existing short urls on a page really simple. You can read more about this plugin at my website http://littl.me/p136

== Frequently Asked Questions ==

= Does it work with earlier versions of Wordpress? =

Not sure is the simple answer, I currently run 2.7.2. If it works with ealier versions, please let me know via [Whomwah.com](http://whomwah.com).

= But my domain name is really long =

You can add you own shortened domain name if you own one via the settings page. It's up to you though, to point your shortened domain back to the longer one. I do this via a ProxyPass line in that domains conf file.

= Can I contribute to revcanonical? =

Sure, the code lives at the [Revcanonical github project page](http://whomwah.com/revcanonical "Revcanonical via Github"). You can download or fork it there.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `revcanonical.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
