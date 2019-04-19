<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class RegisterPartner extends Controller
{	
	private static $redux_demo;
	public function __construct() {
		global $redux_demo;
		self::$redux_demo = $redux_demo;
		add_action('wp_ajax_register_partner_form', array($this, 'register_partner_form'));
		add_action( 'wp_ajax_nopriv_register_partner_form', array($this, 'register_partner_form'));
	}

	public function register_partner_form() {
		if ( isset($_POST["name"]) && isset($_POST["salonname"]) && isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["message"]) ) {
			$succesRegister = self::succes_register();
			$result = array(
				'name' => $_POST["name"],
				'salonname' => $_POST["salonname"],
				'login' => $_POST["login"],
				'email' => $_POST["email"],
				'phone' => $_POST["phone"],
				'message' => $_POST["message"],
				'type' => $_POST["type"],
				'succes' => $succesRegister,
			);
			$userId = self::register_user( $result );
			self::create_user_pages( $result['salonname'], $userId );
			echo json_encode( $result );
			wp_die();
		}
	}

	private function create_user_pages( $salonName, $userId ) {
		$pageArgs = array(
			'post_type' 		=> 'salons',
			'post_title'    	=> $salonName,
			'post_author' 		=> $userId,
			'post_status'   	=> 'private'
		);
		$userPageId = wp_insert_post( $pageArgs );
		return $userPageId;
	}

	private function register_user( $result ) {
		$userPass = self::generate_password();
		self::add_user_role();
		$userArgs = array(
			'user_login'    =>  $result['login'],
			'user_email'    =>  $result['email'],
			'user_pass'     =>  $userPass,
			'first_name'    =>  $result['name'],
			'description'	=> 	$result['message'],
			'role'          =>  'provider'
		);
		$userId = wp_insert_user( $userArgs );
		return $userId;
	}

	private function add_user_role() {
		add_role(
			'provider',
			__( 'Providers' ),
			array(
				'read'         => true,
				'edit_posts'   => true,
			)
		);
	}

	private function generate_password() {
		$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
		$pass = "";
		for($i = 0; $i < 10; $i++){
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
	}

	private function succes_register() {
		$successText = self::$redux_demo['editor-text'];
		return $successText;
	}
}	