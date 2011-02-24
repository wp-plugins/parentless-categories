<?php
/**
 * @package Parentless_Categories
 * @author Scott Reilly
 * @version 1.1.1
 */
/*
Plugin Name: Parentless Categories
Version: 1.1.1
Plugin URI: http://coffee2code.com/wp-plugins/parentless-categories/
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Like the_category(), list categories assigned to a post, but excluding assigned categories that have a child category also assigned to the post.

Compatible with WordPress 2.5+, 2.6+, 2.7+, 2.8+, 2.9+, 3.0+, 3.1+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/parentless-categories/

*/

/*
Copyright (c) 2008-2011 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


if ( !function_exists( 'parentless_categories' ) ) :
/**
 * Outputs the parentless categories.
 *
 * For use in the loop
 *
 * @param string $separator (optional) String to use as the separator
 * @param int|false $post_id (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @return void (Text is echoed)
*/
function parentless_categories( $separator = '', $post_id = false ) {
	echo get_parentless_categories_list( $separator, $post_id );
}
endif;


if ( !function_exists( 'get_parentless_categories_list' ) ) :
/**
 * Gets the list of parentless categories.
 *
 * @param string $separator (optional) String to use as the separator
 * @param int|false $post_id (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @return string The HTML formatted list of parentless categories
 */
function get_parentless_categories_list( $separator = '', $post_id = false ) {
	global $wp_rewrite;
	$categories = get_parentless_categories( $post_id );
	if ( empty( $categories ) )
		return apply_filters( 'parentless_categories', __( 'Uncategorized' ), $separator );

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '';
	if ( '' == $separator ) {
		$thelist .= '<ul class="post-categories">';
		foreach ( $categories as $category ) {
			$thelist .= "\n\t<li>";
			$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category->cat_name.'</a></li>';
		}
		$thelist .= '</ul>';
	} else {
		$i = 0;
		foreach ( $categories as $category ) {
			if ( 0 < $i )
				$thelist .= $separator . ' ';
			$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category->name.'</a>';
			++$i;
		}
	}
	return apply_filters( 'parentless_categories', $thelist, $separator );
}
endif;


if ( !function_exists( 'get_parentless_categories' ) ) :
/**
 * Returns the list of parentless categories for the specified post. IF not supplied a
 * post ID, then an empty array is returned.
 *
 * @param int|false $post_id (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @return array The array of parentless categories for the given category. If false, then assumes a top-level category.
 */
function get_parentless_categories( $post_id = false ) {
	$categories = get_the_category( $post_id );
	if ( empty( $categories ) )
		return array();

	$cats = array();
	$parents = array();

	// Go through all categories and get, then filter out, parents.
	foreach ( $categories as $c )
		$parents[] = $c->parent;
	foreach ( $categories as $c ) {
		if ( !in_array( $c->term_id, $parents ) )
			$cats[] = $c;
	}
	
	usort( $cats, '_usort_terms_by_name' );
	return $cats;
}
endif;

?>