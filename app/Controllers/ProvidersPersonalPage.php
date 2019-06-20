<?php

namespace App\Controllers;

use Sober\Controller\Controller;


class ProvidersPersonalPage extends Controller
{
	use \App\Controllers\Partials\SalonInfoTab;
	use \App\Controllers\Partials\ServiceInfoTab;
	use \App\Controllers\Partials\EventCalendarTab;

	private static $redux_demo;
	private static $wpdb;
	public function __construct() {
		global $redux_demo, $wpdb;
		self::$redux_demo = $redux_demo;
		self::$wpdb = $wpdb;

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

		add_action('wp_ajax_get_services', array($this, 'get_services'));
		add_action( 'wp_ajax_nopriv_get_services', array($this, 'get_services'));

		add_action('wp_ajax_remove_service', array($this, 'remove_service'));
		add_action( 'wp_ajax_nopriv_remove_service', array($this, 'remove_service'));

		add_action('wp_ajax_get_services_staff_list', array($this, 'get_services_staff_list'));
		add_action( 'wp_ajax_nopriv_get_services_staff_list', array($this, 'get_services_staff_list'));

		add_action('wp_ajax_add_new_staff', array($this, 'add_new_staff'));
		add_action( 'wp_ajax_nopriv_add_new_staff', array($this, 'add_new_staff'));

		add_action('wp_ajax_get_staff_table', array($this, 'get_staff_table'));
		add_action( 'wp_ajax_nopriv_get_staff_table', array($this, 'get_staff_table'));

		add_action('wp_ajax_remove_staff', array($this, 'remove_staff'));
		add_action( 'wp_ajax_nopriv_remove_staff', array($this, 'remove_staff'));

		add_action('wp_ajax_get_working_time', array($this, 'get_working_time'));
		add_action( 'wp_ajax_nopriv_get_working_time', array($this, 'get_working_time'));


		add_action('wp_ajax_get_events', array($this, 'get_events'));
		add_action( 'wp_ajax_nopriv_get_events', array($this, 'get_events'));

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