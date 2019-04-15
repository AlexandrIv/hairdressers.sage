<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
  @php do_action('get_header') @endphp
  @include('partials.header')
  <div class="wrapper">
    <div class="content">
      @include('partials.slideshow')
      @include('partials.front-page-category')
      @include('partials.front-page-info')
    </div>
    @php do_action('get_footer') @endphp
      @include('partials.footer')
    @php wp_footer() @endphp
  </div>
</body>
</html>
