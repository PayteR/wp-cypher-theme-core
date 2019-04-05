<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$cypher_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: 'Cypher &rsaquo; Error';
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $cypher_error('You must be using PHP 7.1 or greater.', 'Invalid PHP version');
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('5.0.1', get_bloginfo('version'), '>=')) {
    $cypher_error('You must be using WordPress 5.0.1 or greater.', 'Invalid WordPress version');
}

/**
 * Function to include parent php file content.
 * $file parameter is always __FILE__ like this
 * include_parent_file(__FILE__)
 *
 * @param $file
 */
if (!function_exists('include_parent_file')) {
    function include_parent_file($file)
    {
        $file = str_replace("\\", '/', $file);

        $child = str_replace("\\", '/', get_stylesheet_directory());
        $parent = str_replace("\\", '/', get_template_directory());

        $child = rtrim($child, '/resources');
        $parent = rtrim($parent, '/resources');

        $file_path = str_replace($child, '', $file);

        require_once $parent . $file_path;
    }
}

/**
 * Fix for multisite directory uri
 */
if(MULTISITE && !function_exists('stylesheet_directory_multisite_fix')) {
    function stylesheet_directory_multisite_fix( $stylesheet_dir_uri )
    {
        $parsed_url = parse_url($stylesheet_dir_uri);
        $query = $parsed_url['query'] ?? '';
        return home_url($parsed_url['path'] .  $query);
    }
    add_filter('stylesheet_directory_uri', 'stylesheet_directory_multisite_fix');
}

if(MULTISITE && !function_exists('plugins_url_fix')) {
    function plugins_url_fix( $url )
    {
        $parsed_url = parse_url($url);
        $query = $parsed_url['query'] ?? '';
        return home_url($parsed_url['path'] .  $query);
    }
    add_filter('plugins_url', 'plugins_url_fix');
}

// Important to relative url, check later
if(MULTISITE && !function_exists('network_home_url_fix')) {
    function network_home_url_fix( $url )
    {
        $parsed_url = parse_url($url);
        $query = $parsed_url['query'] ?? '';
        return home_url($parsed_url['path'] .  $query);
    }
    add_filter('network_home_url', 'network_home_url_fix');
}


/**
 * Sage default controller backward compatibility fix
 */
add_filter('sober/controller/sage/namespace', function(){
    return '';
});

Container::getInstance()
    ->bindIf('config', function () {
        $files = [];
        $parent_path = get_parent_theme_file_path() . '/config/';
        $child_path = get_theme_file_path() . '/config/';

        $parent_configs = scandir( $parent_path );
        foreach ($parent_configs as $config_file) {
            if(pathinfo($config_file, PATHINFO_EXTENSION) !== 'php') {
                continue;
            }
            $files[pathinfo($config_file, PATHINFO_FILENAME)] = $parent_path . $config_file;
        }

        $child_configs = scandir( $child_path );
        foreach ($child_configs as $config_file) {
            if(pathinfo($config_file, PATHINFO_EXTENSION) !== 'php') {
                continue;
            }
            $files[pathinfo($config_file, PATHINFO_FILENAME)] = $child_path . $config_file;
        }

        foreach ($files as $key => $file) {
            $files[$key] = require $file;
        }
        return new Config($files);
    }, true);
