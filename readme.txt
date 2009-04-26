=== RevCanonical ===
Contributors: whomwah 
Donate Link: http://pledgie.org/campaigns/3803 
Tags: revcanonical, shortening, links, simple, post, url
Requires at least: 2.6
Tested up to: 2.7.2
Stable tag: 1.2.1 

A Wordpress plugin that creates and adds support for shortened urls plus the shortlink auto-discovery tag

== Description ==

RevCanonical generates a short url for your pages, as well as adding [link shortening discovery](http://laughingmeme.org/2009/04/03/url-shortening-hinting/). You can use this url on character restricted sites like [Twitter](http://twitter.com), in IM, or anytime you need a short link to your webpages. The discovery part means that other sites and [services](http://revcanonical.appspot.com/) can also use the short url should they need it. Oh and this short url is yours, from your website. It does not use any external service.

Here's what gets added to your pages. The link in the href is the short version you can use:

`<link rev="canonical" type="text/html" href="http://my-domain.me/p12p" />` 

This tag can though be customised to suit your own preferences (at your own risk), for instance this:

`<link rel="shortlink" href="http://my-mini.me/p12p" />` 

That’s it! You can now, not only use this url to pass around, and in sites like [Twitter](http://twitter.com) without having to go via a url shortening service, but [services](http://revcanonical.appspot.com/) or people that understand the rev=canonical link tag, will be able to use this shortened version over the longer canonical version. It also means that it’s persistence is down to you, and not to a 3rd party.

Oh and there's [a great bookmarklet](http://simonwillison.net/2009/Apr/11/revcanonical/) that makes hunting for existing short urls on a page really simple. You can read more about this plugin at my website http://littl.me/p136

== Advanced ==

The default settings should suit most people, but if there are a couple of things you can change should you wish. There are also a few tags you can use within your own pages.

If your domain name is a bit long and you own a smaller domain you would like to use as your shortened domain, you can add this in the settings page. You would then just need to make sure that the new domain pointed to the original via a ProxyPass setting.

There are many ongoing conversations on the web about how to describe shortened links in HTML. There appears to be no absolute right way, so by default if will be rev=canonical. Should you want to use another way, you can also change this via the settings page.

And finally... there are a couple of tags you can use in your own templates, that will return the short link for that page. You need to pass them the post ID.

`<?php get_revcanonical_shorturl($post->ID) ?> ===> Echo the shorturl to the screen`

`<?php $url = revcanonical_shorturl($post->ID) ?> ===> Assign the shorturl to a variable`

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
