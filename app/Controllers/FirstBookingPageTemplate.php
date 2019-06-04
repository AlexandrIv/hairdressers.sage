<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FirstBookingPageTemplate extends Controller
{

	public function get_option_service() {
		if( isset($_GET['sce']) || isset($_GET['stf']) || isset($_GET['aut']) ) {
			/*var_dump();*/
		}
	}

	public function get_service() {
		if( isset($_GET['sce']) || isset($_GET['stf']) || isset($_GET['aut']) ) {
			return get_post($_GET['sce'])->post_title;
		}
	}

	public function get_option_staff() {
		
	}

}

