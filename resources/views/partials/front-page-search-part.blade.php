<div class="front-page-search">
	<form action="">
		<div class="form-box">
			<input type="text" name="name" placeholder="Nom du salon, institut" autocomplete="off">
		</div>
		<div class="form-box">
			<input type="text" name="name" placeholder="Ville, adresse" autocomplete="off">
		</div>
		<div class="form-box select-box">
			<div id="current_option" data-value="">
				<span><input type="text" name="type" placeholder="Que souhaitez-vous réserver ?" autocomplete="off" class="input-select search-select-input"></span>
			</div>
			<ul class="search-select" id="custom_options">
				<li data-value="coiffeurs">Coiffeurs</li>
				<li data-value="barbiers">Barbiers</li>
			</ul>
		</div>
		<a href="#" class="search-btn"><img src="@asset('images/search-icon.png')" alt=""></a>
	</form>
</div>