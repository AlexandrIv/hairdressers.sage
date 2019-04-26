<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
	<div class="row article-row">
		@if ( $post_array )
		<input type="hidden" name="paged" id="paged" value="{!! $post_array['paged'] !!}">
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
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="image-box">
							<div class="slider single-post-item">
								@foreach ($element->post_gallery as $gallery)
								<img src="{!! $gallery['url'] !!}" alt="">
								@endforeach
							</div>	
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="article-info">
							<a href="{!! the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
							<span class="address">{!! $element->address !!}</span>
							<span class="stars"></span>
							<a href="{!! the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
						</div>
					</div>
				</div>
			</article>
		</div>
		@endforeach
		@else
		<h3>Салонов не найдено!!!</h3>
		@endif

		{{-- <pre style="color: #fff;">
			@php
				var_dump();
			@endphp
		</pre> --}}

		@if ( (int)$post_array['wp_query']->max_num_pages > 1 )
			<script id="true_loadmore">
				window.true_posts = '{!! serialize($post_array['wp_query']->query_vars) !!}'; 
				window.current_page = '{!! ( $post_array['wp_query']->query_vars['paged'] ) ? $post_array['wp_query']->query_vars['paged'] : 1; !!}';
			</script>
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