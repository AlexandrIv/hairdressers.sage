<section>
	<div class="front-page-category" id="scrollTop">
		<div class="container search-result">
			<div class="row">
				<div class="col-12">
					<div class="section-title">
						<h3>{!! $categories_section_title !!}</h3>
					</div>
				</div>
				@foreach( $inferred_categories as $category )
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<a href="{{ get_category_link($category['ID']) }}">
						<div class="category-cart" id="cat-{{ $category['ID'] }}">
							<div class="front" style="background: linear-gradient( {{ $category['before_bacground'] }}, {{ $category['before_bacground'] }}), url({{ $category['images'] }}) round;">
								<div class="cat-info-front">
									<h4 style="color: {{ $category['text_color'] }};">{{ $category['name'] }}</h4>
								</div>
							</div>
							<div class="back" style="background: linear-gradient( {{ $category['after_bacground'] }}, {{ $category['after_bacground'] }}), url({{ $category['images'] }}) round;">
								<div class="cat-info-back">
									<h4 style="color: {{ $category['text_color'] }};">{{ $category['name'] }}</h4>
									<span style="color: {{ $category['text_color'] }};" class="desc">{{ $category['description'] }}</span>
								</div>	
								<span class="top-bottom"></span>
								<span class="left-right"></span>
							</div>
						</div>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>











