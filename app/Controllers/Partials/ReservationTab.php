<?php

namespace App\Controllers\Partials;
use WP_Query;

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






}