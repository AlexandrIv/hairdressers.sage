<?php

namespace App\Controllers\Partials;
use WP_Query;

trait SalonInfoTab
{
	public function duration() {
		$current = array_key_exists('duration', $info) ? $info['duration'] : "";
		for ( $i = 0; $i < 3; $i++ ) :
			for ( $j = 30; $j <= 60; $j += 30 ) :
				$duration = ( $i * 3600 ) + ( $j * 60 );
				$duration_output = trendsalon_durationtostring( $duration );
				$selected = $current == $duration ? ' selected="selected"' : '';
				echo "<option value='{$duration}' {$selected}>{$duration_output}</option>";
			endfor;
		endfor;
	}
}