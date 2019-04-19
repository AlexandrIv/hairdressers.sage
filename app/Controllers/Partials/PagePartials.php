<?php

namespace App\Controllers\Partials;

trait PagePartials
{
	public function page_image() {
		$page_image = get_field('page_image', get_the_ID());
		return $page_image;
	}
	public function page_title() {
		$page_title = get_field('page_title', get_the_ID());
		return $page_title;
	}


}