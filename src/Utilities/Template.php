<?php
/**
 * PHP version 7.1
 *
 * @author Peter "PayteR" Gašparík
 * https://github.com/PayteR
 * @copyright 2019
 *
 */

namespace Cypher\Utilities;


class Template
{
    /**
     * Add <body> classes
     */
    public static function bodyClass ()
    {
        add_filter('body_class', function (array $classes) {
            /** Add page slug if it doesn't exist */
            if (is_single() || is_page() && !is_front_page()) {
                if (!in_array(basename(get_permalink()), $classes)) {
                    $classes[] = basename(get_permalink());
                }
            }

            /** Clean up class names for custom templates */
            $classes = array_map(function ($class) {
                return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
            }, $classes);

            return array_filter($classes);
        });
    }

    /**
     * Add "… Continued" to the excerpt
     */
    public static function excerpt ()
    {
        add_filter('excerpt_more', function () {
            return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
        });
    }

    /**
     * Template Hierarchy should search for .blade.php files
     */
    public static function templateHierarchy ()
    {
        collect([
            'index',
            '404',
            'archive',
            'author',
            'category',
            'tag',
            'taxonomy',
            'date',
            'home',
            'frontpage',
            'page',
            'paged',
            'search',
            'single',
            'singular',
            'attachment',
            'embed'
        ])->map(function ($type) {
            add_filter("{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates');
        });
    }

    /**
     * Render page using Blade
     */
    public static function templateInclude ()
    {
        add_filter('template_include', function ($template) {
            collect(['get_header', 'wp_head'])->each(function ($tag) {
                ob_start();
                do_action($tag);
                $output = ob_get_clean();
                remove_all_actions($tag);
                add_action($tag, function () use ($output) {
                    echo $output;
                });
            });
            $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
                return apply_filters("sage/template/{$class}/data", $data, $template);
            }, []);
            if ($template) {
                echo template($template, $data);

                return get_stylesheet_directory() . '/index.php';
            }

            return $template;
        }, PHP_INT_MAX);
    }

    /**
     * Render page using Blade
     */
    public static function commentsTemplate ()
    {
        /**
         * Render comments.blade.php
         */
        add_filter('comments_template', function ($comments_template) {
            $comments_template = str_replace(
                [get_stylesheet_directory(), get_template_directory()],
                '',
                $comments_template
            );

            $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
                return apply_filters("sage/template/{$class}/data", $data, $comments_template);
            }, []);

            $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

            if ($theme_template) {
                echo template($theme_template, $data);
                return get_stylesheet_directory().'/index.php';
            }

            return $comments_template;
        }, 100);

    }
}
