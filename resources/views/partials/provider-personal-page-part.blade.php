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
                <a class="nav-link active" data-toggle="tab" href="#tab3">Ajouter des services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab4">Mes Réservations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab5">Service de réservation</a>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane container" id="tab1">
                {{-- TAB-1 --}}
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
              <div class="tab-pane container active" id="tab3">
                <div class="service-info">
                  <div class="service-add-block">
                    <div class="container">
                      <div class="row pb-5">
                        <div class="col-4">
                          <h4>Add services</h4>
                          <form id="service-form">
                            <div class="form-box service-category custom-form-select">
                              <label for="service-category">Select service category:</label>
                              <span>
                                <input type="text" name="service-category" id="service-category" class="category-input" placeholder="Femme" autocomplete="off">
                              </span>
                              <ul class="category-list">
                                <li data-category-id="74">Femme</li>
                                <li data-category-id="24">Homme</li>
                                <li data-category-id="13">Technique</li>
                                <li data-category-id="56">Enfant (jusqu`à 10 ans)</li>
                              </ul>
                            </div>
                            <div class="form-box service-name custom-form-input">
                              <label class="service-name" for="service-name">Input service name:</label>
                              <span><input type="text" name="service-name" id="service-name" class="name-input" placeholder="Name" autocomplete="off"></span>
                            </div>
                            <div class="form-box service-duration custom-form-select">
                              <label for="service-duration">Select service duration:</label>
                              <span>
                                <input type="text" name="service-duration" id="service-duration" class="duration-input" placeholder="1:00" autocomplete="off">
                              </span>
                              <ul class="duration-list">
                                {!! $duration !!}
                              </ul>
                            </div>
                            <div class="form-box service-price custom-form-input">
                              <label for="service-price">Input service price:</label>
                              <span><input type="number" name="service-price" id="service-price" class="price-input" min="0" max="1000" placeholder="35$" autocomplete="off"></span>
                            </div>
                            <a class="save add-new-service">Add service</a>
                          </form>
                        </div>
                        <div class="col-8">
                          <h4>Created services</h4>
                          <div class="service-table">
                            <table class="table">
                              <thead class="thead-light">
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Service name</th>
                                  <th scope="col">Service duration</th>
                                  <th scope="col">Service price</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td>Enfant (jusqu`à 10 ans)</td>
                                  <td>Service 1</td>
                                  <td>1:00</td>
                                  <td>78$</td>
                                </tr>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>Enfant (jusqu`à 10 ans)</td>
                                  <td>Service 2</td>
                                  <td>1:00</td>
                                  <td>78$</td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>Enfant (jusqu`à 10 ans)</td>
                                  <td>Service 3</td>
                                  <td>1:00</td>
                                  <td>78$</td>
                                </tr>
                                <tr>
                                  <th scope="row">4</th>
                                  <td>Enfant (jusqu`à 10 ans)</td>
                                  <td>Service 4</td>
                                  <td>1:00</td>
                                  <td>78$</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4">
                          <h4>Add staff</h4>
                          <form action="" id="staff-from">
                            <div class="form-box staff-name custom-form-input">
                              <label class="staff-name" for="staff-name">Input staff name:</label>
                              <span><input type="text" name="staff-name" id="staff-name" placeholder="Staff name"></span>
                            </div>
                            <div class="form-box custom-from-list-block">
                              <ul class="custom-from-list">
                                <li><span>Service 1</span><input type="checkbox" name=""></li>
                                <li><span>Service 2</span><input type="checkbox" name=""></li>
                                <li><span>Service 3</span><input type="checkbox" name=""></li>
                                <li><span>Service 4</span><input type="checkbox" name=""></li>
                                <li><span>Service 5</span><input type="checkbox" name=""></li>
                                <li><span>Service 6</span><input type="checkbox" name=""></li>
                                <li><span>Service 7</span><input type="checkbox" name=""></li>
                                <li><span>Service 8</span><input type="checkbox" name=""></li>
                                <li><span>Service 9</span><input type="checkbox" name=""></li>
                                <li><span>Service 10</span><input type="checkbox" name=""></li>
                                <li><span>Service 11</span><input type="checkbox" name=""></li>
                                <li><span>Service 12</span><input type="checkbox" name=""></li>
                                <li><span>Service 13</span><input type="checkbox" name=""></li>
                              </ul>
                            </div>
                            <a href="#" class="save add-new-staff">Add staff</a>
                          </form>
                        </div>
                        <div class="col-8">
                          <h4>Created staff</h4>
                          <div class="staff-table">
                            <table class="table">
                              <thead class="thead-light">
                                <tr>
                                  <th scope="col">#</th>
                                  <th>Staff</th>
                                  <th>Services</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td>Olya</td>
                                  <td>
                                    <span>Service 4</span>
                                    <span>Service 2</span>
                                    <span>Service 5</span>
                                    <span>Service 8</span>
                                    <span>Service 1</span>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>Diana</td>
                                  <td>
                                    <span>Service 4</span>
                                    <span>Service 2</span>
                                    <span>Service 8</span>
                                    <span>Service 1</span>
                                    <span>Service 9</span>
                                    <span>Service 5</span>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>Valya</td>
                                  <td>
                                    <span>Service 4</span>
                                    <span>Service 2</span>
                                    <span>Service 5</span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="tab4">...</div>
              <div class="tab-pane container fade" id="tab5">...</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>