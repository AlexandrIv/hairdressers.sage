<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use Reservation;

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
				'posts_per_page' 	=> -1,
				'order'				=> 'ASC'
			) );
			foreach( $services as $service ){
				$opt .= '<option selected value="'.$service->ID.'">'.$service->post_title.'</option>';
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
			$reservation = new Reservation;
			$times_array = $reservation->building_times( $salon_id, $service_id, $staff_id, $select_date );
			echo json_encode($times_array); 
			wp_die();
		}
	}
}

