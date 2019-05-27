<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
  @php do_action('get_header') @endphp
  @include('partials.header')
  <div class="wrapper" role="document">
    <div class="content">
      <div class="container">
        <div class="row pt-5 pb-5">
          @yield('content')
      </div>
    </div>
  </div>
  @php do_action('get_footer') @endphp
  @include('partials.footer')
  @php wp_footer() @endphp
</div>
</body>
</html>
