<div class="search-article col-sm-12 col-md-12 col-lg-7 col-xl-7">
	@php $postArray = [] @endphp
	@foreach ($get_category_posts['posts'] as $element)
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
	@if ( $get_category_posts['posts'] )
	<script type="text/javascript">
		jQuery(document).ready(function($){
			window.postJsonCategory = '{!! json_encode($postArray) !!}';
		});
	</script>
	@endif
</div>
<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
	<div class="maps" id="maps">
		<div id="mapCategory" style="width: 100%; height: 500px;"></div>
	</div>
</div>
