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
		self::search_query( $dataArray );

		//self::results_search( $post_type, $name, $address, $type, $paged, $query );
		wp_die();
	}

	public function get_search_results_loadmore() {
		$form_data = $_POST['form_data'];
		$query = $_POST['query'];
		$paged = $_POST['paged'];
		$dataArray = array(
			'form_data'	=> $form_data,
			'post_type' => $form_data[0]['value'],
			'name'		=> $form_data[1]['value'],
			'address'	=> $form_data[2]['value'],
			'type'		=> $form_data[3]['value'],
			'query' 	=> $query,
			'paged' 	=> $paged,
		);
		self::search_query( $dataArray );
		wp_die();
	}

	/*public function ajax_loadmore_post() {
		if( isset($_POST['true_posts']) || isset($_POST['current_page']) ) {
			$args = unserialize( stripslashes( $_POST['true_posts'] ) );
			$args['paged'] = $_POST['current_page']+1;
			
			$query = new WP_Query( $args );
			$posts = $query->posts;

			$posts = (array)self::filterPostsByAdress( $posts, $_POST['address'] );

			$posts = self::sort_by_plan((array)$posts);
			if( $posts ) {
				?>
				<pre style="color: #fff;">
					<?php var_dump($posts); ?>
				</pre>
				<?php
			}
			
			self::results_search( $_POST['post_type'], $_POST['name'], $_POST['address'], $_POST['category'], $_POST['page']+1 );
			wp_die();
		}
	}*/

	private function search_query( $dataArray ) {
		if( $dataArray['type'] ) {
			$taxArray = array(
				'taxonomy' => 'categories-salon',
				'field'    => 'id',
				'terms'    => $dataArray['type'],
			);
		}else {
			$taxArray = '';
		}
		if( $dataArray['query'] && $dataArray['paged'] ) {
			$args = $dataArray['query'];
			/*$args = array(
				's' 				=> $dataArray['name'],
				'post_type' 		=> $dataArray['post_type'],
				'tax_query' 		=> array( $taxArray ),
				'posts_per_page' 	=> 4,
				'post_status'		=> 'publish',
				'paged'				=> $dataArray['paged']+1,
			);*/
			$args = $dataArray['query'];
			$args['tax_query'] = array( $taxArray );
			$args['paged'] = $dataArray['paged']+1;
			$query = new WP_Query( $args );
		}else {
			$query = new WP_Query(
				array(
					's' 				=> $name,
					'post_type' 		=> $dataArray['post_type'],
					'tax_query' 		=> array( $taxArray ),
					'posts_per_page' 	=> 4,
					'paged'				=> 1,
					'post_status'		=> 'publish'
				)
			);
		}
		echo \App\template('partials.content-search-result', compact('query'));
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
	public function results_search( $post_type, $name, $address, $type, $paged, $query ) {
		$query = self::search_query();
		
		/*$posts = $query->posts;

		$posts = (array)self::filterPostsByAdress( $posts, $address );

		$posts = self::sort_by_plan((array)$posts);

		$countPost = $query->found_posts;*/

		/*$post_array = [];
		$post_array['paged'] = $query->query['paged'];
		$post_array['max_num_pages'] = $query->max_num_pages;
		$post_array['query_vars'] = $query->query_vars;
		$post_array['query_vars_paged'] = $query->query_vars['paged'];
		foreach ($posts as $key => $value) {
			$post_array['posts'][$key] = $value;
			$post_array['posts'][$key]->post_gallery = get_field( 'images_gallery', $value->ID );
			$post_array['posts'][$key]->post_image = get_field( 'images_gallery', $value->ID )[0]['url'];
			$post_array['posts'][$key]->post_permalink = get_the_permalink( $value );
			$post_array['posts'][$key]->link_path = get_stylesheet_directory_uri();
		}*/

		//$post_array = 'Hello';

		//echo \App\template('partials.content-search-result', compact('post_array'));
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
