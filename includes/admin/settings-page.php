<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Hashfeed_Admin_Settings_Page extends Dude_Img_Hashfeed {

	private static $_instance = null;

	public function __construct() {
		$this->setup_settings_page();
	} // end function __construct

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	private function setup_settings_page() {
		$sap = sap_initialize_library(
      array(
        'version'	=> '2.0',
        'lib_url'	=> plugin_dir_path( dirname( __FILE__ ) ).'/lib/simple-admin-pages/',
      )
    );

    $sap->add_page(
      'options',
      array(
        'id'            => 'dude-img-hashfeed',
        'title'         => __( 'Image hashtag feed', 'dude-img-hashfeed' ),
        'menu_title'    => __( 'Image hashtag feed', 'dude-img-hashfeed' ),
        'capability'    => 'manage_options'
      )
    );

    $sap->add_section(
      'dude-img-hashfeed',
      array(
        'id'            => 'dude-img-hashfeed-settings',
        'description'   => __( 'Images are stored to transient in favor of caching and reducing page load time. Cache time is five minutes<br />and after that new images are fetched from Instagram when images are needed again.', 'dude-img-hashfeed' ).'<br /><br />'.__( 'For now, this plugin supports only one hashtag.' )
    	)
    );

    $sap->add_setting(
      'dude-img-hashfeed',
      'dude-img-hashfeed-settings',
      'text',
      array(
        'id'            => 'hashtags',
        'title'         => __( 'Hashtag', 'dude-img-hashfeed' ),
        'description'   => __( 'Type hashtag without hash at the beginning. You can also set this dynamically from the functions.', 'dude-img-hashfeed' ),
      )
    );

		$sap->add_setting(
      'dude-img-hashfeed',
      'dude-img-hashfeed-settings',
      'text',
      array(
        'id'            => 'last_fetch_insta',
        'title'         => __( 'Last fetch was made', 'dude-img-hashfeed' ),
      )
    );

    $sap = apply_filters( 'dude_img_hashfeed_setup_settings_page', $sap );

    $sap->add_admin_menus();
	} // end function setup_settings_page()
} // end class Dude_Img_Hashfeed_Admin_Settings_Page
