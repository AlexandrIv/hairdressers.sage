<?php

namespace App\Controllers\Partials;

trait Footer
{
	public function footer_setting() {
		$footerBackground = self::$redux_demo['opt-footer-background'];
		$footerBackground = 'background-color: '.$footerBackground.';';
		return $footerBackground;
	}
}