<?php

namespace App\Controllers\Partials;
use WP_Query;

trait ServiceInfoTab
{
	public function duration() {
		for ( $i = 0; $i < 3; $i++ ) :
			for ( $j = 30; $j <= 60; $j += 30 ) :
				$duration = ( $i * 3600 ) + ( $j * 60 );
				$hour = date("H:i", $duration);
				$time .= "<li data-duration='{$duration}'>{$hour}</li>";
			endfor;
		endfor;
		return $time;
	}

	public function service_form() {
		if(isset($_POST['category']) || isset($_POST['name']) || isset($_POST['duration']) || isset($_POST['price'])) {
			$service_data['category'] = $_POST['category'];
			$service_data['name'] = $_POST['name'];
			$service_data['duration'] = $_POST['duration'];
			$service_data['price'] = (int)$_POST['price'];
			//$post_id = self::set_services( $service_data );

			var_dump( get_terms( array('taxonomy' => array('categories-service')) ));

			var_dump($post_id);
			wp_die();
		}
	}
	private function set_services( $service_data ) {
		$post_id = wp_insert_post(array('post_type' => 'services', 'post_status'   => 'publish', 'post_title' => $service_data['name']));
		update_post_meta($post_id, 'duration', $service_data['duration']);
		update_post_meta($post_id, 'price', $service_data['price']);
		return $post_id;
	}
	public function get_services() {

	}
}