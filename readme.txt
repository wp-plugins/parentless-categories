=== Parentless Categories ===
Contributors: Scott Reilly
Donate link: http://coffee2code.com/donate
Tags: categories, category, list, the_category, coffee2code
Requires at least: 2.5
Tested up to: 2.8
Stable tag: 1.0
Version: 1.0

Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.

== Description ==

Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.

This plugin provides a template tag which acts a modified version of WordPress's built-in template tag, `the_category()`.  `the_category()` lists all categories directly assigned to the specified post.  `parentless_categories()` lists those categories, except for categories that are parents to other assigned categories.

For example, assume your category structure is hierarchical and looks like this:

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

If you directly assigned the categories "Fruiting", "Cucumber", and "Pumpkin" to a post, `parentless_categories()` would return a list that consists of: "Cucumber", and "Pumpkin".  Notice that since "Fruiting" was a parent to a directly assigned category, it is not included in the list.

By default, categories are listed as an HTML list.  The first argment to the template tag allows you to define a custom separator, e.g. to have a simple comma-separated list of categories: `<?php parentless_categories(','); ?>`.

As with categories listed via `the_category()`, categories that are listed are presented as links to the respective category's archive page.

Example usage (based on preceeding example):

`<?php parentless_categories(); ?>`
Displays something like:
    `<ul><li><a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a></li>
    <li><a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a></li></ul>`

`<?php parentless_categories(','); ?></ul>`
Displays something like:
    `<a href="http://yourblog.com/category/fruiting/cucumber">Cucumber</a>, <a href="http://yourblog.com/category/fruiting/pumpkin">Pumpkin</a>`


== Installation ==

1. Unzip `parentless-categories.zip` inside the `/wp-content/plugins/` directory for your site
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. (optional) Add filters for 'parentless_categories' to filter parentless category listing
1. Use the template tag `<?php parentless_categories(); ?>` somewhere inside "the loop"

== Frequently Asked Questions ==

= Why isn't an assigned category for the post showing up in the 'parentless_categories()' listing? =

If an assigned category is the parent for one or more other assigned categories for the post, then the category parent is not included in the listing.


