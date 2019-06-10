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
			$post_id = self::set_services( $service_data );
			wp_die();
		}
	}

	public function get_service_categories() {
		$serviceCategoryArray = array(
			'type' 			=> 'services', 
			'taxonomy' 		=> 'categories-service', 
			'hide_empty' 	=> false,
			'order'			=>'DESC'
		);
		$serviceCategorys = get_categories( $serviceCategoryArray );
		if( $serviceCategorys ) {
			foreach ($serviceCategorys as $key => $value) {
				$sco .= "<li data-category-id='".$value->term_id."'>".esc_attr(apply_filters('the_title', $value->name))."</li>";
			}
			return $sco;
		}
	}



	private function set_services( $service_data ) {
		$post_id = wp_insert_post(array('post_type' => 'services', 'post_status'   => 'publish', 'post_title' => $service_data['name']));
		wp_set_post_terms($post_id, $service_data['category'], 'categories-service' );
		update_post_meta($post_id, 'duration', $service_data['duration']);
		update_post_meta($post_id, 'price', $service_data['price']);
		return $post_id;
	}



	public function get_services() {
		if( isset($_POST['author_id']) ) {
			$author_id = $_POST['author_id'];
			$args = array(
				'post_type' => 'services',
				'author'	=> get_current_user_id(),
				'order'		=> ASC
			);
			$query = new WP_Query;
			$posts = $query->query($args);
			$services = [];
			if( $posts ) {
				foreach ($posts as $key => $post) {
					$services[$key]['ID'] = $post->ID;
					$services[$key]['name'] = $post->post_title;
					$services[$key]['category']['name'] = get_the_terms($post->ID, 'categories-service')[0]->name;
					$services[$key]['category']['term_id'] = get_the_terms($post->ID, 'categories-service')[0]->term_id;
					$services[$key]['duration'] = get_post_meta($post->ID, 'duration', true);
					$services[$key]['price'] = get_post_meta($post->ID, 'price', true);
					$services[$key]['post_type'] = $post->post_type;
					$services[$key]['post_author'] = $post->post_author;
				}
			}else {
				$services = false;
			}
			echo \App\template('partials.content-service-table', compact('services'));
			wp_die();
		}
	}

	public function remove_service() {
		if( isset($_POST['remove_id']) ){
			$post_id = $_POST['remove_id'];
			wp_delete_post( $post_id, true );
			delete_post_meta( $post_id, 'duration' );
			delete_post_meta( $post_id, 'price' );
			wp_die();
		}
	}





















	public function get_services_staff_list() {
		if( isset($_POST['author_id']) ) {
			$author_id = $_POST['author_id'];
			$args = array(
				'post_type' => 'services',
				'author'	=> get_current_user_id(),
				'order'		=> ASC
			);
			$query = new WP_Query;
			$posts = $query->query($args);
			$services = [];
			foreach ($posts as $key => $post) {
				$services[$key]['ID'] = $post->ID;
				$services[$key]['name'] = $post->post_title;
				$services[$key]['category']['name'] = get_the_terms($post->ID, 'categories-service')[0]->name;
				$services[$key]['category']['term_id'] = get_the_terms($post->ID, 'categories-service')[0]->term_id;
				$services[$key]['duration'] = get_post_meta($post->ID, 'duration', true);
				$services[$key]['price'] = get_post_meta($post->ID, 'price', true);
				$services[$key]['post_type'] = $post->post_type;
				$services[$key]['post_author'] = $post->post_author;
			}
			echo \App\template('partials.content-service-list', compact('services'));
			wp_die();
		}
	}










	public function add_new_staff() {
		if( isset($_POST['name']) || isset($_POST['services_id']) ){
			$staff_name = $_POST['name'];
			$services_id = $_POST['services_id'];
			var_dump($staff_name);
			var_dump($services_id);
			$post_id = wp_insert_post(array('post_type' => 'staff', 'post_status' => 'publish', 'post_title' => $staff_name));
			foreach ($services_id as $key => $service_id) {
				add_post_meta( $service_id, 'staffs_id', $post_id, false );
			}
			wp_die();
		}
	}

	public function get_staff_table() {
		global $wpdb;
		if( isset($_POST['author_id']) ) {
			$args = array(
				'post_type' 		=> 'staff',
				'author'			=> get_current_user_id(),
				'order'				=> ASC,
				'posts_per_page'	=> -1
			);
			$query = new WP_Query;
			$posts = $query->query($args);
			
			if( $posts ) {
				$staffs = [];
				foreach ($posts as $key => $post) {
					$services_name = [];
					$services_id = $wpdb->get_results( 'SELECT * FROM `wp_postmeta` WHERE meta_value = '.$post->ID.'', ARRAY_A );
					foreach ($services_id as $key_two => $value) {
						$services_name[$key_two] = get_post($value['post_id'])->post_title;
					}
					$staffs[$key]['ID'] = $post->ID;
					$staffs[$key]['post_title'] = $post->post_title;
					$staffs[$key]['services_name'] = $services_name;
				}
			}
			echo \App\template('partials.content-staff-table', compact('staffs'));
			wp_die();
		}
	}



	public function remove_staff() {
		global $wpdb;
		if( isset($_POST['remove_id']) ){
			$post_id = $_POST['remove_id'];
			wp_delete_post($post_id, true);
			$del_status = $wpdb->delete( 'wp_postmeta', array('meta_value' => $post_id) );
			var_dump($del_status);
			/*
			delete_post_meta( $deleted->ID, 'staff_id', $post_id );*/
			wp_die();
		}
	}



}