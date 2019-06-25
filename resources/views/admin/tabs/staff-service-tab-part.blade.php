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
                <input type="text" name="service-category" id="service-category" class="category-input" placeholder="Femme" autocomplete="off" readonly>
              </span>
              <ul class="category-list">
                {!! $get_service_categories !!}
              </ul>
            </div>
            <div class="form-box service-name custom-form-input">
              <label class="service-name" for="service-name">Input service name:</label>
              <span><input type="text" name="service-name" id="service-name" class="name-input" placeholder="Name" autocomplete="off"></span>
            </div>
            <div class="form-box service-duration custom-form-select">
              <label for="service-duration">Select service duration:</label>
              <span>
                <input type="text" name="service-duration" id="service-duration" class="duration-input" placeholder="1:00" autocomplete="off" readonly>
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
                  <th scope="col"><a href="#" data-sort="asc" data-type="category" class="sort-service"><span>Category </span><i class="fas fa-sort-down"></i></a></th>
                  <th scope="col"><a href="#" data-sort="asc" data-type="name" class="sort-service"><span>Service name </span><i class="fas fa-sort-down"></i></a></th>
                  <th scope="col"><a href="#" data-sort="asc" data-type="duration" class="sort-service"><span>Service duration </span><i class="fas fa-sort-down"></i></a></th>
                  <th scope="col"><a href="#" data-sort="asc" data-type="price" class="sort-service"><span>Service price </span><i class="fas fa-sort-down"></i></a></th>
                </tr>
              </thead>
              <tbody class="services-data"></tbody>
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
              <span><input type="text" name="staff-name" id="staff-name" class="staff-name-input" placeholder="Staff name"></span>
            </div>
            <div class="form-box custom-from-list-block">
              <ul class="custom-from-list"></ul>
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
              <tbody class="staff-table-body"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>