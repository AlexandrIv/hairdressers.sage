@foreach ($services as $post)
	<li><span>{!! $post['name'] !!}</span><input type="checkbox" class="services-from-staff" data-service-id="{!! $post['ID'] !!}" name="services_from_staff"></li>
@endforeach