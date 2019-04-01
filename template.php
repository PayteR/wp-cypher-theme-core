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
