<?php

namespace Cypher;

/**
 * Custom Navwalker Class
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * Class Name: NavWalker
 * Description: Custom navigation walker for Bulma CSS framework
 * Version: 0.0.1
 * Author: Peter "PayteR" Gašparík
 * Credit: Inspired by Seyong Cho
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class NavWalker extends \Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '';
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '';
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        if ($this->hasChildren($item)) {
            $output .= $this->startDropdownButton($item);
        } else {
            $output .= $this->getLinkButton($item);
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        if ($this->hasChildren($item)) {
            $output .= $this->endDropdownButton($item);
        } else {
            $output .= '';
        }
    }

    public function hasChildren($item)
    {
        if (in_array("menu-item-has-children", $item->classes)) {
            return true;
        }

        return false;
    }

    public function getLinkButton($item)
    {
        $url = $item->url ?? '';
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = '';

        if (in_array('current-menu-item', $classes)) {
            $class_names .= 'is-active';
        }

        $button = sprintf("<a href='%s' class='navbar-item %s'><span class='navbar-label'>%s</span></a>", $url,
            $class_names,
            $item->title);

        return $button;
    }

    public function startDropdownButton($item)
    {
        $url = $item->url ?? '';
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = '';

        if (in_array('current-menu-item', $classes)) {
            $class_names .= 'is-active';
        }

        $button = sprintf("<a href='%s' class='navbar-link %s'><span class='navbar-label'>%s</span></a>", $url, $class_names, $item->title);

        $dropdown = sprintf("<div class='navbar-item has-dropdown is-hoverable'>%s", $button);

        $dropdown .= "<div class='navbar-dropdown'>";
        return $dropdown;
    }

    public function endDropdownButton($item)
    {
        return "</div></div>";
    }
}
