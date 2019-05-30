<?php

namespace App\Controllers;

use Sober\Controller\Controller;


class ProvidersPersonalPage extends Controller
{
	use \App\Controllers\Partials\SalonInfoTab;
	use \App\Controllers\Partials\ServiceInfoTab;

	private static $redux_demo;
	public function __construct() {
		global $redux_demo;
		self::$redux_demo = $redux_demo;

		add_action('wp_ajax_salon_form', array($this, 'salon_form'));
		add_action( 'wp_ajax_nopriv_salon_form', array($this, 'salon_form'));

		add_action('wp_ajax_get_upload_images', array($this, 'get_upload_images'));
		add_action( 'wp_ajax_nopriv_get_upload_images', array($this, 'get_upload_images'));

		add_action('wp_ajax_delete_gallery_image', array($this, 'delete_gallery_image'));
		add_action( 'wp_ajax_nopriv_delete_gallery_image', array($this, 'delete_gallery_image'));

		add_action('wp_ajax_workers_days', array($this, 'workers_days'));
		add_action( 'wp_ajax_nopriv_workers_days', array($this, 'workers_days'));

		add_action('wp_ajax_get_workers_days', array($this, 'get_workers_days'));
		add_action( 'wp_ajax_nopriv_get_workers_days', array($this, 'get_workers_days'));


		add_action('wp_ajax_service_form', array($this, 'service_form'));
		add_action( 'wp_ajax_nopriv_service_form', array($this, 'service_form'));
	}
	public function current_user() {
		$user = wp_get_current_user();
		$currentUserArray = array(
			'ID' 				=> $user->ID,
			'user_login' 		=> $user->user_login,
			'user_email' 		=> $user->user_email,
			'user_firstname'	=> $user->user_firstname,
			'user_lastname' 	=> $user->user_lastname,
		);
		return $currentUserArray;
	}
}