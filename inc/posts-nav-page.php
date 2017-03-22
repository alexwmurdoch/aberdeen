<?php
/**
 * Bootstrap converted navigation and paging Functions
 *
 * @package bay3
 */


/*********************************************************************************************************************
 * Provide the links for a post or page that has a number of pages.
 ********************************************************************************************************************/
/**
 * The formatted output of a list of pages.
 *
 * Displays page links for paginated posts (i.e. includes the <!--nextpage-->.
 * Quicktag one or more times). This tag must be within The Loop.
 *
 * @since 1.2.0
 *
 * @global int $page
 * @global int $numpages
 * @global int $multipage
 * @global int $more
 *
 * @param string|array $args {
 *     Optional. Array or string of default arguments.
 *
 *     @type string       $before           HTML or text to prepend to each link. Default is `<p> Pages:`.
 *     @type string       $after            HTML or text to append to each link. Default is `</p>`.
 *     @type string       $link_before      HTML or text to prepend to each link, inside the `<a>` tag.
 *                                          Also prepended to the current item, which is not linked. Default empty.
 *     @type string       $link_after       HTML or text to append to each Pages link inside the `<a>` tag.
 *                                          Also appended to the current item, which is not linked. Default empty.
 *     @type string       $next_or_number   Indicates whether page numbers should be used. Valid values are number
 *                                          and next. Default is 'number'.
 *     @type string       $separator        Text between pagination links. Default is ' '.
 *     @type string       $nextpagelink     Link text for the next page link, if available. Default is 'Next Page'.
 *     @type string       $previouspagelink Link text for the previous page link, if available. Default is 'Previous Page'.
 *     @type string       $pagelink         Format string for page numbers. The % in the parameter string will be
 *                                          replaced with the page number, so 'Page %' generates "Page 1", "Page 2", etc.
 *                                          Defaults to '%', just the page number.
 *     @type int|bool     $echo             Whether to echo or not. Accepts 1|true or 0|false. Default 1|true.
 * }
 * @return string Formatted output in HTML.
 */
function bootstrap_wp_link_pages($args = '') {
    global $page, $numpages, $multipage, $more;

    $defaults = array(
        'before' => '<p>' . __('Pages:'),
        'after' => '</p>',
        'link_before' => '',
        'link_after' => '',
        'next_or_number' => 'number',
        'separator' => ' ',
        'nextpagelink' => __('Next page'),
        'previouspagelink' => __('Previous page'),
        'pagelink' => '%',
        'echo' => 1
    );

    $params = wp_parse_args($args, $defaults);

    /**
     * Filters the arguments used in retrieving page links for paginated posts.
     *
     * @since 3.0.0
     *
     * @param array $params An array of arguments for page links for paginated posts.
     */
    $r = apply_filters('wp_link_pages_args', $params);

    $output = '';
    if ($multipage) {
        if ('number' == $r['next_or_number']) {
            $output .= $r['before'];
            for ($i = 1; $i <= $numpages; $i++) {
                $link = $r['link_before'] . str_replace('%', $i, $r['pagelink']) . $r['link_after'];
                if ($i != $page || !$more && 1 == $page) {
                    $link = _wp_link_page($i) . $link . '</a>';
                    $link = '<li>' . $link . '</li>';
                } elseif ($i == $page) {
                    $link = '<li class="active"><span>' . $link . '<span class="sr-only">(current)</span></span></li>';
                }
                /**
                 * Filters the HTML output of individual page number links.
                 *
                 * @since 3.6.0
                 *
                 * @param string $link The page number HTML output.
                 * @param int    $i    Page number for paginated posts' page links.
                 */
                $link = apply_filters('wp_link_pages_link', $link, $i);

                // Use the custom links separator beginning with the second link.
                $output .= ( 1 === $i ) ? ' ' : $r['separator'];
                $output .= $link;
            }
            $output .= $r['after'];
        } elseif ($more) {
            $output .= $r['before'];
            $prev = $page - 1;
            if ($prev > 0) {
                $link = _wp_link_page($prev) . $r['link_before'] . $r['previouspagelink'] . $r['link_after'] . '</a>';
                $link = '<li>' . $link . '</li>';
                /** This filter is documented in wp-includes/post-template.php */
                $output .= apply_filters('wp_link_pages_link', $link, $prev);
            }
            $next = $page + 1;
            if ($next <= $numpages) {
                if ($prev) {
                    $output .= $r['separator'];
                }
                $link = _wp_link_page($next) . $r['link_before'] . $r['nextpagelink'] . $r['link_after'] . '</a>';
                $link = '<li>' . $link . '</li>';
                /** This filter is documented in wp-includes/post-template.php */
                $output .= apply_filters('wp_link_pages_link', $link, $next);
            }
            $output .= $r['after'];
        }
    }

    /**
     * Filters the HTML output of page links for paginated posts.
     *
     * @since 3.6.0
     *
     * @param string $output HTML output of paginated posts' page links.
     * @param array  $args   An array of arguments.
     */
    $html = apply_filters('wp_link_pages', $output, $args);

    if ($r['echo']) {
        echo $html;
    }
    return $html;
}

/*********************************************************************************************************************
 * Provide the links to the next/previous post, wrapped in bootstrap 'pills'
 ********************************************************************************************************************/
/**
 * Displays the navigation to next/previous post, when applicable.
 *
 * @since 4.1.0
 *
 * @param array $args Optional. See get_the_post_navigation() for available arguments.
 *                    Default empty array.
 */
function bootstrap_the_post_navigation($args = array()) {
    echo bootstrap_get_the_post_navigation($args);
}

function bootstrap_get_the_post_navigation($args = array()) {
    $args = wp_parse_args($args, array(
        'prev_text' => '%title',
        'next_text' => '%title',
        'in_same_term' => false,
        'excluded_terms' => '',
        'taxonomy' => 'category',
        'screen_reader_text' => __('Post navigation'),
    ));

    $navigation = '';

    $previous = get_previous_post_link(
        '<li class="previous">%link</li>', $args['prev_text'], $args['in_same_term'], $args['excluded_terms'], $args['taxonomy']
    );

    $next = get_next_post_link(
        '<li class="next">%link</li>', $args['next_text'], $args['in_same_term'], $args['excluded_terms'], $args['taxonomy']
    );

    // Only add markup if there's somewhere to navigate to.
    if ($previous || $next) {
        $navigation = _bootstrap_navigation_markup($previous . $next, 'post-navigation', $args['screen_reader_text']);
    }

    return $navigation;
}

/**
 * Wraps passed links in navigational markup.
 *
 * @since 4.1.0
 * @access private
 *
 * @param string $links              Navigational links.
 * @param string $class              Optional. Custom class for nav element. Default: 'posts-navigation'.
 * @param string $screen_reader_text Optional. Screen reader text for nav element. Default: 'Posts navigation'.
 * @return string Navigation template tag.
 */
function _bootstrap_navigation_markup($links, $class = 'posts-navigation', $screen_reader_text = '') {
    if (empty($screen_reader_text)) {
        $screen_reader_text = __('Posts navigation');
    }

    $template = '
	<nav class="navigation %1$s" role="navigation">
		<h2 class="sr-only">%2$s</h2>
		<ul class="pager">%3$s</ul>
	</nav>';

    /**
     * Filters the navigation markup template.
     *
     * Note: The filtered template HTML must contain specifiers for the navigation
     * class (%1$s), the sr-only value (%2$s), and placement of the
     * navigation links (%3$s):
     *
     *     <nav class="navigation %1$s" role="navigation">
     *         <h2 class="sr-only">%2$s</h2>
     *         <div class="nav-links">%3$s</div>
     *     </nav>
     *
     *      the bootstrap way
     *      <nav class="navigation %1$s" role="navigation">
     *         <h2 class="sr-only">%2$s</h2>
     *         <ul class="pager">%3$s</ul>
     *     </nav>
     * @since 4.4.0
     *
     * @param string $template The default template.
     * @param string $class    The class passed by the calling function.
     * @return string Navigation template.
     */
    $template = apply_filters('navigation_markup_template', $template, $class);

    return sprintf($template, sanitize_html_class($class), esc_html($screen_reader_text), $links);
}

/*********************************************************************************************************************
 * Provide pagination links for posts, wrapped in bootstrap 'pager'
 ********************************************************************************************************************/

/**
 * Displays a paginated navigation to next/previous set of posts, when applicable.
 *
 * @since 4.1.0
 *
 * @param array $args Optional. See get_the_posts_pagination() for available arguments.
 *                    Default empty array.
 */
function bootstrap_the_posts_pagination($args = array()) {
    echo bootstrap_get_the_posts_pagination($args);
}

/**
 * Retrieves a paginated navigation to next/previous set of posts, when applicable.
 *
 * @since 4.1.0
 *
 * @param array $args {
 *     Optional. Default pagination arguments, see paginate_links().
 *
 *     @type string $screen_reader_text Screen reader text for navigation element.
 *                                      Default 'Posts navigation'.
 * }
 * @return string Markup for pagination links.
 */
function bootstrap_get_the_posts_pagination($args = array()) {
    $navigation = '';

    // Don't print empty markup if there's only one page.
    if ($GLOBALS['wp_query']->max_num_pages > 1) {
        $args = wp_parse_args($args, array(
            'mid_size' => 1,
            'prev_text' => _x('<i class="fa fa-angle-left"></i>', 'previous post'),
            'next_text' => _x('<i class="fa fa-angle-right"></i>', 'next post'),
            'screen_reader_text' => __('Posts pagination'),
        ));

        // Make sure we get a string back. Plain is the next best thing.
        if (isset($args['type']) && 'array' == $args['type']) {
            $args['type'] = 'plain';
        }

        // Set up paginated links.
        $links = bootstrap_paginate_links($args);

        if ($links) {
            $navigation = _bootstrap_pagination_markup($links, 'pagination', $args['screen_reader_text']);
        }
    }

    return $navigation;
}

/**
 * Retrieve paginated link for archive post pages.
 *
 * Technically, the function can be used to create paginated link list for any
 * area. The 'base' argument is used to reference the url, which will be used to
 * create the paginated links. The 'format' argument is then used for replacing
 * the page number. It is however, most likely and by default, to be used on the
 * archive post pages.
 *
 * The 'type' argument controls format of the returned value. The default is
 * 'plain', which is just a string with the links separated by a newline
 * character. The other possible values are either 'array' or 'list'. The
 * 'array' value will return an array of the paginated link list to offer full
 * control of display. The 'list' value will place all of the paginated links in
 * an unordered HTML list.
 *
 * The 'total' argument is the total amount of pages and is an integer. The
 * 'current' argument is the current page number and is also an integer.
 *
 * An example of the 'base' argument is "http://example.com/all_posts.php%_%"
 * and the '%_%' is required. The '%_%' will be replaced by the contents of in
 * the 'format' argument. An example for the 'format' argument is "?page=%#%"
 * and the '%#%' is also required. The '%#%' will be replaced with the page
 * number.
 *
 * You can include the previous and next links in the list by setting the
 * 'prev_next' argument to true, which it is by default. You can set the
 * previous text, by using the 'prev_text' argument. You can set the next text
 * by setting the 'next_text' argument.
 *
 * If the 'show_all' argument is set to true, then it will show all of the pages
 * instead of a short list of the pages near the current page. By default, the
 * 'show_all' is set to false and controlled by the 'end_size' and 'mid_size'
 * arguments. The 'end_size' argument is how many numbers on either the start
 * and the end list edges, by default is 1. The 'mid_size' argument is how many
 * numbers to either side of current page, but not including current page.
 *
 * It is possible to add query vars to the link by using the 'add_args' argument
 * and see add_query_arg() for more information.
 *
 * The 'before_page_number' and 'after_page_number' arguments allow users to
 * augment the links themselves. Typically this might be to add context to the
 * numbered links so that screen reader users understand what the links are for.
 * The text strings are added before and after the page number - within the
 * anchor tag.
 *
 * @since 2.1.0
 *
 * @global WP_Query   $wp_query
 * @global WP_Rewrite $wp_rewrite
 *
 * @param string|array $args {
 *     Optional. Array or string of arguments for generating paginated links for archives.
 *
 *     @type string $base               Base of the paginated url. Default empty.
 *     @type string $format             Format for the pagination structure. Default empty.
 *     @type int    $total              The total amount of pages. Default is the value WP_Query's
 *                                      `max_num_pages` or 1.
 *     @type int    $current            The current page number. Default is 'paged' query var or 1.
 *     @type bool   $show_all           Whether to show all pages. Default false.
 *     @type int    $end_size           How many numbers on either the start and the end list edges.
 *                                      Default 1.
 *     @type int    $mid_size           How many numbers to either side of the current pages. Default 2.
 *     @type bool   $prev_next          Whether to include the previous and next links in the list. Default true.
 *     @type bool   $prev_text          The previous page text. Default '« Previous'.
 *     @type bool   $next_text          The next page text. Default '« Previous'.
 *     @type string $type               Controls format of the returned value. Possible values are 'plain',
 *                                      'array' and 'list'. Default is 'plain'.
 *     @type array  $add_args           An array of query args to add. Default false.
 *     @type string $add_fragment       A string to append to each link. Default empty.
 *     @type string $before_page_number A string to appear before the page number. Default empty.
 *     @type string $after_page_number  A string to append after the page number. Default empty.
 * }
 * @return array|string|void String of page links or array of page links.
 */
function bootstrap_paginate_links($args = '') {
    global $wp_query, $wp_rewrite;

    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $url_parts = explode('?', $pagenum_link);

    // Get max pages and current page out of the current query, if available.
    $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

    // URL base depends on permalink settings.
    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    $defaults = array(
        'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format' => $format, // ?page=%#% : %#% is replaced by the page number
        'total' => $total,
        'current' => $current,
        'show_all' => false,
        'prev_next' => true,
        'prev_text' => __('&laquo; Previous'),
        'next_text' => __('Next &raquo;'),
        'end_size' => 1,
        'mid_size' => 2,
        'type' => 'plain',
        'add_args' => array(), // array of query args to add
        'add_fragment' => '',
        'before_page_number' => '',
        'after_page_number' => ''
    );

    $args = wp_parse_args($args, $defaults);

    if (!is_array($args['add_args'])) {
        $args['add_args'] = array();
    }

    // Merge additional query vars found in the original URL into 'add_args' array.
    if (isset($url_parts[1])) {
        // Find the format argument.
        $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
        $format_query = isset($format[1]) ? $format[1] : '';
        wp_parse_str($format_query, $format_args);

        // Find the query args of the requested URL.
        wp_parse_str($url_parts[1], $url_query_args);

        // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
        foreach ($format_args as $format_arg => $format_arg_value) {
            unset($url_query_args[$format_arg]);
        }

        $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
    }

    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    if ($total < 2) {
        return;
    }
    $current = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ($end_size < 1) {
        $end_size = 1;
    }
    $mid_size = (int) $args['mid_size'];
    if ($mid_size < 0) {
        $mid_size = 2;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;

    if ($args['prev_next'] && $current && 1 < $current) :
        $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
        $link = str_replace('%#%', $current - 1, $link);
        if ($add_args)
            $link = add_query_arg($add_args, $link);
        $link .= $args['add_fragment'];

        /**
         * Filters the paginated links for the given archive pages.
         *
         * @since 3.0.0
         *
         * @param string $link The paginated link URL.
         */
        $page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['prev_text'] . '</a></li>';
    endif;
    for ($n = 1; $n <= $total; $n++) :
        if ($n == $current) :
            $page_links[] = "<li class='active'><span>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "<span class='sr-only'>(current)</span></span></li>";
            $dots = true;
        else :
            if ($args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size )) :
                $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                $link = str_replace('%#%', $n, $link);
                if ($add_args)
                    $link = add_query_arg($add_args, $link);
                $link .= $args['add_fragment'];

                /** This filter is documented in wp-includes/general-template.php */
                $page_links[] = "<li><a href='" . esc_url(apply_filters('paginate_links', $link)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</a></li>";
                $dots = true;
            elseif ($dots && !$args['show_all']) :
                $page_links[] = '<li><span class="dots">' . __('&hellip;') . '</span></li>';
                $dots = false;
            endif;
        endif;
    endfor;
    if ($args['prev_next'] && $current && ( $current < $total || -1 == $total )) :
        $link = str_replace('%_%', $args['format'], $args['base']);
        $link = str_replace('%#%', $current + 1, $link);
        if ($add_args)
            $link = add_query_arg($add_args, $link);
        $link .= $args['add_fragment'];

        /** This filter is documented in wp-includes/general-template.php */
        $page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['next_text'] . '</a></li>';
    endif;
    switch ($args['type']) {
        case 'array' :
            return $page_links;

        case 'list' :
            $r .= "<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n";
            break;

        default :
            $r = join("\n", $page_links);
            break;
    }
    return $r;
}

/**
 * Wraps passed links in navigational markup.
 *
 * @since 4.1.0
 * @access private
 *
 * @param string $links              Navigational links.
 * @param string $class              Optional. Custom class for nav element. Default: 'posts-navigation'.
 * @param string $screen_reader_text Optional. Screen reader text for nav element. Default: 'Posts navigation'.
 * @return string Navigation template tag.
 */
function _bootstrap_pagination_markup($links, $class = 'posts-pagination', $screen_reader_text = '') {
    if (empty($screen_reader_text)) {
        $screen_reader_text = __('Posts navigation');
    }

    $template = '
	<nav class="navigation" role="navigation">
		<h2 class="sr-only">%2$s</h2>
		<ul class="pagination">%3$s</ul>
	</nav>';

    /**
     * Filters the navigation markup template.
     *
     * Note: The filtered template HTML must contain specifiers for the navigation
     * class (%1$s), the sr-only value (%2$s), and placement of the
     * navigation links (%3$s):
     *
     *     <nav class="navigation %1$s" role="navigation">
     *         <h2 class="sr-only">%2$s</h2>
     *         <div class="nav-links">%3$s</div>
     *     </nav>
     *
     *      the bootstrap way
     *      <nav class="navigation %1$s" role="navigation">
     *         <h2 class="sr-only">%2$s</h2>
     *         <ul class="pagination">%3$s</ul>
     *     </nav>
     * @since 4.4.0
     *
     * @param string $template The default template.
     * @param string $class    The class passed by the calling function.
     * @return string Navigation template.
     */
    $template = apply_filters('navigation_markup_template', $template, $class);

    return sprintf($template, sanitize_html_class($class), esc_html($screen_reader_text), $links);
}