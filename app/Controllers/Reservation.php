<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Reservation extends Controller
{
	private static $wpdb;
	public function __construct() {
		global $wpdb;
		self::$wpdb = $wpdb;
	}

	// Метод входа - получения времени
	public static function building_times( $salon_id, $service_id, $staff_id, $select_date ) {
		$table_name = self::order_times_table();
		$work_time_array = self::get_works_time( $salon_id, $service_id, $select_date ); 
		$start = $work_time_array['start'];
		$end = $work_time_array['end'];
		$interval = $work_time_array['interval'];
		$duration = $work_time_array['duration'];
		$workers_days = $work_time_array['workers_days'];
		$select_day = $work_time_array['select_day'];

		if( $workers_days[$select_day]['start'] == 'closed' || $workers_days[$select_day]['end'] == 'closed' ) {
			$returnArray['status'] = 'closed';
		} else {
			$get_times_db = self::$wpdb->get_row( "SELECT * FROM `wp_order_times_table` WHERE `id_staff` = '$staff_id' AND `date_staff` = '$select_date'", ARRAY_A);
			if( !$get_times_db ) {
				$times_array = self::building_times_array( $start, $end, $interval, $duration, $select_date );
			}else {
				$times_array = unserialize($get_times_db['time_staff']);
			}
			$times = self::building_times_list( $times_array );
			$returnArray['duration'] = $duration;
			if( $times_array == false ) {
				$returnArray['status'] = 'passed';
			} else {
				$returnArray['times'] = $times;
			}
		}
		return $returnArray;
	}

	// Метод построения массива времени
	private function building_times_array( $start_time = '08:00', $end_time = '17:00', $interval = '+30 minutes', $duration, $select_date ) {
		date_default_timezone_set('Europe/Kiev');
		$timesArray = [];
		if( strtotime($select_date) < strtotime(date('d.m.Y')) ) {
			return false;
		} else {
			$start = strtotime( $start_time );
			if( $select_date == date('d.m.Y') ) {
				while ( $start <= time() ) {
					$start = strtotime( '+'.$duration.' minutes', $start );
				}
			}
			$end = strtotime( $end_time );
			$end = strtotime( '-'.$duration.' minutes', $end );
			while( $start <= $end ) {
				$timesArray[] = array(
					'time' 	 => date( 'H:i', $start ),
					'status' => true
				);
				$start = strtotime( $interval, $start );
			}
		}
		return $timesArray;
	}

	// Метод построения списка времени
	private function building_times_list( $times_array ) {
		$elem = '';
		foreach ($times_array as $key => $time) {
			if( $time['status'] == false ){ 
				continue;
			}
			$elem .= '<li><a class="times-link" data-count="'.$key.'">'.$time['time'].'</a></li>';
		}
		return $elem;
	}


	public function reservation( $salon_info, $user_info ) {
		$work_time_array = self::get_works_time( $salon_info['salon_id'], $salon_info['service_id'], $salon_info['select_date'] ); 
		$start = $work_time_array['start'];
		$end = $work_time_array['end'];
		$interval = $work_time_array['interval'];
		$duration = $work_time_array['duration'];
		$select_date = $salon_info['select_date'];
		$select_key = $salon_info['select_key'];


		$times_array = self::building_times_array( $start, $end, $interval, $duration, $select_date );
		$new_times_array = self::building_new_times_array( $times_array, $select_key );

		$set_db_array['salon_id'] 		= $salon_info['salon_id'];
		$set_db_array['service_id'] 	= $salon_info['service_id'];
		$set_db_array['staff_id'] 		= $salon_info['staff_id'];
		$set_db_array['select_date'] 	= $salon_info['select_date'];
		$set_db_array['select_key'] 	= $salon_info['select_key'];
		$set_db_array['data_array'] 	= $new_times_array;
		
		$set_times_db = self::set_times_database( $set_db_array );

		$user = array(
			'name' 		=> $user_info['name'],
			'surname' 	=> $user_info['surname'],
			'email'		=> $user_info['email'],
			'phone'		=> $user_info['phone']
		);

		$order = array(
			'id_salon_order' 	=> $salon_info['salon_id'],
			'id_service_order' 	=> $salon_info['service_id'],
			'id_staff_order'	=> $salon_info['staff_id'],
			'date_order'		=> $salon_info['select_date'],
			'time_order'		=> $salon_info['select_time'],
			'duration_order'	=> $duration,
			'user_data'			=> serialize( $user )
		);
		$set_order_db = self::set_orders_database( $order );

		$mail_data = array(
			'salon_name' 	=> get_the_title( $salon_info['salon_id'] ),
			'service_name' 	=> get_the_title( $salon_info['service_id'] ),
			'staff_name' 	=> get_the_title( $salon_info['staff_id'] ),
			'date' 			=> $salon_info['select_date'],
			'time' 			=> $salon_info['select_time'],
			'name' 			=> $user_info['name'],
			'duration' 		=> $duration,
			'surname' 		=> $user_info['surname'],
			'email' 		=> $user_info['email'],
			'phone' 		=> $user_info['phone']
		);
		if( $set_times_db && $set_order_db ) {
			$return_data['html'] = self::send_mail( $mail_data );
		} else {
			$return_data['times_db'] = $set_times_db;
			$return_data['order_db'] = $set_order_db;
			$return_data['order_info'] = $mail_data;
		}
		return $return_data;

	}
	private function building_new_times_array( $times_array, $select_key ) {
		foreach ($times_array as $key => $timeArray) {
			$times_array[$select_key]['status'] = false;
		}
		return $times_array;
	}
	private function set_times_database( $setDatabaseArray ) {
		$table_name = self::order_times_table();
		$salon_id = $setDatabaseArray['salon_id'];
		$staff_id = $setDatabaseArray['staff_id'];
		$select_date = $setDatabaseArray['select_date'];
		$get_times_db = self::$wpdb->get_row( "SELECT * FROM `wp_order_times_table` WHERE `id_salon` = '$salon_id' AND `id_staff` = '$staff_id' AND `date_staff` = '$select_date'", ARRAY_A);
		if( $get_times_db ) {
			$timesArray = unserialize( $get_times_db['time_staff'] );
			$setDatabaseArray['data_array'] = self::building_new_times_array( $timesArray, $setDatabaseArray['select_key'] );
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
	private function set_orders_database( $orderArray ) {
		$table_name = self::order_table();
		if( $orderArray ) {
			$status = self::$wpdb->insert( $table_name, $orderArray );
			return $status;
		}
	}

	private function get_works_time( $salon_id, $service_id, $select_date ) {
		$duration = get_post_meta($service_id, 'duration', true)/60;
		$workers_days = get_post_meta($salon_id, 'workers_days', true);
		$select_day = strtolower(strftime("%A", strtotime($select_date)));
		$returnArray['start'] = substr($workers_days[$select_day]['start'], 0, -3);
		$returnArray['end'] = substr($workers_days[$select_day]['end'], 0, -3);
		$returnArray['interval'] = '+'.$duration.' minutes';
		$returnArray['duration'] = $duration;
		$returnArray['workers_days'] = $workers_days;
		$returnArray['select_day'] = $select_day;
		return $returnArray;
	}


	public static function order_times_table() {
		$wpdb = self::$wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table_name = $wpdb->get_blog_prefix() . 'order_times_table';
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
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

	public static function order_table() {
		$wpdb = self::$wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table_name = $wpdb->get_blog_prefix() . 'order_table';
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
		$sql = "CREATE TABLE {$table_name} (
		id  bigint(20) unsigned NOT NULL auto_increment,
		id_salon_order varchar(255) NOT NULL default '',
		id_service_order varchar(255) NOT NULL default '',
		id_staff_order varchar(255) NOT NULL default '',
		date_order varchar(255) NOT NULL default '',
		time_order text NOT NULL default '',
		duration_order text NOT NULL default '',
		user_data text NOT NULL default '',
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