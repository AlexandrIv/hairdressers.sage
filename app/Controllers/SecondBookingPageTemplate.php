<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use Reservation;

class SecondBookingPageTemplate extends Controller
{	
	private static $wpdb;
	public function __construct() {
		global $wpdb;
		self::$wpdb = $wpdb;
		add_action('wp_ajax_booking_reservation', array($this, 'booking_reservation'));
		add_action( 'wp_ajax_nopriv_booking_reservation', array($this, 'booking_reservation'));
	}

	public function booking_reservation() {
		if( isset($_POST['salon_id']) && isset($_POST['service_id']) && isset($_POST['staff_id']) && isset($_POST['select_date']) && isset($_POST['select_key']) && isset($_POST['select_time']) ) {


			$salon_info['salon_id'] = $_POST['salon_id'];
			$salon_info['service_id'] = $_POST['service_id'];
			$salon_info['staff_id'] = $_POST['staff_id'];
			$salon_info['select_date'] = $_POST['select_date'];
			$salon_info['select_key'] = $_POST['select_key'];
			$salon_info['select_time'] = $_POST['select_time'];

			$user_info['name'] = $_POST['name'];
			$user_info['surname'] = $_POST['surname'];
			$user_info['email'] = $_POST['email'];
			$user_info['phone'] = $_POST['phone'];

			$reservation = new Reservation;
			$reservation_data = $reservation->reservation( $salon_info, $user_info );
		
			wp_die();
		}
	}
}