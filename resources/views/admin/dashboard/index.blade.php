@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    {{-- Stat Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="display-4 text-primary me-3"><i class="fas fa-users"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Total Clients</h6>
                        <h3 class="fw-bold mb-0">{{ $totalClients }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="display-4 text-success me-3"><i class="fas fa-receipt"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Total Orders</h6>
                        <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="display-4 text-warning me-3"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Pending Orders</h6>
                        <h3 class="fw-bold mb-0">{{ $pendingOrders }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="display-4 text-info me-3"><i class="fas fa-utensils"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Total Plats</h6>
                        <h3 class="fw-bold mb-0">{{ $totalplats }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Plats to Prepare --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-transparent pt-3">
                    <h5 class="mb-0">Plats to Prepare</h5>
                </div>
                <div class="card-body">
                    @if($platsToPrepare->isEmpty())
                        <div class="text-center py-4">
                            <p>No plats need to be prepared right now.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plat Name</th>
                                        <th class="text-center">Quantity to Prepare</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($platsToPrepare as $item)
                                        <tr>
                                            <td class="fw-bold">{{ $item->plat->name ?? 'Unknown plat' }}</td>
                                            <td class="text-center fs-5">{{ $item->total_quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                {{-- ADDED: Pagination Links --}}
                @if($platsToPrepare->hasPages())
                    <div class="card-footer bg-light">
                        {{ $platsToPrepare->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-lg-5">
             <div class="card shadow-sm border-0 h-100 bg-success text-white">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="mb-3">Total Revenue (Completed Orders)</h5>
                    <h2 class="display-5 fw-bold">${{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection