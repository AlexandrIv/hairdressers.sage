<section class="booking-step second-booking-step-section">
	<div class="container">
		<div class="row">
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
		<div class="row">
			<div class="col-12">
				<form action="">
					
				</form>
				<a href="#" class="make-order">Make an order</a>
			</div>
		</div>
	</div>
</section>
