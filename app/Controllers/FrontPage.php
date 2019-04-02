<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{	
	private static $redux_demo;
	public function __construct() {
		global $redux_demo;
		self::$redux_demo = $redux_demo;
	}
	public static function logotype() {
		$logotype = self::$redux_demo['opt-switch'];
		if( $logotype == 1 ) {
			$logo = '<a class="navbar-brand" href='.home_url('/').'>'.self::$redux_demo['opt-logo-text'].'</a>';
		}else {
			$logo = '<a class="navbar-brand" href='.home_url('/').'><img src="'.self::$redux_demo['opt-logo-image']['url'].'" alt=""></a>' ;
		}  
		echo $logo;
	}
	public static function headerbackground() {
		$hbcg = self::$redux_demo['opt-header-background'];
		$hop = self::$redux_demo['opt-header-opacity'];
		$headerbackground = 'background-color: '.$hbcg.'; opacity: '.$hop.';';
		return $headerbackground;
	}
	public static function headerpage() {
		$hp = self::$redux_demo['opt-header-pages'];
		foreach ($hp as $key => $value) {
			$nav = '<li class="nav-item"><a class="nav-link" href="'.get_permalink($value).'">'.get_the_title($value).'</a></li>';
			echo $nav;
		}
	}
	public static function slideshow() {
		$slides = self::$redux_demo['opt-home-page-slidshow'];
		return $slides;
	}
}
