<?php
/**
 * Plugin Name: Parentless Categories
 * Version:     2.0.2
 * Plugin URI:  http://coffee2code.com/wp-plugins/parentless-categories/
 * Author:      Scott Reilly
 * Author URI:  http://coffee2code.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Description: List a post's categories that don't have a parent category also directly assigned to the post (basically lists all leaf nodes).
 *
 * Compatible with WordPress 3.6 through 4.1+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/parentless-categories/
 *
 * @package Parentless_Categories
 * @author Scott Reilly
 * @version 2.0.2
 */

/*
	Copyright (c) 2008-2015 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! function_exists( 'c2c_parentless_categories' ) ) :

/**
 * Outputs the parentless categories.
 *
 * For use in the loop
 *
 * @since 2.0
 *
 * @param  string    $separator (optional) String to use as the separator
 * @param  int|false $post_id   (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @return void      (Text is echoed)
*/
function c2c_parentless_categories( $separator = '', $post_id = false ) {
	echo c2c_get_parentless_categories_list( $separator, $post_id );
}

add_action( 'c2c_parentless_categories', 'c2c_parentless_categories', 10, 2 );

endif;


if ( ! function_exists( 'c2c_get_parentless_categories_list' ) ) :

/**
 * Gets the list of parentless categories.
 *
 * @since 2.0
 *
 * @param  string    $separator (optional) String to use as the separator
 * @param  int|false $post_id   (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @return string    The HTML formatted list of parentless categories
 */
function c2c_get_parentless_categories_list( $separator = '', $post_id = false ) {
	global $wp_rewrite;

	$categories = c2c_get_parentless_categories( $post_id );

	if ( empty( $categories ) ) {
		return apply_filters(
			'c2c_parentless_categories_list',
			apply_filters( 'parentless_categories', __( 'Uncategorized' ), $separator ), // Deprecated as of v2.0
			$separator,
			$post_id
		);
	}

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '';
	if ( '' == $separator ) {
		$thelist .= '<ul class="post-categories">';
		foreach ( $categories as $category ) {
			$thelist .= "\n\t<li>";
			$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' .
					sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' .
					$rel . '>' . $category->cat_name . '</a></li>';
		}
		$thelist .= '</ul>';
	} else {
		$i = 0;
		foreach ( $categories as $category ) {
			if ( 0 < $i ) {
				$thelist .= $separator;
			}
			$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' .
					sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' .
					$rel . '>' . $category->name.'</a>';
			++$i;
		}
	}

	return apply_filters(
		'c2c_parentless_categories_list',
		apply_filters( 'parentless_categories', $thelist, $separator ), // Deprecated as of v2.0
		$separator,
		$post_id
	);
}

add_filter( 'c2c_get_parentless_categories_list', 'c2c_get_parentless_categories_list', 10, 2 );

endif;


if ( ! function_exists( 'c2c_get_parentless_categories' ) ) :

/**
 * Returns the list of parentless categories for the specified (or current) post.
 *
 * @since 2.0
 *
 * @param  int|false $post_id        (optional) Post ID. If 'false', then the current post is assumed.  Default is 'false'.
 * @param  bool      $omit_ancestors (optional) Prevent any ancestors from also being listed, not just immediate parents?
 * @return array     The array of parentless categories for the given category. If false, then assumes a top-level category.
 */
function c2c_get_parentless_categories( $post_id = false, $omit_ancestors = true ) {
	$categories = get_the_category( $post_id );

	$cats = $parents = array();

	if ( empty( $categories ) ) {
		return $cats;
	}

	$omit_ancestors = apply_filters( 'c2c_get_parentless_categories_omit_ancestors', $omit_ancestors );

	// Go through all categories and get, then filter out, parents.
	foreach ( $categories as $c ) {
		if ( $c->parent && ! in_array( $c->parent, $parents ) ) {
			if ( $omit_ancestors ) {
				$parents = array_merge( $parents, get_ancestors( $c->term_id, 'category' ) );
			} else {
				$parents[] = $c->parent;
			}
		}
	}
	$parents = array_unique( $parents );

	foreach ( $categories as $c ) {
		if ( ! in_array( $c->term_id, $parents ) ) {
			$cats[] = $c;
		}
	}
	
	usort( $cats, '_usort_terms_by_name' );

	return $cats;
}

add_filter( 'c2c_get_parentless_categories', 'c2c_get_parentless_categories', 10, 2 );

endif;



/*************
 * DEPRECATED FUNCTIONS
 *************/



if ( ! function_exists( 'parentless_categories' ) ) :
/**
 * @since 1.0
 * @deprecated 2.0 Use c2c_parentless_categories() instead
 */
function parentless_categories( $separator = '', $post_id = false ) {
	_deprecated_function( 'parentless_categories', '2.0', 'c2c_parentless_categories' );
	c2c_parentless_categories( $separator, $post_id );
}
endif;

if ( ! function_exists( 'get_parentless_categories_list' ) ) :
/**
 * @since 1.0
 * @deprecated 2.o Use c2c_parentless_categories() instead
 */
function get_parentless_categories_list( $separator = '', $post_id = false ) {
	_deprecated_function( 'get_parentless_categories_list', '2.0', 'c2c_get_parentless_categories_list' );
	return c2c_get_parentless_categories_list( $separator, $post_id );
}
endif;


if ( ! function_exists( 'get_parentless_categories' ) ) :
/**
 * @since 1.0
 * @deprecated 2.0 Use c2c_parentless_categories() instead
 */
function get_parentless_categories( $post_id = false ) {
	_deprecated_function( 'get_parentless_categories', '2.0', 'c2c_get_parentless_categories' );
	return c2c_get_parentless_categories( $post_id );
}
endif;
