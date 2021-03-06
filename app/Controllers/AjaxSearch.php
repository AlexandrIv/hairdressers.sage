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
		add_action('wp_ajax_get_search_results', array($this, 'get_search_results'));
		add_action( 'wp_ajax_nopriv_get_search_results', array($this, 'get_search_results'));

		add_action('wp_ajax_get_search_results_loadmore', array($this, 'get_search_results_loadmore'));
		add_action( 'wp_ajax_nopriv_get_search_results_loadmore', array($this, 'get_search_results_loadmore'));
	}

	public function get_search_results() {
		$form_data = $_POST['form_data'];
		$dataArray = array(
			'form_data'	=> $form_data,
			'post_type' => $form_data[0]['value'],
			'name'		=> $form_data[1]['value'],
			'address'	=> $form_data[2]['value'],
			'type'		=> $form_data[3]['value']
		);
		if( $dataArray['type'] ) {
			$taxArray = array(
				'taxonomy' => 'categories-salon',
				'field'    => 'id',
				'terms'    => $dataArray['type'],
			);
		}else {
			$taxArray = '';
		}
		$query = new WP_Query(
			array(
				's' 				=> $dataArray['name'],
				'post_type' 		=> $dataArray['post_type'],
				'tax_query' 		=> array( $taxArray ),
				'posts_per_page' 	=> 4,
				'paged'				=> 1,
				'post_status'		=> 'publish'
			)
		);
		$posts = $query->posts;
		$posts = (array)self::filterPostsByAdress( $posts, $_POST['address'] );
		$posts = self::sort_by_plan((array)$posts);

		$posts = self::posts_arrays( $posts );
		
		echo \App\template('partials.content-search-result', compact('query', 'posts'));
		wp_die();
	}

	public function get_search_results_loadmore() {
		$query_vars = $_POST['query_vars'];
		$paged = $_POST['paged'];

		$args = unserialize( stripslashes( $query_vars ) );
		$args['paged'] = $paged+1;
		$query = new WP_Query( $args );
		$posts = $query->posts;
		$posts = (array)self::filterPostsByAdress( $posts, $_POST['address'] );
		$posts = self::sort_by_plan((array)$posts);
		$posts = self::posts_arrays( $posts );

		echo \App\template('partials.content-search-result-loadmore', compact('query', 'posts'));
		wp_die();
	}

	private function posts_arrays( $posts ) {
		$post_array = [];
		foreach ($posts as $key => $value) {
			$post_array['posts'][$key] = $value;
			$post_array['posts'][$key]->post_gallery = get_field( 'images_gallery', $value->ID );
			$post_array['posts'][$key]->post_image = get_field( 'images_gallery', $value->ID )[0]['url'];
			$post_array['posts'][$key]->post_permalink = get_the_permalink( $value );
			$post_array['posts'][$key]->link_path = get_stylesheet_directory_uri();
		}
		return $post_array;
	}

	private function sort_by_plan($posts) {
		$posts = array_map(function($post){
			$post->plan = get_post_meta($post->ID, 'plan_type', true);
			return $post;
		}, $posts);
		function cmp($a, $b) {
			return strcmp($b->plan, $a->plan);
		}
		usort($posts, "cmp");
		return $posts;
	}
	
	private function filterPostsByAdress( $posts, $address ){
		$dataArray = [];
		foreach ($posts as $key => $value) {
			$postCoordinate = get_post_meta( $value->ID, 'address', true);
			if( $address ) {
				$url = self::prepareSearchInputForGoogle($address);
				$remote_get = wp_remote_get( $url );
				$searchLat = json_decode($remote_get['body'])->results[0]->geometry->location->lat;
				$searchLng = json_decode($remote_get['body'])->results[0]->geometry->location->lng;
			}
			$value->lat = $postCoordinate['lat'];
			$value->lng = $postCoordinate['lng'];
			$value->address = $postCoordinate['address'];
			$dataArray[] = $value;
		}
		if( !$address ) {
			return $dataArray;
		} else {
			$searchLocation = [
				'lat' => $searchLat, 
				'lng' => $searchLng,
			];
			$newPosts = self::filterPoints( $searchLocation, $dataArray, 50 );
			return $newPosts;
		}
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
