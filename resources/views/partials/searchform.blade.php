{{-- <form role="search" method="get" class="search-form" action="{{ esc_url( home_url( '/' ) ) }}">
	<input type="hidden" name="post_type" value="salons"/>
	<label>
		<span class="screen-reader-text">{{ _x( 'Search for:', 'label' ) }}</span>
		<input type="search" class="search-field" placeholder="{!! esc_attr_x( 'Search &hellip;', 'placeholder' ) !!}" value="{{ get_search_query() }}" name="s" />
	</label>
	<input type="submit" class="search-submit" value="{{ esc_attr_x( 'Search', 'submit button' ) }}" />
</form> --}}
<div class="front-page-search">
	<form role="search" method="post" id="search-form" action="">
		<input type="hidden" id="post_type" name="post_type" value="salons"/>
		<div class="form-box">
			<input type="text" name="name" id="name" value="{{ get_search_query() }}" placeholder="{!! esc_attr_x( 'Search &hellip;', 'placeholder' ) !!}" autocomplete="off">
		</div>
		<div class="form-box">
			<input type="text" name="address" id="address" placeholder="Ville, adresse" autocomplete="off">
		</div>
		<div class="form-box select-box">
			<div id="current_option type" class="current_option" data-value="">
				<input type="hidden" class="current_option_type" name="data-type" value="">
				<span>
					<input type="text" name="type" placeholder="Que souhaitez-vous réserver ?" autocomplete="off" class="input-select search-select-input" id="category">
				</span>
			</div>
			<ul class="search-select" id="custom_options">
				@foreach ($wp_dropdown_categories_list as $elements)
					{!! $elements !!}
				@endforeach
			</ul>
		</div>
		<button type="submit" class="search-btn" form="search-form">
			<img src="@asset('images/search-icon.png')" alt="">
		</button>
	</form>
</div>