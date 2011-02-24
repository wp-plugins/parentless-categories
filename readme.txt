=== Parentless Categories ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: categories, category, list, the_category, coffee2code
Requires at least: 2.5
Tested up to: 3.1
Stable tag: 1.1.1
Version: 1.1.1

Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.


== Description ==

Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.

This plugin provides a template tag which acts a modified version of WordPress's built-in template tag, `the_category()`.  `the_category()` lists all categories directly assigned to the specified post.  `parentless_categories()` lists those categories, except for categories that are parents to other assigned categories.

For example, assume your category structure is hierarchical and looks like this:

`
Vegetables
|-- Leafy
|   |-- Broccoli
|   |-- Bok Choy
|   |-- Celery
|-- Fruiting
|   |-- Bell Pepper
|   |-- Cucumber
|   |-- Pumpkin
|-- Podded
|   |-- Chickpea
|   |-- Lentil
|   |-- Soybean
`

If you directly assigned the categories "Fruiting", "Cucumber", and "Pumpkin" to a post, `parentless_categories()` would return a list that consists of: "Cucumber", and "Pumpkin".  Notice that since "Fruiting" was a parent to a directly assigned category, it is not included in the list.

By default, categories are listed as an HTML list.  The first argument to the template tag allows you to define a custom separator, e.g. to have a simple comma-separated list of categories: `<?php parentless_categories(','); ?>`.

As with categories listed via `the_category()`, categories that are listed are presented as links to the respective category's archive page.

Example usage (based on preceding example):

* `<?php parentless_categories(); ?>`

Outputs something like:

`<ul><li><a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a></li>
<li><a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a></li></ul>`

* `<?php parentless_categories(','); ?></ul>`

Outputs something like:

`<a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a>, <a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a>`

Links: [Plugin Homepage]:(http://coffee2code.com/wp-plugins/parentless-categories/) | [Author Homepage]:(http://coffee2code.com)


== Installation ==

1. Unzip `parentless-categories.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. (optional) Add filters for 'parentless_categories' to filter parentless category listing
1. Use the template tag `<?php parentless_categories(); ?>` somewhere inside "the loop"


== Frequently Asked Questions ==

= Why isn't an assigned category for the post showing up in the `parentless_categories()` listing? =

If an assigned category is the parent for one or more other assigned categories for the post, then the category parent is not included in the listing.


== Template Tags ==

The plugin provides three optional template tag for use in your theme templates.

= Functions =

* `<?php function parentless_categories( $separator = '', $post_id = false ) ?>`
Outputs the parentless categories.

* `<?php function get_parentless_categories_list( $separator = '', $post_id = false ) ?>`
Gets the list of parentless categories.

* `<?php function get_parentless_categories( $post_id = false ) ?>`
Returns the list of parentless categories for the specified post.

= Arguments =

* `$separator`
Optional argument. (string) String to use as the separator.

* `$post_id`
Optional argument. (int) Post ID.  If 'false', then the current post is assumed.  Default is 'false'.

= Examples =

* (See Description section)


== Changelog ==

= 1.1.1 =
* Documentation tweaks
* Note compatibility with WP 3.1+
* Update copyright date (2011)

= 1.1 =
* Wrap all functions in if(!function_exists()) check
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Note compatibility with WP 2.9+, 3.0+
* Add PHPDoc documentation
* Minor tweaks to code formatting (spacing)
* Add package info to top of plugin file
* Add Changelog, Template Tags, and Upgrade Notice sections to readme.txt
* Update copyright date
* Remove trailing whitespace

= 1.0 =
* Initial release


== Upgrade Notice ==

= 1.1.1 =
Trivial update: documentation tweaks; noted compatibility with WP 3.1+ and updated copyright date.

= 1.1 =
Minor update. Highlights: miscellaneous non-functionality tweaks; verified WP 3.0 compatibility.