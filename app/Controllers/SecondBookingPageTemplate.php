<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class SecondBookingPageTemplate extends Controller
{	
	private static $wpdb;
	public function __construct() {
		global $wpdb;
		self::$wpdb = $wpdb;
		add_action('wp_ajax_get_array_times', array($this, 'get_array_times'));
		add_action( 'wp_ajax_nopriv_get_array_times', array($this, 'get_array_times'));
	}

	public function get_array_times() {
		if( isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['interval']) && isset($_POST['duration']) && isset($_POST['select_key']) && isset($_POST['time']) ) {
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$interval = $_POST['interval'];
			$duration = $_POST['duration'];
			$select_key = $_POST['select_key'];
			$select_time = $_POST['time'];


			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];


			$time = new FirstBookingPageTemplate;
			$timesArray = $time->time_array( $start_time, $end_time, $interval, $duration );
			$newTimesArray = self::new_time_array( $timesArray, $select_key );

			$setDatabaseArray['salon_id'] = $_POST['salon_id'];
			$setDatabaseArray['service_id'] = $_POST['service_id'];
			$setDatabaseArray['staff_id'] = $_POST['staff_id'];
			$setDatabaseArray['select_date'] = $_POST['select_date'];
			$setDatabaseArray['select_key'] = $_POST['select_key'];
			$setDatabaseArray['data_array'] = $newTimesArray;

			$mail_data = array(
				'salon_name' 	=> get_the_title( $setDatabaseArray['salon_id'] ),
				'service_name' 	=> get_the_title( $setDatabaseArray['service_id'] ),
				'staff_name' 	=> get_the_title( $setDatabaseArray['staff_id'] ),
				'date' 			=> $setDatabaseArray['select_date'],
				'time' 			=> $select_time,
				'name' 			=> $name,
				'surname' 		=> $surname,
				'email' 		=> $email,
				'phone' 		=> $phone
			);
			$setTimesDB = self::set_times_database( $setDatabaseArray );
			if( $setTimesDB ) {
				$html = self::send_mail( $mail_data );
				var_dump($html);
			} else {
				var_dump($setTimesDB);
			}
			wp_die();
		}
	}

	private function new_time_array( $timesArray, $select_key ) {
		foreach ($timesArray as $key => $timeArray) {
			$timesArray[$select_key]['status'] = false;
		}
		return $timesArray;
	}

	private function set_times_database( $setDatabaseArray ) {
		$table_name = self::order_times_table();

		$salon_id = $setDatabaseArray['salon_id'];
		$staff_id = $setDatabaseArray['staff_id'];
		$select_date = $setDatabaseArray['select_date'];

		$get_times_db = self::$wpdb->get_row( "SELECT * FROM `wp_order_times_table` WHERE `id_salon` = '$salon_id' AND `id_staff` = '$staff_id' AND `date_staff` = '$select_date'", ARRAY_A);
		if( $get_times_db ) {
			$timesArray = unserialize( $get_times_db['time_staff'] );
			$setDatabaseArray['data_array'] = self::new_time_array( $timesArray, $setDatabaseArray['select_key'] );
			$serializeTime = serialize($setDatabaseArray['data_array']);
			$update_where = array(
				'id_salon' 		=> $setDatabaseArray['salon_id'],
				'id_service' 	=> $setDatabaseArray['service_id'],
				'id_staff' 		=> $setDatabaseArray['staff_id'],
				'date_staff' 	=> $setDatabaseArray['select_date'],
			);
			$status = self::$wpdb->update( $table_name, array( 'time_staff' => $serializeTime ), $update_where );
		} else {
			$serializeTime = serialize($setDatabaseArray['data_array']);
			$insert_array = array(
				'id_salon' 		=> $setDatabaseArray['salon_id'],
				'id_service' 	=> $setDatabaseArray['service_id'],
				'id_staff' 		=> $setDatabaseArray['staff_id'],
				'date_staff' 	=> $setDatabaseArray['select_date'],
				'time_staff' 	=> $serializeTime
			);
			$status = self::$wpdb->insert( $table_name, $insert_array );
		}
		return $status;
	}

	private function order_times_table() {
		self::$wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table_name = self::$wpdb->get_blog_prefix() . 'order_times_table';
		$charset_collate = "DEFAULT CHARACTER SET {self::$wpdb->charset} COLLATE {self::$wpdb->collate}";
		$sql = "CREATE TABLE {$table_name} (
		id  bigint(20) unsigned NOT NULL auto_increment,
		id_salon varchar(255) NOT NULL default '',
		id_service varchar(255) NOT NULL default '',
		id_staff varchar(255) NOT NULL default '',
		date_staff varchar(255) NOT NULL default '',
		time_staff text NOT NULL default '',
		PRIMARY KEY  (id)
		)
		{$charset_collate};";
		dbDelta($sql);
		return $table_name;
	}

	private function send_mail( $mail_data ) {
		$html = \App\template('emails/booking', compact('mail_data'));
		add_filter( 'wp_mail_content_type', function($content_type){
			return "text/html";
		});
		$status = wp_mail( $mail_data['email'], 'Test message', $html );
		return $status;
	}

}