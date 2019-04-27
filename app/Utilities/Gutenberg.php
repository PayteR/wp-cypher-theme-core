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

if(!defined("CYPHER_COLOR_PRIMARY")) define("CYPHER_COLOR_PRIMARY", '#3273DC');
if(!defined("CYPHER_COLOR_SECONDARY")) define("CYPHER_COLOR_SECONDARY", '#B86BFF');
if(!defined("CYPHER_COLOR_BLACK")) define("CYPHER_COLOR_BLACK", '#0A0A0A');
if(!defined("CYPHER_COLOR_BLACK_BIS")) define("CYPHER_COLOR_BLACK_BIS", '#121212');
if(!defined("CYPHER_COLOR_BLACK_TER")) define("CYPHER_COLOR_BLACK_TER", '#242424');
if(!defined("CYPHER_COLOR_GREY_DARKER")) define("CYPHER_COLOR_GREY_DARKER", '#363636');
if(!defined("CYPHER_COLOR_GREY_DARK")) define("CYPHER_COLOR_GREY_DARK", '#4A4A4A');
if(!defined("CYPHER_COLOR_GREY")) define("CYPHER_COLOR_GREY", '#7A7A7A');
if(!defined("CYPHER_COLOR_GREY_LIGHT")) define("CYPHER_COLOR_GREY_LIGHT", '#B5B5B5');
if(!defined("CYPHER_COLOR_GREY_LIGHTER")) define("CYPHER_COLOR_GREY_LIGHTER", '#DBDBDB');
if(!defined("CYPHER_COLOR_WHITE_TER")) define("CYPHER_COLOR_WHITE_TER", '#F5F5F5');
if(!defined("CYPHER_COLOR_WHITE_BIS")) define("CYPHER_COLOR_WHITE_BIS", '#FAFAFA');
if(!defined("CYPHER_COLOR_WHITE")) define("CYPHER_COLOR_WHITE", '#FFFFFF');
if(!defined("CYPHER_COLOR_ORANGE")) define("CYPHER_COLOR_ORANGE", '#FF470F');
if(!defined("CYPHER_COLOR_YELLOW")) define("CYPHER_COLOR_YELLOW", '#FFDD57');
if(!defined("CYPHER_COLOR_GREEN")) define("CYPHER_COLOR_GREEN", '#23D160');
if(!defined("CYPHER_COLOR_TURQUOISE")) define("CYPHER_COLOR_TURQUOISE", '#00D1B2');
if(!defined("CYPHER_COLOR_CYAN")) define("CYPHER_COLOR_CYAN", '#209CEE');
if(!defined("CYPHER_COLOR_BLUE")) define("CYPHER_COLOR_BLUE",  '#3273DC');
if(!defined("CYPHER_COLOR_PURPLE")) define("CYPHER_COLOR_PURPLE", '#B86BFF');
if(!defined("CYPHER_COLOR_RED")) define("CYPHER_COLOR_RED", '#FF3860');

if(!defined("CYPHER_SIZE_7")) define("CYPHER_SIZE_7", 13);
if(!defined("CYPHER_SIZE_6")) define("CYPHER_SIZE_6", 16);
if(!defined("CYPHER_SIZE_5")) define("CYPHER_SIZE_5", 20);
if(!defined("CYPHER_SIZE_4")) define("CYPHER_SIZE_4", 24);
if(!defined("CYPHER_SIZE_3")) define("CYPHER_SIZE_3", 36);
if(!defined("CYPHER_SIZE_2")) define("CYPHER_SIZE_2", 40);
if(!defined("CYPHER_SIZE_1")) define("CYPHER_SIZE_1", 48);


class Gutenberg
{
    public static function setupColorPallete()
    {
        $function = function() {
            add_theme_support('editor-color-palette', [
                [
                    'name' => 'primary',
                    'slug' => 'primary',
                    'color' => CYPHER_COLOR_PRIMARY,
                ],
                [
                    'name' => 'secondary',
                    'slug' => 'secondary',
                    'color' => CYPHER_COLOR_SECONDARY,
                ],
                [
                    'name' => 'black',
                    'slug' => 'black',
                    'color' => CYPHER_COLOR_BLACK,
                ],
                [
                    'name' => 'black-bis',
                    'slug' => 'black-bis',
                    'color' => CYPHER_COLOR_BLACK_BIS,
                ],
                [
                    'name' => 'black-ter',
                    'slug' => 'black-ter',
                    'color' => CYPHER_COLOR_BLACK_TER,
                ],
                [
                    'name' => 'grey-darker',
                    'slug' => 'grey-darker',
                    'color' => CYPHER_COLOR_GREY_DARKER,
                ],
                [
                    'name' => 'grey-dark',
                    'slug' => 'grey-dark',
                    'color' => CYPHER_COLOR_GREY_DARK,
                ],
                [
                    'name' => 'grey',
                    'slug' => 'grey',
                    'color' => CYPHER_COLOR_GREY,
                ],
                [
                    'name' => 'grey-light',
                    'slug' => 'grey-light',
                    'color' => CYPHER_COLOR_GREY_LIGHT,
                ],
                [
                    'name' => 'grey-lighter',
                    'slug' => 'grey-lighter',
                    'color' => CYPHER_COLOR_GREY_LIGHTER,
                ],
                [
                    'name' => 'white-ter',
                    'slug' => 'white-ter',
                    'color' => CYPHER_COLOR_WHITE_TER,
                ],
                [
                    'name' => 'white-bis',
                    'slug' => 'white-bis',
                    'color' => CYPHER_COLOR_WHITE_BIS,
                ],
                [
                    'name' => 'white',
                    'slug' => 'white',
                    'color' => CYPHER_COLOR_WHITE,
                ],
                [
                    'name' => 'orange',
                    'slug' => 'orange',
                    'color' => CYPHER_COLOR_ORANGE,
                ],
                [
                    'name' => 'yellow',
                    'slug' => 'yellow',
                    'color' => CYPHER_COLOR_YELLOW,
                ],
                [
                    'name' => 'green',
                    'slug' => 'green',
                    'color' =>CYPHER_COLOR_GREEN ,
                ],
                [
                    'name' => 'turquoise',
                    'slug' => 'turquoise',
                    'color' => CYPHER_COLOR_TURQUOISE,
                ],
                [
                    'name' => 'cyan',
                    'slug' => 'cyan',
                    'color' => CYPHER_COLOR_CYAN,
                ],
                [
                    'name' => 'blue',
                    'slug' => 'blue',
                    'color' => CYPHER_COLOR_BLUE,
                ],
                [
                    'name' => 'purple',
                    'slug' => 'purple',
                    'color' => CYPHER_COLOR_PURPLE,
                ],
                [
                    'name' => 'red',
                    'slug' => 'red',
                    'color' => CYPHER_COLOR_RED,
                ],
            ]);
        };

        add_action('after_setup_theme', $function , 20);
    }

    public static function setupFontSizes()
    {
        $functions = function() {
            add_theme_support('editor-font-sizes', [
                [
                    'name' =>  'normal',
                    'shortName' => 'normal',
                    'size' => CYPHER_SIZE_6,
                    'slug' => 'normal',
                ],
                [
                    'name' =>  'size-7',
                    'shortName' => '7',
                    'size' => CYPHER_SIZE_7,
                    'slug' => 'size-7',
                ],
                [
                    'name' =>  'size-6',
                    'shortName' => '6',
                    'size' => CYPHER_SIZE_6,
                    'slug' => 'size-6',
                ],
                [
                    'name' =>  'size-5',
                    'shortName' => '5',
                    'size' => CYPHER_SIZE_5,
                    'slug' => 'size-5',
                ],
                [
                    'name' =>  'size-4',
                    'shortName' => '4',
                    'size' => CYPHER_SIZE_4,
                    'slug' => 'size-4',
                ],
                [
                    'name' =>  'size-3',
                    'shortName' => '3',
                    'size' => CYPHER_SIZE_3,
                    'slug' => 'size-3',
                ],
                [
                    'name' =>  'size-2',
                    'shortName' => '2',
                    'size' => CYPHER_SIZE_2,
                    'slug' => 'size-2',
                ],
                [
                    'name' =>  'size-1',
                    'shortName' => '1',
                    'size' => CYPHER_SIZE_1,
                    'slug' => 'size-1',
                ],
            ]);
        };

        add_action('after_setup_theme', $functions , 20);
//        add_theme_support('disable-custom-font-sizes');
    }

    public static function themeSupports()
    {
        $function = function() {
            add_theme_support('align-wide');
            // add_theme_support('wp-block-styles');
        };

        add_action('after_setup_theme', $function, 20);
    }
}
