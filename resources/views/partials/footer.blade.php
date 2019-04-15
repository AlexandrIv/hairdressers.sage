<footer style="{!! $footer_setting !!}">
	<div class="container h-100 w-100">
		<div class="row h-100 justify-content-center align-items-center">
			<div class="col-9">
				<div class="contact align-items-center">
					<span class="copy">Clock Hair © 2018</span>
					@if (has_nav_menu('footer_left_menu'))
						{!! wp_nav_menu(['theme_location' => 'footer_left_menu']) !!}
					@endif
				</div>
			</div>
			<div class="col-3">
				<div class="contact-btn align-items-center justify-content-end" style="color: red!important;">
					@if (has_nav_menu('footer_right_menu'))
						{!! wp_nav_menu(['theme_location' => 'footer_right_menu']) !!}
					@endif
				</div>
			</div>
		</div>
	</div>
</footer>