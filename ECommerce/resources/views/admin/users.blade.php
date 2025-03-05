@extends('layouts.app')

@section('content')

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Gestione Utenti</h1>

    <div class="flex justify-center">
        <table class="w-full max-w-4xl bg-white shadow-md rounded-lg overflow-hidden text-center">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                <tr>
                    <th class="p-4">Nome</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Ruolo</th>
                    <th class="p-4">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t hover:bg-gray-50 transition duration-150">
                        <td class="p-4 align-middle">{{ $user->name }}</td>
                        <td class="p-4 align-middle">{{ $user->email }}</td>
                        <td class="p-4 align-middle">
                            <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" class="inline-flex items-center justify-center space-x-2">
                                @csrf
                                <select name="role_id" class="border rounded py-2 px-2 w-28 text-center focus:outline-none focus:ring-2 focus:ring-blue-400" style="min-width: 100px; text-align: left">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="p-4 align-middle">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-150">Aggiorna</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
