<header class="header {!! $header_type !!}" style="{!! $header_background !!}">
	<div class="container h-100">
		<div class="row h-100 align-items-center">
			<nav class="navbar navbar-expand-lg navbar-light h-100 w-100">
				{!! $logo_type !!}
				<button class="navbar-toggler menu-btn" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end" id="navbarText">
					<div class="nav-primary">
						<ul class="navbar-nav mr-auto">
							@if (has_nav_menu('header_navigation'))
							{!! wp_nav_menu(['theme_location' => 'header_navigation', 'menu_class' => 'desknav']) !!}
							@endif
						</ul>
					</div>
				</div>
			</nav> 
		</div>
	</div>
</header>






