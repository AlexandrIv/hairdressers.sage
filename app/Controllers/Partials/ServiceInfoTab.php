<?php

namespace App\Controllers\Partials;
use WP_Query;

trait ServiceInfoTab
{
	public function duration() {
		for ( $i = 0; $i < 3; $i++ ) :
			for ( $j = 30; $j <= 60; $j += 30 ) :
				$duration = ( $i * 3600 ) + ( $j * 60 );
				$hour = date("H:i", $duration);
				$time .= "<li data-duration='{$duration}'>{$hour}</li>";
			endfor;
		endfor;
		return $time;
	}
}