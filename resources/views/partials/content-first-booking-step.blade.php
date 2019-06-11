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
					<form action="">
						@if ( isset($_GET['sce']) && isset($_GET['stf']) && isset($_GET['aut']) )
						<input type="text" name="service" class="service" data-service-id="{!! $get_service['ID'] !!}" value="{!! $get_service['name'] !!}" readonly>
						<select class="select-box select-custom staff-select" placeholder="Staff">
							{!! $get_option_staff !!}
						</select>
						@else
						<select class="select-box select-custom service-select" placeholder="Services">
							{!! $get_option_service !!}
						</select>
						<select class="select-box select-custom staff-select" placeholder="Staff"></select>
						@endif
						<div class="select-box date-select">
							<input type="text" class="select-date-input" placeholder="Date" readonly />
						</div>
					</form>
					<a href="#" class="search-time-button" data-salon-id="{!! $_GET['stf'] !!}">Vérifier copy</a>
				</div>
				<div class="free-times">
					<h3 class="staff-name">Olya</h3>
					<ul class="list-times"></ul>
				</div>
			</div>
		</div>
	</div>
</section>
