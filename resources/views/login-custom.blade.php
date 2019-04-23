{{--
  Template Name: Login Template
  --}}

  @extends('layouts.page')

  @section('content')
	  @while(have_posts()) @php the_post() @endphp
	  	@include('partials.login-form-part')
	  @endwhile
  @endsection