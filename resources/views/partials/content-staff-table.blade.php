@if($staffs)
@foreach ($staffs as $staff)
<tr data-id="{!! $staff['ID'] !!}">
	<th scope="row"><span class="remove remove-staff"><i class="fas fa-trash-alt"></i></span><span class="count">{!! ($i++)+1 !!}</span></th>
	<td>{!! $staff['post_title'] !!}</td>
	<td>
		@foreach ($staff['services_name'] as $service)
		<span>{!! $service !!}</span>
		@endforeach
	</td>
</tr>
@endforeach
@elseif($staffs == false)
	<h5>You have not added any staff</h5>
@endif
