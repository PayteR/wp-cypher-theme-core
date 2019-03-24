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

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade as BladeBase;
use Roots\Sage\Template\BladeProvider;

class Blade
{
    /**
     * Updates the `$post` variable on each iteration of the loop.
     * Note: updated value is only available for subsequently loaded views, such as partials
     */
    public static function setup()
    {
        $function = function ($post)
        {
            cypher('blade')->share('post', $post);
        };

        add_action('the_post', $function);


        /**
         * Add JsonManifest to Sage container
         */
        cypher()->singleton('sage.assets', function () {
            return new JsonManifest(config('assets.manifest'), config('assets.uri'));
        });

        /**
         * Add Blade to Sage container
         */
        cypher()->singleton('sage.blade', function (Container $app) {
            $cachePath = config('view.compiled');
            if (!file_exists($cachePath)) {
                wp_mkdir_p($cachePath);
            }
            (new BladeProvider($app))->register();

            return new BladeBase($app['view']);
        });

        /**
         * Create @asset() Blade directive
         */
        cypher('blade')->compiler()->directive('asset', function ($asset) {
            return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
        });
    }
}
