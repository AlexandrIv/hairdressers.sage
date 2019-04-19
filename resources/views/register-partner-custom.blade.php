{{--
  Template Name: Register Partner Template
--}}

@extends('layouts.page')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-register-partner')
  @endwhile
@endsection
