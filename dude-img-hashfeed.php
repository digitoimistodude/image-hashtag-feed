<?php
/**
 *
 * Plugin Name:       Image hashtag feed
 * Plugin URI:        https://github.com/digitoimistodude/image-hashtag-feed
 * Description:       Get Instagram hashtag feeds working again by bypassing the API.
 * Version:           1.0.0
 * Author:            Digitoimisto Dude
 * Author URI:        http://dude.fi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dude-img-hashfeed
 * Domain Path:       /languages
 */

if( !defined( 'ABSPATH' )  )
	exit();


Class Dude_Img_Hashfeed {

  private static $_instance = null;
  protected $plugin_path;

  public function __construct() {
    $this->plugin_path = plugin_dir_path( __FILE__ );

    add_action( 'init', array( $this, 'load_depencies' ) );
    add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'init', array( 'Dude_Img_Hashfeed_Admin_Settings_Page', 'instance' ) );
		add_action( 'init', array( 'Dude_Img_Hashfeed_Fetch_Instagram', 'instance' ) );
  } // end function __construct

  public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude-img-hashfeed' ) );
	} // end function __clone

  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude-img-hashfeed' ) );
  } // end function __wakeup

  public static function instance() {
    if( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  } // end function instance

  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'dude-img-hashfeed', false, $this->plugin_path.'/languages/' );
  } // end function load_plugin_textdomain

  public function load_depencies() {
    require_once( $this->plugin_path.'/libraries/simple-admin-pages/simple-admin-pages.php' );
		require_once( $this->plugin_path.'/includes/admin/settings-page.php' );
		require_once( $this->plugin_path.'/includes/fetch-instagram.php' );
		require_once( $this->plugin_path.'/includes/get-from-cache.php' );
  } // end function load_depencies
} // end class Dude_Img_Hashfeed

$plugin = new Dude_Img_Hashfeed();

if( !function_exists( 'get_the_dude_img_hashfeed_raw' ) ) {
	function get_the_dude_img_hashfeed_raw() {
		return Dude_Img_Hashfeed_Get_From_Cache::get_raw();
	} // end function dude_img_hashfeed_get_raw
}

if( !function_exists( 'get_the_dude_img_hashfeed_thumbnails' ) ) {
	function get_the_dude_img_hashfeed_thumbnails() {
		return Dude_Img_Hashfeed_Get_From_Cache::get_thumbnails();
	} // end function dude_img_hashfeed_thumbnails
}

if( !function_exists( 'the_dude_img_hashfeed_thumbnails' ) ) {
	function the_dude_img_hashfeed_thumbnails() {
		echo Dude_Img_Hashfeed_Get_From_Cache::get_thumbnails();
	} // end function dude_img_hashfeed_thumbnails
}
