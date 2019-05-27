<div class="row">
	<div class="search-article col-sm-12 col-md-12 col-lg-7 col-xl-7">
		@php $postArray = [] @endphp
		@foreach ($posts['posts'] as $element)
		@php $postArray[] = $element @endphp
		<article class="article-test" id="post-id-{!! $element->ID !!}">
			<div class="row h-100">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					<a href="{!! get_the_permalink( $element ) !!}" class="box-img">
						<img src="{!! $element->post_gallery[0]['url'] !!}" alt="">
					</a>	
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 pt-sm-3 pb-sm-3">
					<div class="article-info">
						<a href="{!! get_the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
						<span class="address">{!! $element->address !!}</span>
						<span class="stars"></span>
						<a href="{!! get_the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
					</div>
				</div>
			</div>
		</article>
		@endforeach
		<script type="text/javascript">
			window.postJson = '{!! json_encode($postArray) !!}';
		</script>
		@if ( (int)$query->max_num_pages > 1 )
		<script type="text/javascript">
			window.query_vars = '{!! serialize($query->query_vars) !!}'; 
			window.paged = '{!! ( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1; !!}';
			window.max_pages = '{!! $query->max_num_pages !!}';
		</script>
		<div class="loadmore-btn-block">
			<span class="true_loadmore">
				<i class="fa fa-spinner"></i> Loading
			</span>
		</div>
		<div class="loadmore-block" style="display: none;"></div>
		@endif
	</div>
	<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
		<div class="maps" id="maps">
			<div id="mapHome" style="width: 100%; height: 500px;"></div>
		</div>
	</div>
</div>


{{-- <div class="row">
	@if ( $posts['posts'] )
	<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
		<div class="article-row-results">
			@php
			$postArray = [];
			@endphp
			@foreach ($posts['posts'] as $key => $element)
			@if ( $element->lat && $element->lng )
			@php
			$postArray[] = $element;
			@endphp
			@endif
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
							<a href="{!! get_the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
							<span class="address">{!! $element->address !!}</span>
							<span class="stars"></span>
							<a href="{!! get_the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
						</div>
					</div>
				</div>
			</article>
			@endforeach
			@if ( (int)$query->max_num_pages > 1 )
			<script>
				window.query_vars = '{!! serialize($query->query_vars) !!}'; 
				window.paged = '{!! ( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1; !!}';
				window.max_pages = '{!! $query->max_num_pages !!}';
				window.postJson = '{!! json_encode($postArray) !!}';
			</script>
			<div class="true_loadmore">Loadmore</div>
			@endif
		</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
		<div class="maps" id="maps">
			<div id="map" style="width: 100%; height: 500px;"></div>
		</div>
	</div>
	@endif
</div> --}}
