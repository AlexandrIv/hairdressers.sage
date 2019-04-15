<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
	<div class="row">
		@if ( $post_array )
		@php
			$coordinateArray = [];
			$postArray = [];
		@endphp
			@foreach ($post_array as $key => $element)
			@if ( $element->lat && $element->lng )
				@php
					$coordinateArray[$key]['lat'] = $element->lat;
					$coordinateArray[$key]['lng'] = $element->lng;
					$postArray[$key] = $element;
				@endphp
				<script type="text/javascript">
					window.coordinateArray = '{!! json_encode($coordinateArray) !!}';
					window.postArray = '{!! json_encode($postArray) !!}';
				</script>
			@endif
			<div class="col-12">
				<article class="article-post-result" id="article-post-result" data-article-id="{!! $element->ID !!}">
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
		@else
			<h3>Салонов не найдено!!!</h3>
		@endif
	</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
	<div class="maps" id="maps">
		@if ( $post_array ) 
			<div id="map" style="width: 100%; height: 500px;"></div>
		@endif
	</div>
</div>


