<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
	<div class="row">
		@if ( $post_array )
		@php
			$coordinateArray = [];
		@endphp
			@foreach ($post_array as $key => $element)
			@php
				$coordinateArray[$key]['lat'] = $element->lat;
				$coordinateArray[$key]['lng'] = $element->lng;
			@endphp
			<div class="col-12">
				<article>
					<div class="image-box">
						<a href="{!! the_permalink( $element ) !!}">
							{!! get_the_post_thumbnail($element->ID) !!}
						</a>
					</div>
					<div class="article-info">
						<a href="{!! the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
						<span class="address">{!! $element->address !!}</span>
						<span class="stars"></span>
						<a href="{!! the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
					</div>
				</article>	
			</div>
			@endforeach
			<script type="text/javascript">
				window.coordinateArray = '{!! json_encode($coordinateArray) !!}';
			</script>
		@else
			<h3>Салонов не найдено!!!</h3>
		@endif
	</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
	<h4>Sidebar</h4>
	<div id="map" style="width: 100%; height: 500px;"></div>
</div>


