@extends('layouts.page')

@section('content')
<div class="container">
	<div class="row pt-5 pb-5">
		@while(have_posts()) @php the_post() @endphp
			@include('partials.content-single-'.get_post_type())
		@endwhile
	</div>
</div>
@endsection
