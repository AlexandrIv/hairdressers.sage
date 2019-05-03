{{-- <pre style="color: #fff;">
	@php
	var_dump($query->query_vars);
	@endphp
</pre>
@php
die;
@endphp --}}

<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
	<div class="row article-row-results">
		@foreach ($query->posts as $element)
		<pre>
			@php
				var_dump($element->post_title);
			@endphp
		</pre>
		{{-- <article class="article-post-result" id="article-post-result" data-article-id="{!! $element->ID !!}">
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
						<a href="{!! get_the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
						<span class="address">{!! $element->address !!}</span>
						<span class="stars"></span>
						<a href="{!! get_the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
					</div>
				</div>
			</div>
		</article> --}}
		@endforeach
		@if ( (int)$query->max_num_pages > 1 )
		<a href="#" class="loadmore">Loadmore</a>
		<script id="true_loadmore">
			window.query = '{!! serialize($query->query_vars) !!}'; 
			window.paged = '{!! ( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1; !!}';
		</script>
		@endif











			{{-- @if ( $post_array['posts'] )
				<input type="hidden" name="paged" id="paged" value="{!! $post_array['paged'] !!}">
			@php
			$coordinateArray = [];
			$postArray = [];
			@endphp
			@foreach ($post_array['posts'] as $key => $element)
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
			
			@endforeach
			@if ( (int)$post_array['max_num_pages'] > 1 )
			<script id="true_loadmore">
				window.query = '{!! serialize($post_array['query_vars']) !!}'; 
				window.paged = '{!! ( $post_array['query_vars_paged'] ) ? $post_array['query_vars_paged'] : 1; !!}';
			</script>
			@endif
			@else
			<h3>Салонов не найдено!!!</h3>
			@endif --}}
		</div>
	</div>


	{{-- @if ( (int)$post_array['max_num_pages'] > 1 )
	<script id="true_loadmore">
		window.query = '{!! serialize($post_array['query_vars']) !!}'; 
		window.paged = '{!! ( $post_array['query_vars_paged'] ) ? $post_array['query_vars_paged'] : 1; !!}';
	</script>
	@endif --}}

	

	{{-- @if ( $post_array['posts'] )
	<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
		<div class="map-results"></div>
		<div class="maps" id="maps">
			<div id="map" style="width: 100%; height: 500px;"></div>
		</div>
	</div>
	@endif --}}
