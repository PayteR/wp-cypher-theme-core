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


class Setup
{
    /**
     * Theme assets
     */
    public static function basicEnqueue()
    {
        $function = function() {
            wp_enqueue_style('cypher/main.css', asset_path('styles/main.css'), false, null);
            wp_enqueue_script('cypher/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

            if (is_single() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        };

        add_action('wp_enqueue_scripts', $function, 100);
    }

    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    public static function soilSupport($googleAnalyticsID = '')
    {
        add_theme_support('soil-clean-up');
        add_theme_support('soil-jquery-cdn');
        add_theme_support('soil-nav-walker');
        add_theme_support('soil-nice-search');
        add_theme_support('soil-relative-urls');
        add_theme_support('soil-disable-rest-api');
        add_theme_support('soil-disable-asset-versioning');
        add_theme_support('soil-disable-trackbacks');
        add_theme_support('soil-js-to-footer');

        if($googleAnalyticsID) {
            add_theme_support('soil-google-analytics', $googleAnalyticsID);
        }
    }

    /**
     * Theme setup
     */
    public static function themeSetup()
    {
        $function = function()
        {
            /**
             * Enable plugins to manage the document title
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
             */
            add_theme_support('title-tag');

            /**
             * Register navigation menus
             * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
             */
            register_nav_menus([
                'primary_navigation' => __('Primary Navigation', 'sage'),
            ]);

            register_nav_menus([
                'footer_navigation' => __('Footer Navigation', 'sage'),
            ]);

            /**
             * Enable post thumbnails
             * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
             */
            add_theme_support('post-thumbnails');

            /**
             * Enable HTML5 markup support
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
             */
            add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

            /**
             * Enable selective refresh for widgets in customizer
             * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
             */
            add_theme_support('customize-selective-refresh-widgets');

            /**
             * Woocommerce support
             */
            add_theme_support('woocommerce');

            /**
             * Responsive embeds
             */
            add_theme_support('responsive-embeds');

            /**
             * Logo
             */
            add_theme_support('custom-logo', [
                'flex-width' => true,
                'flex-height' => true,
            ]);

            /**
             * Use main stylesheet for visual editor
             * @see resources/assets/styles/layouts/_tinymce.scss
             */
            add_editor_style(asset_path('styles/editor-styles.css'));
            add_theme_support('editor-styles');
        };

        add_action('after_setup_theme', $function, 20);
    }

    /**
     * Register sidebars
     */
    public static function widgets()
    {
        $function = function ()
        {
            $config = [
                'before_widget' => '<section class="widget %1$s %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
            ];
            register_sidebar([
                    'name' => __('Primary', 'sage'),
                    'id' => 'sidebar-primary',
                ] + $config);
            register_sidebar([
                    'name' => __('Footer', 'sage'),
                    'id' => 'sidebar-footer',
                ] + $config);
        };

        add_action('widgets_init', $function);
    }
}
