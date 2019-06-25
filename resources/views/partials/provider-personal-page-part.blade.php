  <section class="personal-provider-section">
  	<div class="container">
  		<div class="row">
  			<div class="col-12">
          <div class="partner-admin-page-block">
            <h3>Hello {!! $current_user['user_firstname'] !!}</h3>
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab1">Abonnement</a>
              </li>
              <li class="nav-item">
                <a class="nav-link salon-info-tab" data-post-id="{!! $get_salon_info['ID'] !!}" data-toggle="tab" href="#tab2">À propos du Salon</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active service-tab" data-author-id="{!! $get_salon_info['user-id'] !!}" data-toggle="tab" href="#tab3">Ajouter des services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link calendar-tab" data-toggle="tab" href="#tab4">Mes Réservations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link reservation-tab" data-toggle="tab" href="#tab5">Service de réservation</a>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane container" id="tab1">
                @include('admin.tabs.order-tab-part')
              </div>
              <div class="tab-pane container fade" id="tab2">
                @include('admin.tabs.salon-info-tab-part')
              </div>
              <div class="tab-pane container active" id="tab3">
                @include('admin.tabs.staff-service-tab-part')
              </div>
              <div class="tab-pane container fade" id="tab4">
                @include('admin.tabs.evant-calendar-tab-part')
              </div>
              <div class="tab-pane container fade reservation-tab-pane" id="tab5">
                @include('admin.tabs.reservation-tab-part')                                
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>