=== Parentless Categories ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: categories, category, list, the_category, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.6
Tested up to: 4.3
Stable tag: 2.0.2

Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.


== Description ==

This plugin provides a template tag which acts a modified version of WordPress's built-in template tag, `the_category()`. `the_category()` lists all categories directly assigned to the specified post. `c2c_parentless_categories()` lists those categories, except for categories that are parents to other assigned categories.

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

If you directly assigned the categories "Fruiting", "Cucumber", and "Pumpkin" to a post, `c2c_parentless_categories()` would return a list that consists of: "Cucumber", and "Pumpkin". Notice that since "Fruiting" was a parent to a directly assigned category, it is not included in the list.

By default, categories are listed as an HTML list. The first argument to the template tag allows you to define a custom separator, e.g. to have a simple comma-separated list of categories: `<?php c2c_parentless_categories( ',' ); ?>`.

As with categories listed via `the_category()`, categories that are listed are presented as links to the respective category's archive page.

Example usage (based on preceding example):

* `<?php c2c_parentless_categories(); ?>`

Outputs something like:

`<ul><li><a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a></li>
<li><a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a></li></ul>`

* `<?php c2c_parentless_categories( ',' ); ?></ul>`

Outputs something like:

`<a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a>, <a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a>`

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/parentless-categories/) | [Plugin Directory Page](https://wordpress.org/plugins/parentless-categories/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `parentless-categories.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. (optional) Add filters for 'parentless_categories' to filter parentless category listing
1. Use the template tag `<?php c2c_parentless_categories(); ?>` somewhere inside "the loop"


== Frequently Asked Questions ==

= Why isn't an assigned category for the post showing up in the `c2c_parentless_categories()` listing? =

If an assigned category is the parent for one or more other assigned categories for the post, then the category parent is not included in the listing.

= Does this plugin include unit tests? =

Yes.


== Template Tags ==

The plugin provides three optional template tags for use in your theme templates.

= Functions =

* `<?php function c2c_parentless_categories( $separator = '', $post_id = false ) ?>`
Outputs the parentless categories.

* `<?php function c2c_get_parentless_categories_list( $separator = '', $post_id = false ) ?>`
Gets the list of parentless categories.

* `<?php function c2c_get_parentless_categories( $post_id = false, $omit_ancestors = true ) ?>`
Returns the list of parentless categories for the specified post.

= Arguments =

* `$separator`
Optional argument. (string) String to use as the separator. Default is '', which indicates unordered list markup should be used.

* `$post_id`
Optional argument. (int) Post ID. If 'false', then the current post is assumed. Default is 'false'.

* `$omit_ancestors`
Optional argument. (bool) Should any ancestor categories be omitted from being listed? If false, then only categories that are directly assigned to another directly assigned category are omitted. Default is 'true'.

= Examples =

* (See Description section)


== Filters ==

The plugin is further customizable via five hooks.

= c2c_parentless_categories (action), c2c_get_parentless_categories_list, c2c_get_parentless_categories (filters) =

These actions and filters allow you to use an alternative approach to safely invoke each of the identically named function in such a way that if the plugin were deactivated or deleted, then your calls to the functions won't cause errors on your site.

Arguments:

* (see respective functions)

Example:

Instead of:

`<?php c2c_parentless_categories( ',' ); ?>`

Do:

`<?php do_action( 'c2c_parentless_categories', ',' ); ?>`

= c2c_parentless_categories_list (filter) =

The 'c2c_parentless_categories_list' filter allows you to customize or override function.

Arguments:

* string    $thelist   : the generated list of categories with complete HTML markup, or __( 'Uncategorized' ) if the post didn't have any categories
* string    $separator : the separator specified by the user, or '' if not specified
* int|false $post_id   : the ID of the post, or false to indicate the current post
Example:

`
// For comma-separated listings, append a special string
add_filter( 'c2c_parentless_categories_list', 'customize_c2c_parentless_categories_list' );
function c2c_parentless_categories_list( $thelist, $separator ) {
	// If not categorized, do nothing
	if ( __( 'Uncategorized' ) == $thelist ) {
		return $thelist;
	}

	// Add a message after a comma separated listing.
	if ( ',' == $separator ) {
		$thelist .= " (* not all assigned categories are being listed)";
	}

	return $thelist;
}
`

= c2c_get_parentless_categories_omit_ancestors (filter) =

The 'c2c_get_parentless_categories_omit_ancestors' filter allows you to customize or override the function argument indicating if ancestor categories of all directly assigned categories (even if directly assigned themselves) should be omitted from the return list of categories. By default, this argument is true.

Arguments:

* bool $omit_ancestors : the $omit_categories argument sent to the function, otherwise implicitly assumed to be the default

Example:

`
// Don't omit ancestors unless they are the immediate parent of an assigned category
add_filter( 'c2c_get_parentless_categories_omit_ancestors', '__return_false' );
`


== Changelog ==

= () =
* Update: Note compatibility through WP 4.3+

= 2.0.2 (2015-02-11) =
* Note compatibility through WP 4.1+
* Update copyright date (2015)

= 2.0.1 (2014-08-30) =
* Minor plugin header reformatting
* Add check to prevent execution of code if file is directly accessed
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

= 2.0 (2014-01-09) =
* Add c2c_parentless_categories()
* Deprecate parentless_categories() in favor of c2c_parentless_categories()
* Change default behavior of c2c_parentless_categories() to omit all ancestor categories by default, instead of just directly assigned categories
* Add optional arg $omit_ancestors to c2c_parentless_categories() only omitting direct parent categories and not all ancestor categories
* Add filter 'c2c_get_parentless_categories_omit_ancestors'
* Add filter 'c2c_parentless_categories' to support filter invocation method c2c_parentless_categories()
* Add c2c_get_parentless_categories_list()
* Deprecate get_parentless_categories_list() in favor of c2c_get_parentless_categories_list()
* Add filter 'c2c_get_parentless_categories_list' to support filter invocation method c2c_get_parentless_categories_list()
* Add c2c_get_parentless_categories()
* Deprecate get_parentless_categories() in favor of c2c_get_parentless_categories()
* Add filter 'c2c_get_parentless_categories' to support filter invocation method c2c_get_parentless_categories()
* Add filter 'c2c_parentless_categories_list' (which also passed $post_id to the hook)
* Deprecate 'parentless_categories' in favor of 'c2c_parentless_categories_list'
* Remove harcoded space added after custom separator in c2c_get_parentless_categories_list()
* Add unit tests
* Add Filters section to readme.txt to document all filters
* Note compatibility through WP 3.8+
* Drop compatibility with versions of WP older than 3.6
* Update copyright date (2014)
* Code and documentation reformatting (spacing, bracing)
* Change donate link
* Add banner image

= 1.1.5 =
* Change description in plugin header to make it shorter
* Note compatibility through WP 3.5+
* Update copyright date (2013)

= 1.1.4 =
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

= 1.1.3 =
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 1.1.2 =
* Note compatibility through WP 3.2+
* Minor documentation reformatting in readme.txt
* Fix plugin homepage and author links in description in readme.txt

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

= 2.0.2 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date

= 2.0.1 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

= 2.0 =
Major update: deprecated all existing functions and filters in favor of 'c2c_' prepended versions; added unit tests; noted compatibility is now only for WP 3.6-3.8+

= 1.1.5 =
Trivial update: noted compatibility through WP 3.5+

= 1.1.4 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 1.1.3 =
Trivial update: noted compatibility through WP 3.3+

= 1.1.2 =
Trivial update: noted compatibility through WP 3.2+

= 1.1.1 =
Trivial update: documentation tweaks; noted compatibility with WP 3.1+ and updated copyright date.

= 1.1 =
Minor update. Highlights: miscellaneous non-functionality tweaks; verified WP 3.0 compatibility.
