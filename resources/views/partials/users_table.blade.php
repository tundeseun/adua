@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->user_type }}</td>
    <td>
        <button class="btn btn-sm btn-primary edit-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-user_type="{{ $user->user_type }}">Edit</button>
        <button class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}">Delete</button>
    </td>
</tr>
@endforeach
