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
	public function slideshow() {
		$slides = self::$redux_demo['opt-home-page-slidshow'];
		return $slides;
	}
	public function categories_section_title() {
		return get_field( 'category_title',  get_option('page_on_front') );
	}
	public function inferred_categories( $page_id = null ) {
		( $page_id ) ? $page_id = $page_id : $page_id = get_option('page_on_front');
		$selectedCategories = get_field( 'select_categories', $page_id );
		$array = [];
		foreach ($selectedCategories as $key => $category) {
			$color_before = get_field( 'background_color_before', $category );
			$opacity_before = get_field( 'opacity_background_before', $category );
			$color_after = get_field( 'background_color_after', $category );
			$opacity_after = get_field( 'opacity_background_after', $category );
			$array[$key]['ID'] = $category->term_id;
			$array[$key]['name'] = $category->name;
			$array[$key]['description'] = $category->description;
			$array[$key]['images'] = get_field('category_image', $category);
			$array[$key]['text_color'] = get_field('text_color', $category);;
			$array[$key]['before_bacground'] = ( $color_before && $opacity_before ) ? self::hex2rgba($color_before, $opacity_before) : self::hex2rgba('#000', 0.4);
			$array[$key]['after_bacground'] = ( $color_after && $opacity_after ) ? self::hex2rgba($color_after, $opacity_after) : self::hex2rgba('#a26a0a', 0.4);
		}
		return $array;
	}
	private function hex2rgba( $color, $opacity = false ) {
		$default = 'rgb(0,0,0)';
		if(empty($color))
			return $default; 
		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}
		if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}
		$rgb =  array_map('hexdec', $hex);
		if($opacity){
			if(abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}
		return $output;
	}
	public function info_section_front_page( $page_id = null ) {
		( $page_id ) ? $page_id = $page_id : $page_id = get_option('page_on_front');
		$infoArray['title'] = get_field( 'info_title', $page_id );
		$infoArray['description'] = get_field( 'info_description', $page_id );
		return $infoArray;
	}

	public function footer_setting() {
		$footerBackground = self::$redux_demo['opt-footer-background'];
		$footerBackground = 'background-color: '.$footerBackground.';';
		return $footerBackground;
	}

	public function wp_dropdown_categories_list() {
		$args = array(
			'post_type'	=> 'salons',
			'taxonomy' 	=> 'categories-salon'
		);
		$categories = get_categories( $args );
		$link_category = [];
		foreach( $categories as $key => $category ) {
			$link_category[$key] = '<li data-value="' . $category->term_id . '">' . $category->name . '</li>';
		}
		return $link_category;
	}
	


}
