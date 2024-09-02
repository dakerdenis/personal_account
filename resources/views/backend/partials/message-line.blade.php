<tr>
    <th scope="row">{{ $message->id }}</th>
    <td>{{ $message->created_at }}</td>
    <td>{{ $message->user ? $message->user->full_name : $message->staff->name }}</td>
    <td>{{ $message->message }}</td>
</tr>
