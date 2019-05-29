<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
  <article @php post_class() @endphp>
    <header>
      <div class="header-meta">
        <h1 class="salon-title">{!! get_the_title() !!}</h1>
        <span class="category">{{ get_post_term_by_id() }}</span>
        <span class="address"><i class="fas fa-map-marker-alt"></i><span>{!! $address !!}</span></span>
      </div>
      <div class="header-button">
        <a href="#">Prendre rdv</a>
      </div>
    </header>
    @if ( $single_slider )
    <div class="slider single-slider">
      @foreach ( $single_slider as $slide )
      <img src="{!! $slide['url'] !!}" alt="">
      @endforeach
    </div>
    @endif
    <div class="single-content">
      {!! get_the_content() !!}
    </div>
    <div class="services-block">
      <div class="services-table-header">
        <span class="services-table-title">Prendre rendez-vous en ligne</span>
        <span class="services-table-description">Gratuitement - Paiement sur place - Confirmation immédiate</span>
      </div>
      <span class="select-service-title">1. Choix de la prestation</span>
      <div class="services-table">
        <span class="service-category">Femme</span>
        <table>
          <tbody>
            <tr>
              <td><a href="#">Shampoing Coiffage (court) Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
          </tbody>
        </table>
        <span class="service-category">Technique</span>
        <table>
          <tbody>
            <tr>
              <td><a href="#">Shampoing Coiffage (court) Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
          </tbody>
        </table>
        <span class="service-category">Homme</span>
        <table>
          <tbody>
            <tr>
              <td><a href="#">Shampoing Coiffage (court) Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
          </tbody>
        </table>
        <span class="service-category">Enfant (jusqu'à 10 ans)</span>
        <table>
          <tbody>
            <tr>
              <td><a href="#">Shampoing Coiffage (court) Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
            <tr>
              <td><a href="#">Shampoing Coiffage (court)</a></td>
              <td>30min</td>
              <td>31€</td>
              <td><a href="#" class="link-to">Choisir</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>
</div>
<div class="sidebar col-xl-4 col-lg-4 col-md-12 col-sm-12">
  @if ($single_map_info)
  <div class="sidebar-box map-sidebar">
    <h3>Plan d'accès</h3>
    <div id="map-single">
      <script type="text/javascript">
        window.postJsonSingle = '{!! json_encode($single_map_info); !!}';
      </script>
    </div>
  </div>
  @endif
  @if ($get_opening_times)
  <div class="sidebar-box opening-time">
    <h3>Horaires d'ouverture</h3>
    <table>
      <tbody>
        @foreach ($get_opening_times as $key => $element)
        @if ( $element['start'] || $element['end'] )
        <tr>
          <td>{!! ucfirst( $key ) !!}</td>
          <td>
            @if ($element['start'] == 'closed' || $element['end'] == 'closed')
            <span>Closed</span>
            @else
            <span class="start">{!! substr($element['start'], 0, -3) !!}</span>
            <span> - </span>
            <span class="end">{!! substr($element['end'], 0, -3) !!}</span>
            @endif
          </td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
