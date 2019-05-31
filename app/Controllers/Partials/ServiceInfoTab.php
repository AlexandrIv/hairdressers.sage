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
				'author'	=> $author_id,
				'order'		=> ASC,
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
				'author'	=> $author_id,
				'order'		=> ASC,
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
			$post_id = wp_insert_post(array('post_type' => 'staff', 'post_status' => 'publish', 'post_title' => $staff_name));
			update_post_meta( $post_id, 'services_id', $services_id );
			wp_die();
		}
	}

	public function get_staff_table() {
		if( isset($_POST['author_id']) ) {
			$args = array(
				'post_type' => 'staff',
				'author'	=> $author_id,
				'order'		=> ASC,
			);
			$query = new WP_Query;
			$posts = $query->query($args);
			$staffs = [];
			if( $posts ) {
				foreach ($posts as $key => $post) {
					$staffs[$key]['ID'] = $post->ID;
					$staffs[$key]['post_title'] = $post->post_title;
					$staffs[$key]['services_id'] = get_post_meta( $post->ID, 'services_id', true );
				}
			}			
			echo \App\template('partials.content-staff-table', compact('staffs'));
			wp_die();
		}
	}



	public function remove_staff() {
		if( isset($_POST['remove_id']) ){
			$post_id = $_POST['remove_id'];
			wp_delete_post( $post_id, true );
			delete_post_meta( $post_id, 'services_id' );
			wp_die();
		}
	}



}