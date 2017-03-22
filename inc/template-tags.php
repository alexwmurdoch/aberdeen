<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Aberdeen
 */

if (!function_exists('aberdeen_posted_on')) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function aberdeen_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			esc_html_x(' %s', 'post date', 'aberdeen'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x(' %s', 'post author', 'aberdeen'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<span class="posted-on"><i class="fa fa-calendar" aria-hidden="true"></i> ' . $posted_on . '</span><span class="byline"><i class="fa fa-user" aria-hidden="true"></i> ' . $byline . '</span>'; // WPCS: XSS OK.
	}

endif;

if (!function_exists('aberdeen_entry_footer')) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function aberdeen_entry_footer() {
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'aberdeen'));
			if ($categories_list && aberdeen_categorized_blog()) {
				printf('<span class="cat-links"><i class="fa fa-folder-open" aria-hidden="true"></i>' . esc_html__(' %1$s', 'aberdeen') . '</span>', $categories_list); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html__(', ', 'aberdeen'));
			if ($tags_list) {
				printf('<span class="tags-links"><i class="fa fa-tags" aria-hidden="true"></i>' . esc_html__(' %1$s', 'aberdeen') . '</span>', $tags_list); // WPCS: XSS OK.
			}
		}

		if (!is_single() && !post_password_required() && ( comments_open() || get_comments_number() )) {
			echo '<span class="comments-link"><i class="fa fa-comments"></i>';
			/* translators: %s: post title */
			comments_popup_link(sprintf(wp_kses(__(' Leave a Comment<span class="sr-only"> on %s</span>', 'aberdeen'), array('span' => array('class' => array()))), get_the_title()));
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__('Edit %s', 'aberdeen'), the_title('<span class="sr-only">"', '"</span>', false)
			), '<span class="edit-link">', '</span>'
		);
	}

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function aberdeen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'aberdeen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'aberdeen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so aberdeen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so aberdeen_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in aberdeen_categorized_blog.
 */
function aberdeen_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'aberdeen_categories' );
}
add_action( 'edit_category', 'aberdeen_category_transient_flusher' );
add_action( 'save_post',     'aberdeen_category_transient_flusher' );

function aberdeen_author_bio() {
	// Display author bio if post isn't password protected
	if (!post_password_required() && is_single()) {
		if (get_the_author_meta('description') != '') {
			echo '<div class="author-meta well well-lg"><div class="media"><div class="media-object pull-left">';
			// Display author avatar if author has a Gravatar
			if ( aberdeen_validate_gravatar( get_the_author_meta( 'ID' ) ) ) {
				echo get_avatar(get_the_author_meta('ID'), 80);
			}
			echo '</div><div class="media-body"><h3 class="media-heading">';
			the_author_posts_link();
			echo '</h3><p>';
			the_author_meta('description');
			echo '</p>';
			// Retrieve a custom field value
			$twitterHandle = get_the_author_meta('twitter');
			$fbHandle = get_the_author_meta('facebook');
			$gHandle = get_the_author_meta('gplus');
			echo '<p class="author-social">';
			if (get_the_author_meta('twitter') != '') {
				echo '<a href="http://twitter.com/' . esc_html($twitterHandle) . '" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>';
			}
			if (get_the_author_meta('facebook') != '') {
				echo '<a href="' . esc_url($fbHandle) . '" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>';
			}
			if (get_the_author_meta('gplus') != '') {
				echo '<a href="' . esc_url($gHandle) . '" target="_blank"><i class="fa fa-google-plus fa-lg"></i></a>';
			}
			echo '</p></div></div></div>';
		}
	}
}

/**
 * Utility function to check if a gravatar exists for a given email or id
 * Original source: https://gist.github.com/justinph/5197810
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */

function aberdeen_validate_gravatar($id_or_email) {
	//id or email code borrowed from wp-includes/pluggable.php
	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	$hashkey = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

	$data = wp_cache_get($hashkey);
	if (false === $data) {
		$response = wp_remote_head($uri);
		if( is_wp_error($response) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
		wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);

	}
	if ($data == '200'){
		return true;
	} else {
		return false;
	}
}

/**
 * Customise the excerpt read-more indicator.
 *
 */
function aberdeen_excerpt_more($more){
	return " ...";
}
add_filter('excerpt_more','aberdeen_excerpt_more' );

/**
 * Custom Read More Button
 */
function aberdeen_modify_read_more_link() {

	return '<p><a class="more-link btn btn-default" href="' . get_permalink() . '">Read More</a></p>';
}

add_filter('the_content_more_link', 'aberdeen_modify_read_more_link');

/**
 * Custom Edit Button
 */
function aberdeen_custom_edit_post_link($output) {

	$output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-default btn-xs"', $output);
	return $output;
}

add_filter('edit_post_link', 'aberdeen_custom_edit_post_link');


if (!function_exists('aberdeen_display_logo')) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 */
	function aberdeen_display_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			if (has_custom_logo()){
				$logo_url = wp_get_attachment_image_url( get_theme_mod( 'custom_logo'));
				echo '<img src="' .$logo_url . '" alt="Custom Logo" class="custom-logo img-responsive">';
			}
		}
	}
endif;