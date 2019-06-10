<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class FirstBookingPageTemplate extends Controller
{
	
	public function __construct() {
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
					$staff_opt .= '<option value="'.$value.'">'.get_post($value)->post_title.'</option>';
				}
			}
			return $staff_opt;
		}
	}






	public function get_list_times() {
		if ( isset($_POST['salon_id']) && isset($_POST['service_id']) && isset($_POST['select_date']) ) {
			$salon_id = $_POST['salon_id'];
			$service_id = $_POST['service_id'];
			$select_date = $_POST['select_date'];


			/*var_dump($salon_id);
			var_dump($service_id);
			var_dump($select_date);*/

			$duration = get_post_meta($service_id, 'duration', true)/60;

			$select_day = strtolower(strftime("%A", strtotime($select_date)));
			$workers_days = get_post_meta($salon_id, 'workers_days', true);
			$workers_days = get_post_meta($salon_id, 'workers_days', true);

			$select_date_workers_time = [];
			foreach ($workers_days as $key => $value) {
				$select_date_workers_time[$key] = $workers_days[$select_day];
			}

			$start_time = substr($workers_days[$select_day]['start'], 0, -3);
			$end_time = substr($workers_days[$select_day]['end'], 0, -3);

			$times = self::get_times( $start_time, $end_time, $duration );
			echo $times;

			wp_die();

		}
	}

	private function get_times( $start_time = '08:00', $end_time = '17:00', $interval = '+30 minutes' ) {
		$output = '';
		$start = strtotime( $start_time );
		$end = strtotime( $end_time );
		while( $start <= $end ) {
			$i++;
			$time = date( 'H:i', $start );
			$output .= '<li data-count="'.$i.'">'.date( 'H:i', $start ).'</li>';
			$start = strtotime( $interval, $start );
		}
		return $output;
	}

}

