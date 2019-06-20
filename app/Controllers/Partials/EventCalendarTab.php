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
			var_dump($get_orders);
			wp_die();
		}
		
	}

	public function test() {
		return array('start' => date("Y-m-d H:i:s", '1560664800'), 'end' => date("Y-m-d H:i:s", '1560668400')  );
	}
}