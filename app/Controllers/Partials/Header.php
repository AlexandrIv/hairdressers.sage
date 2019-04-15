<?php

namespace App\Controllers\Partials;

trait Header
{
	public function header_type() {
		$headerType = self::$redux_demo['opt-header-type-switch'];
		( $headerType ) ? $headerType = '' : $headerType = 'fixed';
		return $headerType;
	}
	public function logo_type() {
		$logotype = self::$redux_demo['opt-switch'];
		if( $logotype == 1 ) {
			return '<a class="navbar-brand" href='.home_url('/').'>'.self::$redux_demo['opt-logo-text'].'</a>';
		}else {
			return '<a class="navbar-brand" href='.home_url('/').'><img src="'.self::$redux_demo['opt-logo-image']['url'].'" alt=""></a>' ;
		}
	}
	public function header_background() {
		$hbcg = self::$redux_demo['opt-header-background'];
		$hop = self::$redux_demo['opt-header-opacity'];
		$headerbackground = 'background-color: '.$hbcg.'; opacity: '.$hop.';';
		return $headerbackground;
	}
	
}