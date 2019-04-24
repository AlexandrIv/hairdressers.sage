{{--
  Template Name: Personal Provider Template
--}}

@extends('layouts.page')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.provider-personal-page-part')
  @endwhile
@endsection