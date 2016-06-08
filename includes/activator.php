<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Hashfeed_Activator extends Dude_Img_Hashfeed {

	private static $_instance = null;

	public function __construct() {
		add_filter( 'cron_schedules', array( $this, 'add_schedule' ) );

		$this->activate();
	} // end function __construct

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	public function add_schedule( $schedules ) {
		$schedules['five-minute'] = array(
			'interval'	=> 300,
			'display'		=> __( 'Once every 5 mins', 'dude-img-hashfeed' )
		);

		return $schedules;
	} // end function add_schedule

	private function activate() {
		if( !wp_next_scheduled ( 'dude_img_hashfeed_fetch' ) ) {
			wp_schedule_event( time(), apply_filters( 'dude_img_hashfeed_fetch_recurrence', 'five-minute' ), 'dude_img_hashfeed_fetch' );
    }
	} // end function activate
} // end class Dude_Img_Hashfeed_Activator
