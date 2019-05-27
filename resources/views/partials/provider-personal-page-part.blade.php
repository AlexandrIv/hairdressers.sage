  <section class="personal-provider-section">
  	<div class="container">
  		<div class="row">
  			<div class="col-12">

          <div class="partner-admin-page-block">
            <h3>Hello {!! $current_user['user_firstname'] !!}</h3>
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Abonnement</a>
              </li>
              <li class="nav-item">
                <a class="nav-link salon-info-tab" data-post-id="{!! $get_salon_info['ID'] !!}" data-toggle="tab" href="#tab2">À propos du Salon</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab3">Ajouter des services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab4">Ajouter des employées</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab5">Mes Réservations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab6">Service de réservation</a>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane container active" id="tab1">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa quis autem eum molestiae sit, dolorum corporis vero fuga ut atque illo qui accusantium assumenda laborum praesentium dolore voluptate aperiam ad, blanditiis recusandae perferendis iusto beatae? Tenetur ab veniam fugiat, omnis corrupti hic eum quisquam. Voluptate, repellat explicabo iste est. Adipisci, atque! Sapiente placeat rerum ad magnam quidem, officiis excepturi explicabo itaque provident exercitationem porro autem ea dolores perspiciatis mollitia laborum! Tempore dolorum totam, placeat, quod vero ipsa qui facilis nulla earum eaque praesentium itaque. Dignissimos error modi esse repudiandae molestiae blanditiis sit nemo saepe, nobis numquam cumque quisquam tempore laboriosam ipsum sed accusantium impedit consequatur asperiores excepturi, totam quae dolorem quia beatae corporis. Repellendus, sed veritatis nisi praesentium dolore eius nam, similique aut autem vitae vero hic, fugit minus totam libero ut. Dolorum hic sapiente aspernatur amet, est velit fugit saepe eum non, minus esse vero excepturi quidem sequi ipsam quo. Officiis corrupti, hic quaerat nobis facere dolore atque molestias blanditiis itaque nam possimus vel eum corporis iure maiores saepe ratione suscipit facilis in obcaecati cumque culpa voluptate labore! Corporis magni ea ab expedita optio amet, itaque reiciendis minus tenetur, accusantium perferendis at, et iste. Voluptatum dolore eaque velit quas!</p>
              </div>


              <div class="tab-pane container fade" id="tab2">
                <div class="salon-info">

                  <form id="salon-form">
                    <input type="hidden" name="action" value="salon_form">
                    <input type="hidden" name="post_id" value="{!! $get_salon_info['ID'] !!}">
                    <label class="box" for="salon-name"><span>Le nom du Salon:</span>
                      <input type="text" name="salon_name" id="salon-name" value="{!! $get_salon_info['name'] !!}">
                    </label>
                    <label class="box radio"><span>Sélectionnez le type de service:</span>
                      @foreach ($get_salon_info['category'] as $key => $category)
                      <label for="{!! $category->slug !!}">
                        <input type="checkbox" name="salon-category[]" value="{!! $category->term_id !!}" id="{!! $category->slug !!}" @foreach ($get_salon_info['category_checked'] as $term) @if($term->slug == $category->slug){!! 'checked' !!}@endif @endforeach>
                        <span>{!! $category->name !!}</span>
                      </label>
                      @endforeach
                    </label>
                    <label class="box" for="address"><span>Votre adresse:</span>
                      <input type="text" name="address" id="address" value="{!! $get_salon_info['address'] !!}">
                    </label>
                    <label class="box" for="description"><span>Décrivez votre salon (visible aux clients):</span>
                      <textarea name="description" id="description" rows="10">{!! $get_salon_info['description'] !!}</textarea>
                    </label>
                    <label><span>Select working days:</span></label>
                    <div class="row working-days">
                      <div class="col-12">
                        @foreach ($working_day as $element)
                         {!! $element !!}
                        @endforeach
                      </div>
                    </div>
                    <label class="box" for="images"><span>Upload images of your salon:</span>
                      <input type="file" name="upload_attachment[]" class="images" id="images" size="50" multiple="multiple" />
                    </label>
                    <div class="row upload-images"></div>
                    <label class="salon-save-form">
                      <input type="submit" name="salon-save-form" class="button-salon-save-form" id="salon-save-form" value="Save" form="salon-form">
                    </label>

                  </form>
                  

                  
                  <div id="status"></div>



                </div>
              </div>


              <div class="tab-pane container fade" id="tab3">...</div>
              <div class="tab-pane container fade" id="tab4">...</div>
              <div class="tab-pane container fade" id="tab5">...</div>
              <div class="tab-pane container fade" id="tab6">...</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>