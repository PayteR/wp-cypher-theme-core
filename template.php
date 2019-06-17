<?php

namespace Cypher;

/**
 * Determine whether to show the sidebar
 * @param null $default
 * @return bool
 */
function display_sidebar($default = null)
{
    static $display;
    isset($display) || $display = apply_filters('cypher/display_sidebar', $default);

    return $display;
}

/**
 * Determine whether to show title
 * @param null $default
 * @return bool
 */
function display_title($default = null)
{
    static $display;
    isset($display) || $display = apply_filters('cypher/display_title', $default);

    return $display;
}


/**
 * This is rewrite of locate_template function to locate vendor templates
 *
 * @param string|string[] $template_names Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($template_names)
{
    $template_names = filter_templates($template_names);

    $located = '';
    foreach ( (array) $template_names as $template_name ) {
        if ( ! $template_name ) {
            continue;
        }

        if ( file_exists( STYLESHEETPATH . '/' . $template_name ) ) {
            $located = STYLESHEETPATH . '/' . $template_name;
            break;
        } elseif ( file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
            $located = TEMPLATEPATH . '/' . $template_name;
            break;
        } elseif ( file_exists( $file = get_vendor_theme_file_path($template_name) ) ) {
            $located = $file;
            break;
        } elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/' . $template_name ) ) {
            $located = ABSPATH . WPINC . '/theme-compat/' . $template_name;
            break;
        }
    }

    return $located;
}


/**
 * Determine whether Woocommerce is activated
 * https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 *
 * @return bool
 */
function is_woocommerce_activated()
{
    return class_exists( '\WooCommerce' );
}
/**
 * Determine whether is current page Woocomerce page
 * https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 *
 * @return bool
 */
function is_woocommerce_any_page()
{
    if(!is_woocommerce_activated()) {
        return false;
    }

    return is_woocommerce() || is_checkout() || is_cart() || is_account_page();
}

/**
 * Bulma pagination
 * credits to https://github.com/Nicuz/Bulma-WordPress-snippets
 */
function pagination() {
    global $wp_query;
    $big = 999999999; //I trust StackOverflow.
    $total_pages = $wp_query->max_num_pages; //you can set a custom int value to this var
    $pages = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $total_pages,
        'type'  => 'array',
        'prev_text'    => vendor_x( 'Previous', 'pagination', 'cypher' ),
        'next_text'    => vendor_x( 'Next', 'pagination', 'cypher'),
    ) );

    if ( is_array( $pages ) ) {
        echo '<nav class="pagination is-centered" role="navigation" aria-label="pagination">';

        //Get current page
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var( 'paged' );

        //Disable Previous button if the current page is the first one
        if ($paged == 1) {
            echo '<a class="pagination-previous" disabled>' . vendor_x( 'Previous', 'pagination', 'cypher' ) . '</a>';
        } else {
            echo '<a class="pagination-previous" href="' . get_previous_posts_page_link() . '">' . vendor_x( 'Previous', 'pagination', 'cypher' ) . '</a>';
        }

        //Disable Next button if the current page is the last one
        if ($paged<$total_pages) {
            echo '<a class="pagination-next" href="' . get_next_posts_page_link() . '">' . vendor_x( 'Next', 'pagination', 'cypher' ) . '</a>
      <ul class="pagination-list">';
        } else {
            echo '<a class="pagination-next" disabled>' . vendor_x( 'Next', 'pagination', 'cypher' ) . '</a>
      <ul class="pagination-list">';
        }

        for ($i=1; $i<=$total_pages; $i++) {
            if ($i == $paged) {
                echo '<li><a class="pagination-link is-current" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            } else {
                echo '<li><a class="pagination-link" href="'. get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }

        echo '</ul>';

        echo '</nav>';
    }
}

