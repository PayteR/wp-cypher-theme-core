<?php

use Roots\Sage\Container;

/**
 * Get the cypher container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function cypher($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("cypher.{$abstract}", $parameters);
}

/**
 * Just alias for backward compatibility
 *
 * @param null $abstract
 * @param array $parameters
 * @param Container|null $container
 * @return mixed|Container
 */
function sage($abstract = null, $parameters = [], Container $container = null) {
    return cypher($abstract, $parameters, $container);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 * @throws \Illuminate\Container\EntryNotFoundException
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return cypher('config');
    }
    if (is_array($key)) {
        return cypher('config')->set($key);
    }
    return cypher('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return cypher('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return cypher('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return cypher('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('cypher/filter_templates/paths', [
        'resources/views',
        'views',
        ''
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    $path = $path ? $path . '/' : '';
                    return [
                        "{$path}{$template}.blade.php",
                        "{$path}{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * Get vendor path
 *
 * @return string
 */
function get_vendor_directory() {
    return __DIR__;
}

/**
 * Return file from vendor path
 *
 * @param string $file
 * @return string
 */
function get_vendor_theme_file_path( $file = '' ){
    $file = ltrim( $file, '/' );

    if ( empty( $file ) ) {
        $path = get_vendor_directory();
    } else {
        $path = get_vendor_directory() . '/' . $file;
    }

    return $path;
}

/**
 * @param string $template
 * @param null $type
 * @param string|string[] $templates Possible template files
 * @return string
 */
function filter_templates_vendor($template = '', $type = null, $templates = [])
{
    if($template || !$type || !count($templates)) {
        return $template;
    }

    $located = '';
    foreach ( (array) $templates as $template_name ) {
        if ( ! $template_name ) {
            continue;
        }
        if ( file_exists( $file = get_vendor_theme_file_path( $template_name ) ) ) {
            $located = $file;
            break;
        }
    }

    return $located;
}
