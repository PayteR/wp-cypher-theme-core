<?php

/**
 * This are extended helpers for l10n. Use this to wrap
 * vendor tranlations in your template to prevent poedit
 * get this strings into list. Example:
 *
 * // this translation will be ignored by poedit
 * vendor__( 'Dtring from Woocommerce', 'woocommerce' );
 *
 * @param $text
 * @param string $domain
 * @return string
 */

if(!defined('CYPHER_DISABLE_VENDOR_L10N')) {
    function vendor__( $text, $domain = 'default' ) {
        return translate( $text, $domain );
    }

    function vendor_esc_attr__( $text, $domain = 'default' ) {
        return esc_attr( translate( $text, $domain ) );
    }

    function vendor_esc_html__( $text, $domain = 'default' ) {
        return esc_html( translate( $text, $domain ) );
    }

    function vendor_e( $text, $domain = 'default' ) {
        echo translate( $text, $domain );
    }

    function vendor_esc_attr_e( $text, $domain = 'default' ) {
        echo esc_attr( translate( $text, $domain ) );
    }

    function vendor_esc_html_e( $text, $domain = 'default' ) {
        echo esc_html( translate( $text, $domain ) );
    }

    function vendor_x( $text, $context, $domain = 'default' ) {
        return translate_with_gettext_context( $text, $context, $domain );
    }

    function vendor_ex( $text, $context, $domain = 'default' ) {
        echo _x( $text, $context, $domain );
    }

    function vendor_esc_attr_x( $text, $context, $domain = 'default' ) {
        return esc_attr( translate_with_gettext_context( $text, $context, $domain ) );
    }

    function vendor_esc_html_x( $text, $context, $domain = 'default' ) {
        return esc_html( translate_with_gettext_context( $text, $context, $domain ) );
    }

    function vendor_n( $single, $plural, $number, $domain = 'default' ) {
        $translations = get_translations_for_domain( $domain );
        $translation  = $translations->translate_plural( $single, $plural, $number );

        /**
         * Filters the singular or plural form of a string.
         *
         * @since 2.2.0
         *
         * @param string $translation Translated text.
         * @param string $single      The text to be used if the number is singular.
         * @param string $plural      The text to be used if the number is plural.
         * @param string $number      The number to compare against to use either the singular or plural form.
         * @param string $domain      Text domain. Unique identifier for retrieving translated strings.
         */
        return apply_filters( 'ngettext', $translation, $single, $plural, $number, $domain );
    }

    function vendor_nx( $single, $plural, $number, $context, $domain = 'default' ) {
        $translations = get_translations_for_domain( $domain );
        $translation  = $translations->translate_plural( $single, $plural, $number, $context );

        /**
         * Filters the singular or plural form of a string with gettext context.
         *
         * @since 2.8.0
         *
         * @param string $translation Translated text.
         * @param string $single      The text to be used if the number is singular.
         * @param string $plural      The text to be used if the number is plural.
         * @param string $number      The number to compare against to use either the singular or plural form.
         * @param string $context     Context information for the translators.
         * @param string $domain      Text domain. Unique identifier for retrieving translated strings.
         */
        return apply_filters( 'ngettext_with_context', $translation, $single, $plural, $number, $context, $domain );
    }

    function vendor_n_noop( $singular, $plural, $domain = null ) {
        return array(
            0          => $singular,
            1          => $plural,
            'singular' => $singular,
            'plural'   => $plural,
            'context'  => null,
            'domain'   => $domain,
        );
    }

    function vendor_nx_noop( $singular, $plural, $context, $domain = null ) {
        return array(
            0          => $singular,
            1          => $plural,
            2          => $context,
            'singular' => $singular,
            'plural'   => $plural,
            'context'  => $context,
            'domain'   => $domain,
        );
    }

}
