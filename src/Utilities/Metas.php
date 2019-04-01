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

        Container::make('post_meta',  __( 'Layout options' ))
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(array(
                Field::make( 'select', CYPHER_OPTION_DISPLAY_TITLE, __( 'Display title' ) )
                    ->set_default_value( null )
                    ->set_options( array(
                        null => __( 'Default by theme' ),
                        true => __( 'Display' ),
                        false => __( 'Hide' )
                    ) ),
                Field::make( 'select', CYPHER_OPTION_DISPLAY_SIDEBAR, __( 'Display sidebar' ) )
                    ->set_default_value( null )
                    ->set_options( array(
                        null => __( 'Default by theme' ),
                        true => __( 'Display' ),
                        false => __( 'Hide' )
                    ) )
            ));


        add_filter('cypher/display_sidebar', function ($display) {
            $value = carbon_get_the_post_meta(CYPHER_OPTION_DISPLAY_SIDEBAR);
            $display = $value === "" || $value === null ? $display : $value;
            return $display;
        });

        add_filter('cypher/display_title', function ($display) {
            $value = carbon_get_the_post_meta(CYPHER_OPTION_DISPLAY_TITLE);
            $display = $value === "" || $value === null ? $display : $value;
            return $display;
        });

    }
}
