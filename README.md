# Simple Pinterest Plugin

--------

The Simple Pinterest Plugin makes it easy to use the advanced native Pinterest "pin it" button on your blog. Perfect for lifestyle, craft & photography bloggers this plugin allow you to use global settings or customize on a per-post, per-page or per-image basis. No matter where the post is pinned from it will always credit the permalink and you can customize the button's color, layout. Using the best SEO practices and setting a goal to create a free plugin that is "set it and forget it" while making it obvious and simple for your visitors to share your great content through this high traffic social network!

--------

The Simple Pinterset plugin is designed to be as light weight as possible while achieving one goal: making it easy for your visitors to share your content on interest.

This plugin strives to achieve that goal with the following guidelines

* CSS will only use !important; when set in the configuration. By default it should be easy for a user to overwrite the plugin's styles but to make sure it's easy for users to retain their images' center alignment we'll make it an advanced configuration
* Minimal PHP manipulation to the page
* Using jQuery to manipulate the DOM to add any necessary markup
* Additional assets will load asyncronously for page performance optimizations
* The nopin="nopin" attribute will be explicitly respected and the primary way to prevent the button from being displayed
* The plugin will work on the current stock WordPress themes and Genesis Framework (standard, no child theme) with the intention to support as many other themes as possible
* Avoid bloating the plugin with unnecessary features
* Leave no footprint, when the plugin is deactivated it will remove all of it's options from the database.

This plugin will be free and open-source. Developers are welcome to contribute after the first release of the plugin. Any issues and bug reports should be filed in the [GitHub Issues](https://github.com/terriann/simple-pinterest-plugin/issues) for the project.

## What this Plugin will NOT do

I think it's important to define what this plugin will not do upfront.

This plugin will not...

* Have a way to verify your site for Pinterest
 *Tip* Uploading the file to your root web directiory bypasses WordPress in a smart & safe way that will alleviate stress on WordPress for performance purposes
* Ask for money or upsell a premium version (*it may do light, dismissable advertising for other free related plugins or advertise relevent social media marketing blog posts in the future*)
* Provide support on an individual basis
  The developers will do their best to make this compatible with the most popular plugins and themes but every WordPress install is different. If you need heavy modifications you may need to hire a developer who can fork this plugin and re-release those modifitions under the GPL licensing or contribute their solution to this repository for official release if it qualifies under our principles.

## Plugin Description

A WordPress Pinterest sharing plugin. Perfect for DIY, craft, lifestyle &amp; photography blogs to promote your content easily with just the right bells &amp; whistles. It will overlay a Pinterest branded over the images in your content with the ability to customise how, when and where the buttn shows up.  With a bubble showing how many times a post has been shared your popular posts will stand our with a higher viral success rate!

What makes this a "simple" Pinterest plugin? It's built by a web developer who crafts & blogs in her free time, that means she built this plugin to work for marketing Pinterst on her own content. It's no frills and easy to setup and doesn't require you to change the way you write and publish your posts. Plus, it's free.

## Plugins Supported

We would like to strive to support all the major plugins but the code should be specifically tested on an instalation using the following plugins:

### Lazy Load

* [BJ Lazy Load](https://wordpress.org/plugins/bj-lazy-load/) v.0.7.5 Supported
* [Lazy Load](https://wordpress.org/plugins/lazy-load/) v. 0.5 Suspected to be support

## Pinterest Plugins

* None tested at this time

## Social Media Plugins

* _None tested at this time_

## Not Compatible

The Simple Pinterest Plugin is not compatible with some plugins by design. These plugins serve a completely different purpose while cluttering up the image. In order to avoid conflicts this plugin will be disabled if it detects the following plugins are active:

* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) - Known bug when "Prevent caching of objects after settings change" option is checked the title of the page is used instead of the title of the image (as documented in [issue #25](https://github.com/terriann/Simply-Pinterest-WordPress-Plugin/issues/25) If you uncheck that option it seems to work fine.  We will be looking into this in the future, follow [issue #25](https://github.com/terriann/Simply-Pinterest-WordPress-Plugin/issues/25) for follow ups.

* _No others known conflicts at this time_

## License

Better Pinterest Plugin is free software, and is released under the terms of the [GPL version 2 license](http://www.gnu.org/licenses/gpl-2.0.html).

## Repo Setup

Use this symlink to add extra assets to directory

  ln -s ~/Dropbox/Sites/assets-symlinks/simply-pinterest/ ./~extras

## Release Notes & FAQ

Release notes and FAQs are availiable in the `readme.txt` (used by WordPress's plugin repo)

## Credits

Resources & sites that have been very helpful in developing this plugin

* [https://business.pinterest.com/en/widget-builder#do_pin_it_button](https://business.pinterest.com/en/widget-builder#do_pin_it_button)
* [https://help.pinterest.com/en/articles/prevent-pinning-your-site](https://help.pinterest.com/en/articles/prevent-pinning-your-site)
* [https://developers.pinterest.com/extension_faq/](https://developers.pinterest.com/extension_faq/)
