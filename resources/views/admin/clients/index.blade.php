@extends('admin.layouts.app')

@section('page-title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Clients</h2>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Add New Client</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Tabs for Secteur --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request('secteur') ? 'active' : '' }}" href="{{ route('admin.clients.index') }}">All Clients</a>
    </li>
    @foreach($secteurs as $secteur)
        <li class="nav-item">
            <a class="nav-link {{ request('secteur') == $secteur ? 'active' : '' }}" href="{{ route('admin.clients.index', ['secteur' => $secteur]) }}">{{ $secteur }}</a>
        </li>
    @endforeach
</ul>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        @if ($clients->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Secteur</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration + ($clients->currentPage() - 1) * $clients->perPage() }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->contact ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ $client->secteur ?? 'N/A' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client->id) }}" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-center my-4">No clients found for this secteur.</p>
        @endif
    </div>
    @if($clients->hasPages())
        <div class="card-footer bg-light">
            {{ $clients->links() }}
        </div>
    @endif
</div>

@endsection
