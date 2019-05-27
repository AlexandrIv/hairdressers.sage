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
@if ( (int)$query->max_num_pages > 1 )
<script type="text/javascript">
	window.query_vars = '{!! serialize($query->query_vars) !!}'; 
	window.paged = '{!! ( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1; !!}';
	window.max_pages = '{!! $query->max_num_pages !!}';
	window.postJsonAjax = '{!! json_encode($postArray) !!}';
</script>
@endif
