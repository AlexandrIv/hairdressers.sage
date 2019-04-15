<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class AjaxSearch extends Controller
{
	private static $redux_demo;
	public function __construct() {
		global $redux_demo;
		self::$redux_demo = $redux_demo;
		add_action('wp_ajax_get_order_services_db', array($this, 'get_order_services_db'));
		add_action( 'wp_ajax_nopriv_get_order_services_db', array($this, 'get_order_services_db'));
	}
	public function get_order_services_db() {
		$form_data = $_POST['form_data'];
		$post_type = $form_data[0]['value'];
		$name = $form_data[1]['value'];
		$address = $form_data[2]['value'];
		$type = $form_data[3]['value'];

		self::results_search( $post_type, $name, $address, $type );
		wp_die();
	}

	public function results_search( $post_type, $name, $address, $type ) {
		if( $type ) {
			$taxArray = array(
				'taxonomy' => 'categories-salon',
				'field'    => 'id',
				'terms'    => $type,
			);
		}else {
			$taxArray = '';
		}
		$query = new WP_Query(
			array(
				's' 		=> $name,
				'post_type' => $post_type,
				'tax_query' => array( $taxArray ),
			)
		);
		$posts = $query->posts;
		if( $address ) {
			$posts = (array)self::filterPostsByAdress( $posts, $address );
			$postCount = count( $posts );
		}else {
			$posts = $posts;
		}
		/*$posts = self::filterPostsByAdress( $posts, $address );*/

		$post_array = [];
		foreach ($posts as $key => $value) {
			$post_array[$key] = $value;
			
		}
		echo \App\template('partials.content-search-result', compact('post_array'));
	}

	private function filterPostsByAdress( $posts, $address ){
		$dataArray = [];
		foreach ($posts as $key => $value) {
			$postCoordinate = get_post_meta( $value->ID, 'address', true);
			$url = self::prepareSearchInputForGoogle($address);
			$remote_get = wp_remote_get( $url );
			$searchLat = json_decode($remote_get['body'])->results[0]->geometry->location->lat;
			$searchLng = json_decode($remote_get['body'])->results[0]->geometry->location->lng;
			$value->lat = $postCoordinate['lat'];
			$value->lng = $postCoordinate['lng'];
			$value->address = $postCoordinate['address'];
			$dataArray[] = $value;
		}
		$searchLocation = [
			'lat' => $searchLat, 
			'lng' => $searchLng,
		];
		$newPosts = self::filterPoints( $searchLocation, $dataArray, 50 );
		return $newPosts;
	}
	private function prepareSearchInputForGoogle( $address ) {
		$googleApi = self::$redux_demo['google-api-key'];
		$addressReplace = str_replace(" ", "+", $address);
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address="'.$addressReplace.'"&key='.$googleApi;
		return $url;
	}
	private function filterPoints( $location, $points, $distance = 50 ){
		foreach ( $points as $key => $point ){
			$points[$key]->distance = self::calcDistance(
				$location['lat'],
				$location['lng'],
				$point->lat,
				$point->lng,
				"K"
			);
		}
		$points = array_filter( $points, function ( $elem ) use ( $distance ) {
			return $elem->distance < $distance;
		} );
		usort( $points, function ( $a, $b ) {
			return $a->distance - $b->distance;
		} );
		return $points;
	}
	private function calcDistance( $lat1, $lon1, $lat2, $lon2, $unit = 'K' ) {
		$theta = $lon1 - $lon2;
		$dist  = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) + cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );
		$dist  = acos( $dist );
		$dist  = rad2deg( $dist );
		$miles = $dist * 60 * 1.1515;
		$unit  = strtoupper( $unit );

		if ( $unit == "K" ) {
			return ( $miles * 1.609344 );
		} else if ( $unit == "N" ) {
			return ( $miles * 0.8684 );
		} else {
			return $miles;
		}
	}

}
