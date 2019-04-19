<section class="content-register-partner" id="page-{{ the_ID() }}">
	<div class="page-image" style="background-image: url('{!! $page_image !!}');">
		<div class="bg-opacity"></div>
		<h3 class="page-title">{!! $page_title !!}</h3>
	</div>
	<div class="register-partner-form-block">
		<div class="container">
			<div class="row register-partner-block-row">
				<div class="col-12">
					<div class="register-partner-form">
						<div class="pricing-plans">
							<div class="row">
								<div class="col-12">
									<h4 class="plans-title">Différentes options d'abonnement à choisir</h4>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
									<div class="plan">
										<span class="plan-title">Basic</span>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed itaque, modi consequuntur distinctio minima similique quibusdam deleniti laudantium ea dolore. Ab deserunt neque dignissimos velit dolorum nesciunt aliquid veniam enim?</p>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
									<div class="plan">
										<span class="plan-title">Premium</span>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, laborum. Maxime consectetur accusantium eveniet, magnam tempore at assumenda. Debitis impedit illo voluptates aliquid, corporis nam dolor harum repudiandae fugit doloremque.</p>
									</div>
								</div>
								<div class="col-12">
									<div class="form-block" id="form-block">
										<form id="register-partner-form">
											<input type="hidden" name="action" value="register_partner_form">
											<div class="box">
												<label>Nom et prénom du propriétaire *
													<input type="name" name="name">
												</label>
												<label>Nom de l’institut *
													<input type="name" name="salonname">
												</label>
											</div>
											<div class="box">
												<label>Login *
													<input type="name" name="login">
												</label>
												<label>Votre E-mail *
													<input type="name" name="email">
												</label>
											</div>
											<div class="box">
												<label>Téléphone *
													<input type="name" name="phone" placeholder="+41">
												</label>
												<label>Le type d'établissement *												
													<input type="text" name="type" class="input-select-type" data-value="" readonly>
													<ul class="link-list">
														<li><a data-type="barbier" href="#">Barbier</a></li>
														<li><a data-type="coiffeur" href="#">Coiffeur</a></li>
														<li><a data-type="barbier&coiffeur" href="#">Barbier & Coiffeur</a></li>
													</ul>
												</label>
											</div>
											<div class="box textarea-box">
												<label> Message
													<textarea placeholder="Tapez votre message..." rows="7" name="message"></textarea>
												</label>
											</div>
											<div class="partner-save-form">
												<input type="submit" name="register-partner-forms" class="button-form" id="register-partner-form" value="Envoyer" form="register-partner-form">
											</div>
										</form>
									</div>
								</div>
								<div class="col-12">
									<div class="buttons">
										<a href="#">Retour</a>
										<a href="#">Inscription</a>
									</div>
								</div>
							</div>
						</div>
						<div class="succes-register">
							<div class="buttons-before">
								<a href="{{ home_url() }}">Retour</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



