@props([
    'name' => null
])
<td>
    {{ $name }}
</td>

@pushonce('table-heads')
    <th>Name</th>
@endpushonce
