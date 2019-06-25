<?php

namespace App\Controllers\Partials;
use WP_Query;
use FirstBookingPageTemplate;

trait ReservationTab
{
	public function get_services_opt() {
		$author = wp_get_current_user()->ID;
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

	


	public function get_list_times_reservation() {
		if( isset($_POST['salon_id']) && isset($_POST['service_id']) && isset($_POST['staff_id']) && isset($_POST['select_date']) ) {
			$salon_id = $_POST['salon_id'];
			$service_id = $_POST['service_id'];
			$staff_id = $_POST['staff_id'];
			$select_date = $_POST['select_date'];

			$times = new FirstBookingPageTemplate;
			$list_times = $times->list_times( $salon_id, $service_id, $staff_id, $select_date );
			echo json_encode($list_times); 
			wp_die();
		}
	}

	public function reservation_order() {
		if( isset($_POST['salon_id']) && isset($_POST['service_id']) && isset($_POST['staff_id']) && isset($_POST['select_date']) && isset($_POST['select_key']) ) {
			var_dump('Hello');
			/*$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$interval = $_POST['interval'];
			$duration = $_POST['duration'];
			$select_key = $_POST['select_key'];
			$select_time = $_POST['time'];
			$select_date = $_POST['select_date'];

			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];


			$time = new FirstBookingPageTemplate;
			$timesArray = $time->time_array( $start_time, $end_time, $interval, $duration, $select_date );
			$newTimesArray = self::new_time_array( $timesArray, $select_key );

			$setDatabaseArray['salon_id'] = $_POST['salon_id'];
			$setDatabaseArray['service_id'] = $_POST['service_id'];
			$setDatabaseArray['staff_id'] = $_POST['staff_id'];
			$setDatabaseArray['select_date'] = $_POST['select_date'];
			$setDatabaseArray['select_key'] = $_POST['select_key'];
			$setDatabaseArray['data_array'] = $newTimesArray;

			$orderData = array(
				'salon_name' 	=> get_the_title( $setDatabaseArray['salon_id'] ),
				'service_name' 	=> get_the_title( $setDatabaseArray['service_id'] ),
				'staff_name' 	=> get_the_title( $setDatabaseArray['staff_id'] ),
				'date' 			=> $setDatabaseArray['select_date'],
				'time' 			=> $select_time,
				'duration' 		=> $duration,
				'name' 			=> $name,
				'surname' 		=> $surname,
				'email' 		=> $email,
				'phone' 		=> $phone
			);

			$userData = array(
				'name' 		=> $name,
				'surname' 	=> $surname,
				'email'		=> $email,
				'phone'		=> $phone
			);
			$orderArray = array(
				'id_salon_order' 	=> $_POST['salon_id'],
				'id_service_order' 	=> $_POST['service_id'],
				'id_staff_order'	=> $_POST['staff_id'],
				'date_order'		=> $_POST['select_date'],
				'time_order'		=> $_POST['time'],
				'duration_order'	=> $_POST['duration'],
				'user_data'			=> serialize( $userData )
			);

			var_dump($orderData);
			var_dump($userData);*/

			/*$setTimesDB = self::set_times_database( $setDatabaseArray );
			$setOrderData = self::set_order_data( $orderArray );
			if( $setTimesDB && $setOrderData ) {
				echo \App\template('partials.reservation-info-part', compact('orderData', 'userData'));
			} else {
				var_dump($setTimesDB);
			}*/
			wp_die();
		}
	}




}