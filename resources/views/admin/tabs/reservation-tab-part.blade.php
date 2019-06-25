<div class="select-from">
	<select class="select-box select-custom service-select" placeholder="Services">
		{!! $get_services_opt !!}
	</select>
	<select class="select-box select-custom staff-select" placeholder="Staff"></select>
	<div class="select-box date-select">
		<input type="text" class="select-date-input select-date" placeholder="Date" readonly />
	</div>
</div>
<div class="free-times">
	<h3 class="staff-name"></h3>
	<ul class="list-times-reserv"></ul>
</div>
<div class="user-info-reserv">
	<form action="" id="user-info-reserv" class="form-reserv">
		<div class="box">
			<label><span>Votre prénom</span>
				<input type="text" name="name" class="name" placeholder="An">
			</label>
			<label><span>Votre nom</span>
				<input type="text" name="surname" class="surname" placeholder="Tapez votre nom">
			</label>
		</div>
		<div class="box">
			<label><span>E-mail</span>
				<input type="email" name="email" class="email" placeholder="Tapez votre e-mail">
			</label>
			<label><span>Téléphone</span>
				<input type="tel" name="phone" class="phone" placeholder="Tapez votre téléphone">
			</label>
		</div>
	</form>
	<div class="order-info"></div>
	<a href="#" class="make-order-reserv">Reservation an order</a>
</div>
