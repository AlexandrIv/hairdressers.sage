<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class Single extends Controller
{
	public function address() {
		return get_post_meta( get_the_ID(), 'address', true)['address'];
	}
	public function single_slider() {
		return get_field( 'images_gallery' );
	}
	public function single_map_info() {
		$returnArray['lat'] = get_post_meta( get_the_ID(), 'address', true)['lat'];
		$returnArray['lng'] = get_post_meta( get_the_ID(), 'address', true)['lng'];
		$returnArray['address'] = get_post_meta( get_the_ID(), 'address', true)['address'];
		$returnArray['post_title'] = get_the_title();
		$returnArray['image_url'] = get_field( 'images_gallery' )[0]['url'];
		return $returnArray;
	}
	public function get_opening_times() {
		$day_time_array = get_post_meta( get_the_ID(), 'workers_days', true );
		return $day_time_array;
	}


	public function get_single_service() {
		$serviceCategoryArray = array(
			'type'      => 'services', 
			'taxonomy'    => 'categories-service', 
		);
		$serviceCategorys = get_categories( $serviceCategoryArray );
		$data_array = [];
		foreach ($serviceCategorys as $key1 => $value) {
			$mypost = array(
				'post_type' => 'services',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'categories-service',
						'field' => 'term_id',
						'terms' => $value->term_id,
					),
				),
			);
			$loop = new WP_Query( $mypost );
			foreach ($loop->posts as $key2 => $post) {
				$data_array[$value->name][$key2] = $post;
			}
		}
		return $data_array;
	}


}