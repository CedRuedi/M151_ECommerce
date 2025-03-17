@extends('layouts.app')

@section('title', 'Log di Attività')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Log di Attività</h1>

    <table class="w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="p-4 text-center">Utente</th>
                <th class="p-4 text-center">Azione</th>
                <th class="p-4 text-center">Descrizione</th>
                <th class="p-4 text-center">Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="border-t text-center">
                    <td class="p-4">{{ $log->user->name }}</td>
                    <td class="p-4 font-semibold">{{ $log->action }}</td>
                    <td class="p-4">{{ $log->description }}</td>
                    <td class="p-4">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
