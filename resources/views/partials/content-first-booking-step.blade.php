<section class="booking-step first-booking-step-section" id="first-booking-step">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<span class="booking-title">Planificateur de rendez-vous</span>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 first">
				<div class="step-box">
					<div class="step-count">
						<span>1</span>
					</div>
					<div class="step-info">
						<span class="step-title">Sélectionnez Service / Date</span>
						<span class="step-description">Veuillez choisir le service avec votre temps opportun.</span>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 second">
				<div class="step-box">
					<div class="step-count">
						<span>2</span>
					</div>
					<div class="step-info">
						<span class="step-title">Remplir les détails de contact</span>
						<span class="step-description">S'il vous plaît remplir vos coordonnées ici.</span>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 third">
				<div class="step-box">
					<div class="step-count">
						<span>3</span>
					</div>
					<div class="step-info">
						<span class="step-title">Confirmation</span>
						<span class="step-description">Votre rendez-vous est confirmé avec nous.</span>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="booking-form">
					<span class="form-title">Please choose your convenient time</span>
					<h3>{!! $get_option_service !!}</h3>
					<form action="">
						@if ($get_option_service)
						<select class="select-box select-custom service-select" placeholder="Services">
							<option>Serv 1</option>
							<option>Serv 2</option>
							<option>Serv 3</option>
							<option>Serv 4</option>
							<option>Serv 5</option>
						</select>
						@else
						<input type="text" name="service" class="service" value="{!! $get_service !!}">
						@endif
						
						<select class="select-box select-custom staff-select" placeholder="Staff">
							<option>Staff 1</option>
							<option>Staff 2</option>
							<option>Staff 3</option>
							<option>Staff 4</option>
							<option>Staff 5</option>
						</select>
						{{-- <div class="form-box service-name custom-form-select">
							<span>
								<input type="text" name="service-name" id="service-name" class="service-input" placeholder="Service" autocomplete="off" readonly>
								<i class="fas fa-chevron-down"></i>
							</span>
							<ul class="service-name-list">
								<li><a href="#">Serv 1</a></li>
								<li><a href="#">Serv 2</a></li>
								<li><a href="#">Serv 3</a></li>
								<li><a href="#">Serv 4</a></li>
							</ul>
						</div>
						<div class="form-box staff-name custom-form-select">
							<span>
								<input type="text" name="staff-name" id="staff- name" class="staff-input" placeholder="Staff" autocomplete="off" readonly>
								<i class="fas fa-chevron-down"></i>
							</span>
							<ul class="staff-name-list">
								<li><a href="#">Staff 1</a></li>
								<li><a href="#">Staff 2</a></li>
								<li><a href="#">Staff 3</a></li>
								<li><a href="#">Staff 4</a></li>
							</ul>
						</div> --}}
						<div class="select-box date-select">
							<input type="text" class="select-date-input" placeholder="Date" readonly />
						</div>
					</form>
					<a href="#" class="search-time-button">Vérifier copy</a>
				</div>
			</div>
		</div>
	</div>
</section>
