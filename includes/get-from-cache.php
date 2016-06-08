<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Hashfeed_Get_From_Cache extends Dude_Img_Hashfeed {

	private static $_instance = null;

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	public function get_raw() {
		$count = apply_filters( 'dude_img_hashfeed_insta_count', 10 );
		$insta_cache = get_transient( 'dude_img_hashfeed_insta' );

	  if( !$insta_cache ) {
	    Dude_Img_Hashfeed_Fetch_Instagram::do_fetch();
			$insta_cache = get_transient( 'dude_img_hashfeed_insta' );
	  }

		$insta_cache = array_slice( $insta_cache, 0, $count );
		return $insta_cache;
	} // end function get_raw

	public function get_thumbnails() {
		$images = self::get_raw();

		ob_start();

		foreach( $images as $image ) {
			echo "<img src='$image->thumbnail_src' alt='$image->caption' />";
    }

		return ob_get_clean();
	} // end function get_thumbnails
} // end class Dude_Img_Hashfeed_Get_From_Cache
