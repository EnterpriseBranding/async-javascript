<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* 
 * Frontend logic: add script attribute & change Autoptimize JS attrib if applicable
 */
  
class AsyncJavaScriptFrontend {
    function __construct() {
        add_filter( 'script_loader_tag', array( $this, 'aj_async_js' ), 20, 3 );
        add_filter( 'autoptimize_filter_js_defer', array( $this, 'aj_autoptimize_defer' ), 11 );
    }

    /**
     * the plugin instance
     */
    private static $instance = NULL;

    /**
     * get the plugin instance
     *
     * @return AsyncJavaScript
     */
    public static function get_instance() {
        if ( NULL === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *  aj_async_js()
     *
     *  Main frontend function; adds 'async' or 'defer' attribute to '<script>' tasks called 
     *  via wp_enqueue_script using the 'script_loader_tag' filter
     * 
     */
    public function aj_async_js( $tag, $handle, $src ) {
    	if ( isset( $_GET['aj_simulate'] ) ) {
            $aj_enabled = true;
            $aj_method = sanitize_text_field( $_GET['aj_simulate'] );
            if ( isset( $_GET['aj_simulate_jquery'] ) ) {
                    $aj_jquery = sanitize_text_field( $_GET['aj_simulate_jquery'] );
            } else {
                    $aj_jquery = $aj_method;
            }
            $array_exclusions = array();
            $array_async = array();
            $array_defer = array();
            $aj_plugin_exclusions = array();
            $aj_theme_exclusions = array();
        } else {
            $aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? true : false;
            $aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'async' : 'defer';
            $aj_jquery = get_option( 'aj_jquery', 'async' );
            $aj_jquery = ( $aj_jquery == 'same ' ) ? $aj_method : $aj_jquery;
            $aj_exclusions = get_option( 'aj_exclusions', '' );
            $array_exclusions = ( $aj_exclusions != '' ) ? explode( ',', $aj_exclusions ) : array();
            $aj_async = get_option( 'aj_async', '' );
            $array_async = ( $aj_async != '' ) ? explode( ',', $aj_async ) : array();
            $aj_defer = get_option( 'aj_defer', '' );
            $array_defer = ( $aj_defer != '' ) ? explode( ',', $aj_defer ) : array();
            $aj_plugin_exclusions = get_option( 'aj_plugin_exclusions', array() );
            $aj_theme_exclusions = get_option( 'aj_theme_exclusions', array() );
        }
        if ( false !== $aj_enabled && false === is_admin() ) {
            if ( is_array( $aj_plugin_exclusions ) && !empty( $aj_plugin_exclusions ) ) {
                foreach ( $aj_plugin_exclusions as $aj_plugin_exclusion ) {
                	$aj_plugin_exclusion = trim( $aj_plugin_exclusion );
                	if ( !empty( $aj_plugin_exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $aj_plugin_exclusion ) ) ) {
	                        return $tag;
	                    }
                    }
                }
            }
            if ( is_array( $aj_theme_exclusions ) && !empty( $aj_theme_exclusions ) ) {
                foreach ( $aj_theme_exclusions as $aj_theme_exclusion ) {
                	$aj_theme_exclusion = trim( $aj_theme_exclusion );
                	if ( !empty( $aj_theme_exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $aj_theme_exclusion ) ) ) {
	                        return $tag;
	                    }
					}
                }
            }
            if ( is_array( $array_exclusions ) && !empty( $array_exclusions ) ) {
                foreach ( $array_exclusions as $exclusion ) {
                	$exclusion = trim( $exclusion );
                	if ( !empty( $exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $exclusion ) ) ) {
	                        return $tag;
	                    }
					}
                }
            }
            if ( false !== strpos( strtolower( $src ), 'js/jquery/jquery.js' ) ) {
                if ( $aj_jquery == 'async' || $aj_jquery == 'defer' ) {
                        $tag = str_replace( 'src=', $aj_jquery . "='" . $aj_jquery . "' src=", $tag );
                return $tag;
                } else if ( $aj_jquery == 'exclude' ) {
                        return $tag;
                }
            }
            if ( is_array( $array_async ) && !empty( $array_async ) ) {
                foreach ( $array_async as $async ) {
                	$async = trim( $async );
					if ( !empty( $async ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $async ) ) ) {
	                    	return str_replace( 'src=', "async='async' src=", $tag );
	                    }
					}
                }
            }
            if ( is_array( $array_defer ) && !empty( $array_defer ) ) {
                foreach ( $array_defer as $defer ) {
                	$defer = trim( $defer );
                	if ( !empty( $defer ) ) {
                    	if ( false !== strpos( strtolower( $src ), strtolower( $defer ) ) ) {
							return str_replace( 'src=', "defer='defer' src=", $tag );
	                    }
					}
                }
            }
			$tag = str_replace( 'src=', $aj_method . "='" . $aj_method . "' src=", $tag );
            return $tag;
        }
        return $tag;
    }
    
    /**
     *  aj_autoptimize_defer()
     *
     *  Adds support for Autoptimize plugin.  Adds 'async' attribute to '<script>' tasks called via autoptimize_filter_js_defer filter
     *  Autoptimize: https://wordpress.org/plugins/autoptimize/
     *
     */
    public function aj_autoptimize_defer( $defer ) {
        $aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? true : false;
	    $aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'async' : 'defer';
	    $aj_autoptimize_enabled = ( get_option( 'aj_autoptimize_enabled', 0 ) == 1 ) ? true : false;
		$aj_autoptimize_method = ( get_option( 'aj_autoptimize_method', 'async' ) == 'async' ) ? 'async' : 'defer';
	    if ( false !== $aj_enabled && false === is_admin() ) {
	        if ( false !== $aj_autoptimize_enabled ) {
	            return " " . $aj_autoptimize_method . "='" . $aj_autoptimize_method . "' ";
	        }
	    }
        return '';
    }
}
