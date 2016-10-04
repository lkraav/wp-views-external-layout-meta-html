<?php
/*
Plugin Name: Toolset Views External Layout Meta HTML
Plugin URI: https://conversionready.com
Description: Filter view layout HTML definition with an external source
Version: 2016.09.30
Author: Leho Kraav
Author URI: https://conversionready.com
*/

if ( is_admin() ) {
    return;
}

final class WPV_External_Layout_Meta_HTML {

    private static $layout_meta_html_by_theme_directory = 'wp-views';

    public static function plugins_loaded() {

        if ( ! defined( 'WPV_VERSION' ) ) {
            return;
        }

        # plugins/wp-views/embedded/inc/wpv.class.php WP_Views::get_view_layout_settings()
        add_filter( 'wpv_filter_override_view_layout_settings', [ __CLASS__, 'layout_meta_html_by_theme' ], 10, 2 );

    }

    # implements known theme location backend
    public static function layout_meta_html_by_theme( $view_layout_settings, $view_id ) {

        $view_post_name = get_post_field( 'post_name', $view_id );

        $layout_meta_html_file = sprintf( '%s/%s/%s.html',
            get_stylesheet_directory(),
            static::$layout_meta_html_by_theme_directory,
            $view_post_name
        );

        $layout_meta_html_file = apply_filters( 'wpv_external_layout_meta_html_file',
            $layout_meta_html_file,
            $view_layout_settings,
            $view_id
        );

        if ( $layout_meta_html = @file_get_contents( $layout_meta_html_file ) ) {

            $layout_meta_html_debug = sprintf( "<!-- %s::%s -> %s -->\n",
                __CLASS__,
                __FUNCTION__,
                str_replace( ABSPATH, '', $layout_meta_html_file )
            );

            $layout_meta_html = $layout_meta_html_debug . $layout_meta_html;

            $layout_meta_html = implode( "\n", array_map( 'trim', explode( "\n", $layout_meta_html ) ) );

            $view_layout_settings['layout_meta_html'] = $layout_meta_html;

        }

        return $view_layout_settings;

    }

}

add_action( 'plugins_loaded', [ 'WPV_External_Layout_Meta_HTML', 'plugins_loaded' ] );
