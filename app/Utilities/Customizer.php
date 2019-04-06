<?php

namespace Cypher\Utilities;

class Customizer
{
    /**
     * Theme customizer
     */
    public static function postMessageSupport()
    {
        add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
            $wp_customize->get_setting('blogname')->transport = 'postMessage';
            $wp_customize->selective_refresh->add_partial('blogname', [
                'selector' => '.brand',
                'render_callback' => function () {
                    bloginfo('name');
                },
            ]);
        });
    }

    public static function embedJsFile()
    {
        /**
         * Customizer JS
         */
        add_action('customize_preview_init', function () {
            wp_enqueue_script('cypher/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null,
                true);
        });
    }
}
