@foreach ($post_array as $element)
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