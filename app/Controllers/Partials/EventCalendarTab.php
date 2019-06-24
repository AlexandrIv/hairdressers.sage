<?php

namespace App\Controllers\Partials;
use WP_Query;

trait EventCalendarTab
{

	public function get_working_time() {
		if( isset($_POST['salon_id']) ) {
			$salon_id = $_POST['salon_id'];
			$workers_days = get_post_meta($salon_id, 'workers_days', true);
			$min = min( array_column( $workers_days, 'start' ) );
			$max = max( array_column( $workers_days, 'end' ) );

			$min = strtotime(substr($min, 0, -3));
			$max = strtotime(substr($max, 0, -3));

			$array = array(
				'min' => (int)date("H", $min),
				'max' => (int)date("H", $max)
			);
			echo json_encode($array);
			wp_die();
		}
	}

	public function get_events() {
		if( isset($_POST['salon_id']) ) {
			$salon_id = $_POST['salon_id'];
			$get_orders = self::$wpdb->get_results( 'SELECT * FROM `wp_order_table` WHERE id_salon_order = '.$salon_id.' ', ARRAY_A );
			$array_event = [];
			$users_data = [];
			foreach ($get_orders as $key => $order) {
				$str_start = strtotime($order['time_order']);
				$str_end = strtotime('+'.$order['duration_order'].'minutes', $str_start);
				$start = date('H', $str_start);
				$end = date('H', $str_end);

				$users_data = unserialize($order['user_data']);

				$array_event[$key]['salon'] = get_the_title($order['id_salon_order']);
				$array_event[$key]['service'] = get_the_title($order['id_service_order']);
				$array_event[$key]['staff'] = get_the_title($order['id_staff_order']);
				$array_event[$key]['date'] = $order['date_order'];
				$array_event[$key]['time'] = $order['time_order'];
				$array_event[$key]['starts'] = (int)$start;
				$array_event[$key]['ends'] = (int)$end;

				$array_event[$key]['userdata']['Name'] = $users_data['name'];
				$array_event[$key]['userdata']['Surname'] = $users_data['surname'];
				$array_event[$key]['userdata']['Email'] = $users_data['email'];
				$array_event[$key]['userdata']['Phone'] = $users_data['phone'];
			}
			
			echo json_encode($array_event);
			wp_die();
		}
		
	}

	public function test() {
		return array('start' => date("Y-m-d H:i:s", '1560664800'), 'end' => date("Y-m-d H:i:s", '1560668400')  );
	}
}