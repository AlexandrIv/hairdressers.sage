@extends('layouts.taxonomy')

@section('content')

@if (!have_posts())
<div class="alert alert-warning">
	{{ __('Sorry, no results were found.', 'sage') }}
</div>
@endif


@include('partials.content-'.get_post_type())
{{-- @while (have_posts()) @php the_post() @endphp
@endwhile --}}

@endsection
