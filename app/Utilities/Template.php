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

            if($position = \Cypher\display_sidebar()) {
                $classes[] = 'is-sidebar-' . $position;
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
    public static function excerpt()
    {
        add_filter('excerpt_more', function () {
            return ' &hellip; <a href="' . get_permalink() . '">' . __('Read more', 'cypher') . '</a>';
        });
    }

    /**
     * Browser not support notification to obsolete browsers
     */
    public static function browserSupportNotification ()
    {
        add_action('get_header', function () {
            ?><div class="container">
                <div class="notification is-danger is-browsersupport">
                    <?= __('You are using an <strong>outdated</strong> browser, you may experience issues.
                Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to
                improve your experience.', 'cypher') ?>
                </div>
            </div><?php
        });
    }

    /**
     * Browser not support notification to obsolete browsers
     */
    public static function privacyPolicyPanel ()
    {
        add_action('get_header', function () {
            $privacy_page = \get_option('wp_page_for_privacy_policy');

            if(!$privacy_page) return;

            get_the_permalink($privacy_page)
            ?><div class="privacy_policy">
                <div class="privacy_policy-container container">
                <p class="privacy_policy-message"><?= sprintf( _x('We use cookies on our site to improve your experience of our site. By clicking on, and continuing to use this site you consent for us to set cookies in accordance with your current browser settings. Find out more in our <a href="%s" target="_blank">Cookies Policy</a>', 'privacy policy', 'cypher'), $privacy_page) ?>.</p>
                <button type="button" class="privacy_policy-button button is-primary"><?= _x('Close', 'privacy policy', 'cypher')
                    ?></button>
                </div>
            </div><?php

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
            add_filter("{$type}_template_hierarchy", 'filter_templates');
            add_filter("{$type}_template", 'filter_templates_vendor', 10, 3);
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
                return apply_filters("app/template/{$class}/data", $data, $template);
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
                return apply_filters("cypher/template/{$class}/data", $data, $comments_template);
            }, []);

            $theme_template = \Cypher\locate_template(["views/{$comments_template}", $comments_template]);

            if ($theme_template) {
                echo template($theme_template, $data);
                return get_stylesheet_directory().'/index.php';
            }

            return $comments_template;
        }, 100);

    }
}
