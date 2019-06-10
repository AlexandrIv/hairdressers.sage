<?php

namespace App\Controllers\Partials;
use WP_Query;

trait SalonInfoTab
{
	public function salon_form() {

		if( isset($_POST['post_id']) || isset($_POST['salon_name']) || isset($_POST['address']) || isset($_POST['description']) || isset($_FILES['upload_attachment']) || isset($_POST['salon_category']) ){
			$files = $_FILES['upload_attachment'];
			$postId = $_POST['post_id'];
			$saloFormData = array(
				'salon_name' 		=> $_POST['salon_name'],
				'address' 			=> $_POST['address'],
				'description' 		=> $_POST['description'],
				'category' 			=> $_POST['salon_category'],
			);
			$saloFormData['address_data'] = $address_data;
			$address_data = self::update_post( $saloFormData, $postId );
			self::upload_gallery_images( $files, $postId );
			echo json_encode( $saloFormData );
			wp_die();
		}
	}
	public function workers_days() {
		if( isset($_POST['days_array']) && isset($_POST['post_id']) ) {
			$days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
			$uploadArray = [];
			foreach ($_POST['days_array'] as $key => $value) {
				foreach ($days as $day) {
					$start = $_POST['days_array'][$day.'_start'];
					$end = $_POST['days_array'][$day.'_end'];
					$uploadArray[$day] = array( 'start' => $start, 'end' => $end );
				}
			}
			update_post_meta( $_POST['post_id'], 'workers_days', $uploadArray );
			wp_die();
		}
	}

	private function update_post( $saloFormData, $postId ) {
		$post = array();
		$post['ID'] = $postId;
		$post['post_title'] = $saloFormData['salon_name'];
		$post['post_content'] = $saloFormData['description'];
		wp_update_post( wp_slash($post) );
		$term = [];
		foreach ($saloFormData['category'] as $key => $value) {
			$term[$key] = get_term($value, 'categories-salon', ARRAY_A)['name'];
		}
		wp_set_object_terms( $postId, $term, 'categories-salon' );

		$address = get_post_meta($postId, 'address', true);
		if( empty($address) && !empty($saloFormData['address']) ) {			
			$getLatLng = self::get_lat_lng( $saloFormData['address'] );
			$address = array(
				'address' => $saloFormData['address'],
				'lat' => $getLatLng['lat'],
				'lng' => $getLatLng['lng']
			);
			update_post_meta($postId, 'address', $address);		
		}
		if( empty($saloFormData['address']) ) {
			delete_post_meta($postId, 'address');
		}
		return $address;
	}

	private function get_lat_lng( $address ) {
		$googleApi = self::$redux_demo['google-api-key'];
		$addressReplace = str_replace(" ", "+", $address);
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address="'.$addressReplace.'"&key='.$googleApi;
		$remote_get = wp_remote_get( $url );
		$searchData = [];
		$searchData['lat'] = json_decode($remote_get['body'])->results[0]->geometry->location->lat;
		$searchData['lng'] = json_decode($remote_get['body'])->results[0]->geometry->location->lng;
		return $searchData;
	}

	private function upload_gallery_images( $files, $postId ) {
		if ($files && $postId) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			$files = $_FILES['upload_attachment'];
			$count = 0;
			$galleryImagesField = get_field('field_5cc043a7e6e21', $postId);
			$galleryImages = array();
			if($galleryImagesField){
				foreach($galleryImagesField as $attachment){
					$galleryImages[] = $attachment["ID"];
				}
			}
			foreach ($files['name'] as $count => $value) {
				if(empty($value)) wp_die();
				if ($files['name'][$count]) {
					$file = array(
						'name'     => $files['name'][$count],
						'type'     => $files['type'][$count],
						'tmp_name' => $files['tmp_name'][$count],
						'error'    => $files['error'][$count],
						'size'     => $files['size'][$count]
					);
					$upload_overrides = array( 'test_form' => false );
					$upload = wp_handle_upload($file, $upload_overrides);
					$filename = $upload['file'];
					$parent_post_id = $postId;
					$filetype = wp_check_filetype( basename( $filename ), null );
					$wp_upload_dir = wp_upload_dir();
					$attachment = array(
						'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
						'post_mime_type' => $filetype['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					wp_update_attachment_metadata( $attach_id, $attach_data );
					$galleryImages[] = $attach_id;
				}
				$count++;
			}
			update_field('field_5cc043a7e6e21', $galleryImages, $postId);
		}
	}

	public function get_salon_info() {
		$user = wp_get_current_user();
		$salonArgs = array(
			'post_type'		=> 'salons',
			'author' 		=> $user->ID,
		);
		$salons = new WP_Query;
		$salonsPost = $salons->query( $salonArgs );
		$terms = get_terms( array(
			'taxonomy' => 'categories-salon',
			'hide_empty' => false,
		) );
		$salonInfo = [];
		foreach ($salonsPost as $salon) {

			if( isset(get_post_meta( $salon->ID, 'address', true)['address'])) {
				$address = get_post_meta( $salon->ID, 'address', true)['address'];
			}else {
				$address = '';
			}
			$salonInfo['ID'] = $salon->ID;
			$salonInfo['user-id'] = $user->ID;
			$salonInfo['name'] = $salon->post_title;
			$salonInfo['description'] = $salon->post_content;
			$salonInfo['address'] = $address;
			$salonInfo['category'] = $terms;
			$salonInfo['category_checked'] = get_the_terms($salon->ID, 'categories-salon');
		}
		return $salonInfo;
	}
	public function get_upload_images() {
		if( isset($_POST['post_id']) ) {
			$galery_images = get_field( 'images_gallery', $_POST['post_id']);
			if( $galery_images ) {
				foreach ($galery_images as $key => $galery_image) {
					?>
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 img-box" data-key-img="<?php echo $key; ?>" style="background-image: url('<?php echo $galery_image['url']; ?>');">
						<div class="bg-img"></div>
						<a class="del-img" id="del-img" data-delete-img-id="<?php echo $galery_image['ID']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
					<?php
				}
			}
			wp_die();
		}
	}
	public function delete_gallery_image() {
		if( isset($_POST['image_id']) ) {
			$delImgId = $_POST['image_id'];
			wp_delete_attachment( $delImgId, $force_delete = true );
			wp_die();
		}
	}

	public function get_workers_days() {
		if( isset($_POST['post_id']) ) {
			$work_day_time = get_post_meta( $_POST['post_id'], 'workers_days', true );
			echo json_encode( $work_day_time );
			wp_die();
		}
	}

	public function working_day() {
		$workingDaysArray = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		foreach ($workingDaysArray as $key => $value) {
			$days = '
			<div class="day">
			<label for="input-'.lcfirst($value).'_start"><span>'.$value.' start</span>
			<input type="text" name="'.lcfirst($value).'_start" data-day="'.lcfirst($value).'_start" class="open-list-start" id="input-'.lcfirst($value).'_start" placeholder="08:00 AM" autocomplete="off" readonly>
			<ul class="time-list-start" id="'.lcfirst($value).'_start">'.self::get_times().'</ul>
			</label>
			<label for="input-'.lcfirst($value).'_end"><span>'.$value.' end</span>
			<input type="text" name="'.lcfirst($value).'_end" data-day="'.lcfirst($value).'_end" class="open-list-end" id="input-'.lcfirst($value).'_end" placeholder="08:00 AM" autocomplete="off" readonly>
			<ul class="time-list-end" id="'.lcfirst($value).'_end">'.self::get_times().'</ul>
			</label>
			</div>';
			$dayArray[$key] = $days;
		}
		return $dayArray;
	}

	private function get_times( $default = '19:00', $interval = '+30 minutes' ) {
		$output = '';
		$current = strtotime( '00:00' );
		$end = strtotime( '23:59' );
		while( $current <= $end ) {
			$time = date( 'H:i_A', $current );
			$sel = ( $time == $default ) ? ' selected' : '';
			$output .= "<li data-value=\"{$time}\"{$sel}>" . date( 'h:i A', $current ) .'</li>';
			$current = strtotime( $interval, $current );
		}
		$output .= '<li data-value="closed">Closed</li>';
		return $output;
	}





	



}
