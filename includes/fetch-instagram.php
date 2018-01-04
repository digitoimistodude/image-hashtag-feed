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

	public static function do_fetch() {
		$settings = get_option( 'dude-img-hashfeed' );
		$hashtag = strtolower( $settings['hashtags'] );
		$count = apply_filters( 'dude_img_hashfeed_insta_count', 10 );

		if( empty( $hashtag ) )
			return false;

		$url = "https://www.instagram.com/explore/tags/{$hashtag}/?__a=1";
   	$output = json_decode( file_get_contents( $url ) );
    $insta = $output->graphql->hashtag->edge_hashtag_to_media->edges;

		if( empty( $insta ) )
			return false;

		$real_insta = array();
		$insta = array_slice( $insta, 0, $count );

		/**
		 *  Instagram changed the structure of return,
		 *  we adapt to that and make things backwars compatible.
		 */
		foreach ( $insta as $insta_post_key => $insta_post ) {
			$real_insta[ $insta_post_key ] = $insta_post->node;
			$real_insta[ $insta_post_key ]->caption = $insta_post->node->edge_media_to_caption->edges{0}->node->text;
			$real_insta[ $insta_post_key ]->likes = $insta_post->node->edge_liked_by;
			$real_insta[ $insta_post_key ]->code = $insta_post->node->shortcode;
		}

		$insta = $real_insta;

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
