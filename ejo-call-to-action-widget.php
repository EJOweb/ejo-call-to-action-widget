<?php
/**
 * Plugin Name: EJO Call To Action Widget
 * Description: A widget to a call to action
 * Version: 0.2
 * Author: EJOweb
 * Author URI: http://www.ejoweb.nl/
 * 
 * GitHub Plugin URI: https://github.com/EJOweb/ejo-call-to-action-widget
 * GitHub Branch:     master
 */

/**
 *
 */
final class EJO_Call_To_Action_Widget_Plugin
{
	//* Slug of this plugin
    const SLUG = 'ejo-call-to-action-widget';

    //* Version number of this plugin
    const VERSION = '0.2';

    //* Stores the directory path for this plugin.
    public static $dir;

    //* Stores the directory URI for this plugin.
    public static $uri;

    //* Holds the instance of this class.
    protected static $_instance = null;

    //* Only instantiate once
    public static function init() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No clones please!
    protected function __clone() {}

    //* Plugin setup.
    protected function __construct() 
    {
		//* Setup
        add_action( 'plugins_loaded', array( $this, 'setup' ), 1 );

        // Include required files
        include_once( self::$dir . 'includes/class-widget.php' );

        //* Register widget
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
    }

    //* Defines the directory path and URI for the plugin.
    public function setup() 
    {
    	//* Set plugin dir and uri
        self::$dir = plugin_dir_path( __FILE__ ); // with trailing slash
        self::$uri = plugin_dir_url( __FILE__ ); // with trailing slash

        //* Load the translation for the plugin
        load_plugin_textdomain( self::SLUG, false, self::SLUG.'/languages' );
    }

    //* Register widgets
    public function widgets_init() 
    {
		register_widget( 'EJO_Call_To_Action_Widget' );
	}
}

/* Call the wrapper class */
EJO_Call_To_Action_Widget_Plugin::init();
