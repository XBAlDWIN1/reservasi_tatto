@foreach($users as $user)
    <tr class="border-t">
        <td class="p-2">{{ $user->name }}</td>
        <td class="p-2">{{ $user->email }}</td>
        <td class="p-2">{{ $user->roles->pluck('name')->first() }}</td>
        <td class="p-2 space-x-2">
            <button @click='setEdit(@json($user))' class="text-blue-600">Edit</button>
            <button @click="confirmDelete({{ $user->id }})" class="text-red-600">Hapus</button>
        </td>
    </tr>
@endforeach
