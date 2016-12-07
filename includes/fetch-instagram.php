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
    if( !function_exists( 'curl_init' ) ) {
      return false;
    }

    $random = self::generate_random_string();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/query/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'q='.$parameters);
    $headers = array();
    $headers[] = "Cookie:  csrftoken=$random;";
    $headers[] = "X-Csrftoken: $random";
    $headers[] = "Referer: https://www.instagram.com/";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $output = curl_exec($ch);
    curl_close($ch);

    $output = json_decode( $output );
    $insta = $output->media->nodes;

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

  protected static function generate_random_string( $length = 10 ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for( $i = 0; $i < $length; $i++ ) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
 } // end function generate_random_string
} // end class Dude_Img_Hashfeed_Admin_Settings_Page
