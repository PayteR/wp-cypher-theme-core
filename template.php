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
