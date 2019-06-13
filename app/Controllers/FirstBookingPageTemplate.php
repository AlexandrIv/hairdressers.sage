<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class FirstBookingPageTemplate extends Controller
{
	private static $wpdb;
	public function __construct() {
		global $wpdb;
		self::$wpdb = $wpdb;
		add_action('wp_ajax_get_list_times', array($this, 'get_list_times'));
		add_action( 'wp_ajax_nopriv_get_list_times', array($this, 'get_list_times'));

		add_action('wp_ajax_get_staff_options_ajax', array($this, 'get_staff_options_ajax'));
		add_action( 'wp_ajax_nopriv_get_staff_options_ajax', array($this, 'get_staff_options_ajax'));
	}

	public function get_option_service() {
		if( isset($_GET['aut']) ) {
			$author = $_GET['aut'];
			$query = new WP_Query;
			$services = $query->query( array(
				'post_type' 		=> 'services',
				'author' 			=> $author,
				'posts_per_page' 	=> -1
			) );
			foreach( $services as $service ){
				$opt .= '<option value="'.$service->ID.'">'.$service->post_title.'</option>';
			}
			return $opt;
		}
	}

	public function get_service() {
		if( isset($_GET['sce']) || isset($_GET['stf']) || isset($_GET['aut']) ) {
			$returnService['name'] = get_post($_GET['sce'])->post_title;
			$returnService['ID'] = $_GET['sce'];
			return $returnService;
		}
	}

	public function get_staff_options_ajax() {
		if( isset($_POST['select_service_id']) ) {
			$staffs_id = get_post_meta($_POST['select_service_id'], 'staffs_id');
			foreach ($staffs_id as $key => $value) {
				if ($value) {
					$staff_opt .= '<option value="'.$value.'">'.get_post($value)->post_title.'</option>';
				}
			}
			echo $staff_opt;
			wp_die();
		}
	}

	public function get_option_staff() {
		if( isset($_GET['sce']) ) {
			$staffs_id = get_post_meta($_GET['sce'], 'staffs_id');
			foreach ($staffs_id as $key => $value) {
				if ($value) {
					$staff_option .= '<option value="'.$value.'">'.get_post($value)->post_title.'</option>';
				} else {
					
				}
			}
			return $staff_option;
		}
	}

	public function get_list_times() {
		if ( isset($_POST['salon_id']) && isset($_POST['service_id']) && isset($_POST['select_date']) && isset($_POST['staff_id']) ) {
			$salon_id = $_POST['salon_id'];
			$service_id = $_POST['service_id'];
			$staff_id = $_POST['staff_id'];
			$select_date = $_POST['select_date'];
			
			$duration = get_post_meta($service_id, 'duration', true)/60;
			$interval = '+'.$duration.' minutes';

			$select_day = strtolower(strftime("%A", strtotime($select_date)));
			$workers_days = get_post_meta($salon_id, 'workers_days', true);
			
			$start_time = substr($workers_days[$select_day]['start'], 0, -3);
			$end_time = substr($workers_days[$select_day]['end'], 0, -3);

			if( $workers_days[$select_day]['start'] == 'closed' || $workers_days[$select_day]['end'] == 'closed' ) {
				$returnArray['status'] = 'closed';
			} else {
				$get_times_db = self::$wpdb->get_row( "SELECT * FROM `wp_order_times_table` WHERE `id_staff` = '$staff_id' AND `date_staff` = '$select_date'", ARRAY_A);
				if( !$get_times_db ) {
					$timesArray = self::time_array( $start_time, $end_time, $interval, $duration, $select_date );
					$times = self::building_list( $timesArray );
				}else {
					$get_times_array = unserialize($get_times_db['time_staff']);
					$times = self::building_list( $get_times_array );
				}
				if( $timesArray == false ) {
					$returnArray['status'] = 'passed';
				}else {
					$returnArray['times'] = $times;
				}
				$returnArray['start_time'] = $start_time;
				$returnArray['end_time'] = $end_time;
				$returnArray['interval'] = $interval;
				$returnArray['duration'] = $duration;
			}
			echo json_encode($returnArray);
			wp_die();
		}
	}
	public static function time_array( $start_time = '08:00', $end_time = '17:00', $interval = '+30 minutes', $duration, $select_date ) {
		date_default_timezone_set('Europe/Kiev');
		$timesArray = [];
		if( strtotime($select_date) < strtotime(date('d.m.Y')) ) {
			return false;
		}else {
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

	public static function building_list( $timesArray ) {
		$elem = '';
		foreach ($timesArray as $key => $time) {
			if( $time['status'] == false ){ 
				continue;
			}
			$elem .= '<li><a class="times-link" data-count="'.$key.'">'.$time['time'].'</a></li>';
		}
		return $elem;
	}

}

