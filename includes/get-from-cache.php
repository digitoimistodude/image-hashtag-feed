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

	public static function get_raw( $hashtag = null ) {
    if ( empty( $hashtag ) ) {
      $settings = get_option( 'dude-img-hashfeed' );
      $hashtag = strtolower( $settings['hashtags'] );
    }

    $count = apply_filters( 'dude_img_hashfeed_insta_count', 10 );
    $count = apply_filters( "dude_img_hashfeed_insta_count_{$hashtag}", $count );

		$insta_cache = get_transient( "dude_hashfeed_insta_{$hashtag}|{$count}" );

	  if ( ! $insta_cache ) {
	    $insta = Dude_Img_Hashfeed_Fetch_Instagram::do_fetch( $hashtag );
	  }

		return $insta;
	} // end function get_raw

	public static function get_thumbnails( $hashtag = null ) {
		$images = self::get_raw( $hashtag );

		ob_start();

		foreach( $images as $image ) {
			echo "<img src='$image->thumbnail_src' alt='$image->caption' />";
    }

		return ob_get_clean();
	} // end function get_thumbnails
} // end class Dude_Img_Hashfeed_Get_From_Cache
