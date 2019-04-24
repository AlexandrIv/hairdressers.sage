<?php

namespace App\Controllers\Partials;
use WP_Query;

trait SalonInfoTab
{
	public function salon_form() {
		if( isset($_POST['salon_name']) && isset($_POST['address']) && isset($_POST['description']) ){
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			$files = $_FILES['upload_attachment'];
			$saloFormData = array(
				'salon_name' 		=> $_POST['salon_name'],
				'address' 			=> $_POST['address'],
				'description' 		=> $_POST['description'],
				'upload_attachment' => $files,
			);
			echo json_encode($saloFormData);
			wp_die();
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
			$salonInfo['ID'] = $salon->ID;
			$salonInfo['name'] = $salon->post_title;
			$salonInfo['description'] = $salon->post_content;
			$salonInfo['address'] = get_post_meta( $salon->ID, 'address', true)['address'];
			$salonInfo['category'] = $terms;
			$salonInfo['category_checked'] = get_the_terms($salon->ID, 'categories-salon');
		}
		return $salonInfo;
	}

	public function get_upload_images() {
		if( isset($_POST['post_id'])) {
			$galery_images = get_field( 'images_gallery', $_POST['post_id']);
			if( $galery_images ) {
				foreach ($galery_images as $key => $galery_image) {
					?>
					<div class="col-4 img-box" data-key-img="<?php echo $key; ?>" style="background-image: url('<?php echo $galery_image['url']; ?>');">
						<div class="bg-img"></div>
						<a class="del-img" id="del-img" data-delete-img-id="<?php echo $galery_image['ID']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
					<?php
				}
			}
			wp_die();
		}
	}
}
