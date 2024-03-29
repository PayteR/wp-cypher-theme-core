<?php

/**
 * This file is crucial to work with woocommerce
 *
 * Inspired by: https://github.com/roots/sage-woocommerce
 */

namespace Cypher;


if (defined('WC_ABSPATH')) {
    add_action('after_setup_theme', function () {
        add_theme_support('woocommerce');
    });

    /**
     * @param string $template
     * @return string
     */
    function wc_template_loader(String $template)
    {
        return (strpos($template, WC_ABSPATH) === -1
            ? $template
            : \Cypher\locate_template(WC()->template_path() . str_replace(WC_ABSPATH . 'templates/', '', $template))) ? :
                $template;
    }
    add_filter('template_include', __NAMESPACE__ . '\\wc_template_loader', 100, 1);
    add_filter('comments_template', __NAMESPACE__ . '\\wc_template_loader', 100, 1);

    add_filter('wc_get_template_part', function ($template) {
        $theme_template = \Cypher\locate_template(WC()->template_path() . str_replace(WC_ABSPATH . 'templates/', '', $template));

        if ($theme_template) {
            $data = collect(get_body_class())->reduce(function ($data, $class) {
                return apply_filters("cypher/template/{$class}/data", $data);
            }, []);

            echo template($theme_template, $data);
            return get_stylesheet_directory() . '/index.php';
        }

        return $template;
    }, 2000000, 1);

    add_action('woocommerce_before_template_part', function ($template_name, $template_path, $located, $args) {
        $theme_template = \Cypher\locate_template(WC()->template_path() . $template_name);

        if ($theme_template) {
            $data = collect(get_body_class())->reduce(function ($data, $class) {
                return apply_filters("cypher/template/{$class}/data", $data);
            }, []);

            echo template($theme_template, array_merge(
                compact(explode(' ', 'template_name template_path located args')),
                $data,
                $args
            ));
        }
    }, PHP_INT_MAX, 4);

    add_filter('wc_get_template', function ($template, $template_name, $args) {
        $theme_template = \Cypher\locate_template(WC()->template_path() . $template_name);

        // return theme filename for status screen
        if (is_admin() && function_exists('get_current_screen') && get_current_screen()->id === 'woocommerce_page_wc-status') {
            return $theme_template ? : $template;
        }

        // return empty file, output already rendered by 'woocommerce_before_template_part' hook
        return $theme_template ? get_stylesheet_directory() . '/index.php' : $template;
    }, 100, 3);
}
