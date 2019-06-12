<section class="booking-step second-booking-step-section">
	<div class="container">
		<div class="row step-block">
			<div class="col-12">
				<span class="booking-title">Planificateur de rendez-vous</span>
			</div>
			<div class="col-4 first">
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
			<div class="col-4 second">
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
			<div class="col-4 third">
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
		</div>
		<div class="row">
			<div class="col-12">
				<a href="#" class="retour-link"><i class="fas fa-caret-left"></i> Retour</a>
				<h1 class="booking-section-title order-title">Vérifiez vos coordonnées</h1>
			</div>
			<div class="col-12 d-flex order-block">
				<div class="order-box">
					<h3>Détails de l'horaire</h3>
					<div class="order-info">
						<ul>
							<li>Service: <span>{!! get_the_title($_GET['sce']) !!}</span></li>
							<li>Staff: <span>{!! get_the_title($_GET['stf']) !!}</span></li>
							<li>Date: <span>{!! $_GET['dat'] !!}</span></li>
							<li>Time: <span>{!! $_GET['time'] !!}</span></li>
							<li>Duration: <span>{!! $_GET['drtn'] !!}m</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="user-info-form-block">
					<h1 class="booking-section-title form-title">Veuillez nous fournir vos coordonnées</h1>
					<form action="" id="user-info" class="form-block">
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
					<a href="#" class="make-order">Make an order</a>
				</div>
			</div>
		</div>
	</div>
</section>
