{{-- <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
	<div class="row">
		@foreach ($post_array as $element)
		<div class="col-12">
			<article>
				<div class="image-box">
					<a href="{!! the_permalink( $element ) !!}">
						{!! get_the_post_thumbnail($element->ID) !!}
					</a>
				</div>
				<div class="article-info">
					<a href="{!! the_permalink( $element ) !!}" class="title">{{ $element->post_title }}</a>
					<span class="address">{{ get_field('address', $element->ID)['address'] }}</span>
					<span class="stars"></span>
					<a href="{!! the_permalink( $element ) !!}" class="link-post">Prendre rdv</a>
				</div>
			</article>	
		</div>
		@endforeach	
	</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
	<h4>Sidebar</h4>
</div> --}}

<pre style="color: #fff;">
	@php
		var_dump($post_array);
	@endphp
</pre>