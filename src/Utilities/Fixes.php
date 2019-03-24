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


class Fixes
{
    /**
     * Diacritic fix for uploaded filenames
     */
    static function slugifyFilenames()
    {
        $function = function ($file) {
            $name = $file['name'];
            $name = iconv('UTF-8', 'UTF-8//IGNORE', $name);
            $name = urldecode($name);
            $name = str_replace('–', "", $name); // it's not standard dash
            $name = str_replace('—', "", $name); // it's not standard dash
            $name = str_replace("+", "-", $name);
            $name = strtr($name, "\xCC\x8C", "  ");
            while (stristr($name, '  ')) {
                $name = str_ireplace('  ', '', $name);
            }
            while (stristr($name, '--')) {
                $name = str_ireplace('--', '-', $name);
            }
            $name = remove_accents($name);
            $name = mb_strtolower($name);
            $file['name'] = $name;
            $file['title'] = isset($file['title']) ? $file['title'] : $name;
            $file['post_title'] = isset($file['title']) ? $file['title'] : $name;

            return $file;
        };

        add_filter('wp_handle_sideload_prefilter', $function, 99);
        add_filter('wp_handle_upload_prefilter', $function, 99);
    }

    /**
     * Doubledashes title attachment fix
     */
    static function attachmentDoubleDashes()
    {
        $function = function ($data) {
            $title = str_replace(" - ", "%dashtemp%", $data['post_title']);
            $title = str_replace("-", " ", $title);
            $title = str_replace("%dashtemp%", " - ", $title);
            $data['post_title'] = ucfirst($title);

            return $data;
        };

        add_filter('wp_insert_attachment_data', $function, 99);
    }

    /**
     * Set title for files that haven't any
     */
    static function defaultFilenameFromTitle()
    {
        $function = function ($data, $file) {
            if (!$data['title']) {
                $data['title'] = basename($file);
            }

            return $data;
        };

        add_filter('wp_read_image_metadata', $function, 99, 2);
    }

    /**
     * Remove Smiles from title, because "D" characters remains in slug after
     */
    static function removeEmojiFromTitles()
    {
        /**
         * @param $title
         * @param $raw_title
         * @param $context
         * @return mixed|string
         */
        $function = function ($title, $raw_title, $context) {
            if ('save' == $context) {
                $title = str_replace(':D', '', $raw_title);
                $title = str_replace(':-D', '', $title);

                // Remove emoji
                $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
                $title = preg_replace($regexEmoticons, '', $title);

                // Match Miscellaneous Symbols and Pictographs
                $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
                $title = preg_replace($regexSymbols, '', $title);

                // Match Transport And Map Symbols
                $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
                $title = preg_replace($regexTransport, '', $title);

                // Match Miscellaneous Symbols
                $regexMisc = '/[\x{2600}-\x{26FF}]/u';
                $title = preg_replace($regexMisc, '', $title);

                // Match Dingbats
                $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
                $title = preg_replace($regexDingbats, '', $title);


                $title = remove_accents($title);
            }

            return $title;
        };

        add_action('sanitize_title', $function, -999, 3);
    }

    /**
     * Substitute blank and new line tags to text represents
     */
    static function trimContentBeforeAfter()
    {
        /**
         * @param $data
         * @return mixed
         */
        $function = function ($data) {
            $content = preg_replace("/(&nbsp;)+/", " ", $data['post_content']);
            $content = preg_replace("/( )+/", " ", $content);
            $content = str_ireplace('<br>', "\n", $content);
            $content = str_ireplace('<br/>', "\n", $content);
            $content = str_ireplace('<br />', "\n", $content);
            $data['post_content'] = trim($content);

            return $data;
        };

        add_filter('wp_insert_post_data', $function, 9999);
    }

    /**
     * Add new mime types to upload
     */
    static function allowNewMimetypes()
    {
        /**
         * @param array $existing_mimes
         * @return array
         */
        $function = function ($existing_mimes = array()) {
            $existing_mimes['mp4'] = 'video/mp4';
            $existing_mimes['m4v'] = 'video/x-m4v';
            $existing_mimes['webm'] = 'video/webm ';
            $existing_mimes['svg'] = 'image/svg+xml';
            $existing_mimes['ico'] = 'image/x-icon';
            $existing_mimes['swf'] = 'application/x-shockwave-flash';
            $existing_mimes['pdf'] = 'application/pdf';
            $existing_mimes['eps'] = 'application/postscript';
            $existing_mimes['webp'] = 'image/webp';

            $existing_mimes['xml'] = 'application/xml';
            $existing_mimes['sql'] = 'application/octet-stream';
            $existing_mimes['tif'] = 'image/tiff';
            $existing_mimes['tiff'] = 'image/tiff';

            $existing_mimes['doc'] = 'application/msword';
            $existing_mimes['dot'] = 'application/msword';
            $existing_mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            $existing_mimes['xls'] = 'application/vnd.ms-excel';
            $existing_mimes['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            $existing_mimes['ppt'] = 'application/vnd.ms-powerpoint';
            $existing_mimes['pot'] = 'application/vnd.ms-powerpoint';
            $existing_mimes['pptx'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';

            return $existing_mimes;
        };

        add_filter('upload_mimes', $function);
    }


    /**
     * Fix for imagesize mime types
     */
    static function imagesizeMimeFixes()
    {
        /**
         * @param array $existing_mimes
         * @return array
         */
        $function = function ($existing_mimes = array()) {
            $existing_mimes['application/octet-stream'] = 'svg';

            return $existing_mimes;
        };

        add_filter('getimagesize_mimes_to_exts', $function);
    }
}
