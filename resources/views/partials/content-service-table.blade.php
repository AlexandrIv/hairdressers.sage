@if ($services)
@foreach ($services as $service)
<tr data-id="{!! $service['ID'] !!}">
	<th scope="row"><span class="remove remove-service"><i class="fas fa-trash-alt"></i></span><span class="count">{!! ($i++)+1 !!}</span></th>
	<td>{!! $service['category']['name'] !!}</td>
	<td>{!! $service['name'] !!}</td>
	<td>{!! date("H:i", $service['duration']) !!}</td>
	<td>{!! $service['price'] !!}$</td>
</tr>
@endforeach
@elseif ($services == false)
<h5>You have not added any service.</h5>
@endif
