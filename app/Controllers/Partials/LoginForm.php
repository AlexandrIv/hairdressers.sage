<?php

namespace App\Controllers\Partials;

trait LoginForm
{
	public function login_form() {
		if( isset($_POST["login"]) && isset($_POST["password"]) ) {
			$loginData = array(
				'user_login' 	=> $_POST["login"],
				'user_password'	=> $_POST["password"],
			);
			$user = wp_signon( $loginData, false );
			if( is_wp_error($user) ){
				echo $user->get_error_message(); 
			} 
			wp_set_current_user($user->ID);

			if( wp_get_current_user()->user_login == 'admin' ) {
				$redirectUrl = get_home_url(null, 'wp-admin/');
			} else {
				$redirectUrl = get_home_url(null, 'partner-page/');
			}

			$returnData = array(
				'user_role' 	=> wp_get_current_user()->user_login,
				'user_type' 	=> $userLogonLogoutType,
				'redirect_url'	=> $redirectUrl,
			);
			echo json_encode($returnData);
			wp_die();
		}
	}
}