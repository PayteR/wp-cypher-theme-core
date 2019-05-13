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

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

if(!defined("CYPHER_OPTION_DISPLAY_TITLE")) define("CYPHER_OPTION_DISPLAY_TITLE", "display_title");
if(!defined("CYPHER_OPTION_SUBTITLE_TEXT")) define("CYPHER_OPTION_SUBTITLE_TEXT", "subtitle_text");
if(!defined("CYPHER_OPTION_DISPLAY_SIDEBAR")) define("CYPHER_OPTION_DISPLAY_SIDEBAR", "display_sidebar");

class Metas
{
    public static function carbonInit()
    {
        static $inited;

        if (!$inited) {
            Carbon_Fields::boot();
            $inited = true;
        }

        return $inited;
    }

    public static function layoutMeta()
    {
        self::carbonInit();

        Container::make('post_meta',  _x( 'Layout options', 'layout meta', 'cypher' ))
            ->set_context('side')
            ->set_priority('low')
            ->set_revisions_disabled(true)
            ->add_fields(array(
                Field::make( 'select', CYPHER_OPTION_DISPLAY_TITLE, _x( 'Display title', 'layout meta', 'cypher' ) )
                    ->set_default_value( null )
                    ->set_options( array(
                        null => _x( 'Default by theme', 'layout meta', 'cypher' ),
                        true => _x( 'Display', 'layout meta', 'cypher' ),
                        false => _x( 'Hide', 'layout meta', 'cypher' )
                    ) ),
                Field::make( 'text', CYPHER_OPTION_SUBTITLE_TEXT, _x( 'Subtitle text', 'layout meta', 'cypher' ) ),
                Field::make( 'select', CYPHER_OPTION_DISPLAY_SIDEBAR, _x( 'Display sidebar', 'layout meta', 'cypher' ) )
                    ->set_default_value( null )
                    ->set_options( array(
                        null => _x( 'Default by theme', 'layout meta', 'cypher' ),
                        'right' => _x( 'Display right', 'layout meta', 'cypher' ),
                        'left' => _x( 'Display left', 'layout meta', 'cypher' ),
                        false => _x( 'Hide', 'layout meta', 'cypher' )
                    ) )
            ));


        add_filter('cypher/display_sidebar', function ($display) {
            if($display === null) return $display;

            $value = carbon_get_the_post_meta(CYPHER_OPTION_DISPLAY_SIDEBAR);
            $display = $value === "" || $value === null ? $display : $value;
            return $display;
        }, PHP_INT_MAX);

        add_filter('cypher/display_title', function ($display) {
            if($display === null) return $display;

            $value = carbon_get_the_post_meta(CYPHER_OPTION_DISPLAY_TITLE);
            $display = $value === "" || $value === null ? $display : $value;
            return $display;
        }, PHP_INT_MAX);

    }
}
