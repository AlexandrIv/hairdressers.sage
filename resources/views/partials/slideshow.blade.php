<div class="slideshow">
	<div class="slider single-item">
		@foreach ($slideshow as $slide)
		<div class="slide" style="background-image: url('{{ $slide['image'] }}');">
			<div class="bg-slide"></div>
			<div class="slide-title">
				<h3>{{ $slide['title'] }}</h3>
			</div>
		</div>
		@endforeach
	</div>
	@include('partials.searchform')
</div>