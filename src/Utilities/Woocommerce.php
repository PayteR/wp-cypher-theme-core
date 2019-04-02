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


class Woocommerce
{
    public static function disableDefaultStyles()
    {
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    }
}
