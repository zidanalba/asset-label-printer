@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-speedometer2"></i> Dashboard
            </h1>
            <div>
                <a href="{{ route('assets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Asset
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Assets
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAssets ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Labels Printed
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $labelsPrinted ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tags fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Categories
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categories ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-collection fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Prints
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPrints ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-printer fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('assets.create') }}" class="text-decoration-none">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-plus-circle text-primary fs-1"></i>
                                    <h5 class="card-title mt-2">Add Asset</h5>
                                    <p class="card-text text-muted">Create a new asset entry</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('print.index') }}" class="text-decoration-none">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-printer text-success fs-1"></i>
                                    <h5 class="card-title mt-2">Print Labels</h5>
                                    <p class="card-text text-muted">Generate asset labels</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('assets.index') }}" class="text-decoration-none">
                            <div class="card border-info h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-search text-info fs-1"></i>
                                    <h5 class="card-title mt-2">Browse Assets</h5>
                                    <p class="card-text text-muted">View all assets</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Assets -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history"></i> Recent Assets
                </h6>
                <a href="{{ route('assets.index') }}" class="btn btn-sm btn-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentAssets) && count($recentAssets) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Asset ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAssets as $asset)
                                <tr>
                                    <td><strong>{{ $asset->asset_id }}</strong></td>
                                    <td>{{ $asset->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $asset->category }}</span>
                                    </td>
                                    <td>
                                        @if($asset->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $asset->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <p class="text-muted mt-2">No assets found. Start by adding your first asset!</p>
                        <a href="{{ route('assets.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add First Asset
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 