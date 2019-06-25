<div class="reservation-info">
	<div class="info-box">
		<h3>Détails de l'horaire</h3>
		<ul>
			<li>Service: <span>{!! $orderData['service_name'] !!}</span></li>
			<li>Staff: <span>{!! $orderData['staff_name'] !!}</span></li>
			<li>Date: <span>{!! $orderData['date'] !!}</span></li>
			<li>Time: <span>{!! $orderData['time'] !!}</span></li>
			<li>Duration: <span>{!! $orderData['duration'] !!}</span></li>
		</ul>
	</div>
	<div class="info-box">
		<h3>Détails de l'horaire</h3>
		<ul>
			<li>Nom: <span>{!! $userData['name'] !!}</span></li>
			<li>Prénom: <span>{!! $userData['surname'] !!}</span></li>
			<li>Téléphone: <span>{!! $userData['email'] !!}</span></li>
			<li>E-mail: <span>{!! $userData['phone'] !!}</span></li>
		</ul>
	</div>
</div>