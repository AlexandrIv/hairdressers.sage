<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class TaxonomyCategoriesSalon extends Controller
{
	public function get_category_posts() {
		$term_id = (int) get_queried_object()->term_id;
		$posts = get_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' => 'categories-salon',
					'field'    => 'id',
					'terms'    => array( $term_id )
				)
			),
			'post_type' => 'salons',
			'posts_per_page' => -1
		) );
		$posts = self::posts_arrays( $posts );
		return $posts;
	}

	private function posts_arrays( $posts ) {
		$post_array = [];
		foreach ($posts as $key => $value) {
			$post_array['posts'][$key] = $value;
			$post_array['posts'][$key]->post_gallery = get_field( 'images_gallery', $value->ID );
			$post_array['posts'][$key]->post_image = get_field( 'images_gallery', $value->ID )[0]['url'];
			$post_array['posts'][$key]->post_permalink = get_the_permalink( $value );
			$post_array['posts'][$key]->link_path = get_stylesheet_directory_uri();
			$post_array['posts'][$key]->address = get_post_meta( $value->ID, 'address', true)['address'];
			$post_array['posts'][$key]->lat = get_post_meta( $value->ID, 'address', true)['lat'];
			$post_array['posts'][$key]->lng = get_post_meta( $value->ID, 'address', true)['lng'];
		}
		return $post_array;
	}

	/*private function sort_by_plan($posts) {
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
	}*/
}