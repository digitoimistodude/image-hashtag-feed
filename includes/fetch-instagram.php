<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Hashfeed_Fetch_Instagram extends Dude_Img_Hashfeed {

	private static $_instance = null;

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	public function do_fetch() {
		$settings = get_option( 'dude-img-hashfeed' );
		$hashtag = strtolower( $settings['hashtags'] );
		$count = apply_filters( 'dude_img_hashfeed_insta_count', 10 );

		if( empty( $hashtag ) )
			return false;

		$parameters = apply_filters( 'dude_img_hashfeed_insta_fetch_parameters', "ig_hashtag($hashtag) { media.first($count) { count, nodes { caption, code, comments { count }, date, display_src, id, is_video, likes { count }, owner { id, username, full_name, profile_pic_url }, thumbnail_src, video_views, video_url }, page_info } }" );
		$parameters = urlencode( $parameters );
    $url = "https://www.instagram.com/query/?q=$parameters&ref=tags%3A%3Ashow";
    $insta = json_decode( file_get_contents( $url ) );
    $insta = $insta->media->nodes;

		if( empty( $insta ) )
			return false;

		$insta = array_slice( $insta, 0, $count );
		$return = set_transient( 'dude_img_hashfeed_insta', $insta, apply_filters( 'dude_img_hashfeed_insta_transient_lifetime', 5 * MINUTE_IN_SECONDS ) );

		if( $return ) {
			$option = get_option( 'dude-img-hashfeed' );
			$option['last_fetch_insta'] = current_time( 'Y-m-d H:i:s' );
			update_option( 'dude-img-hashfeed', $option );
		}

		return $return;
	} // end function do_fetch
} // end class Dude_Img_Hashfeed_Admin_Settings_Page
