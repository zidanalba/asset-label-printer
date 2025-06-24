@extends('layouts.app')

@section('title', 'Asset Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-eye"></i> Asset Details
            </h1>
            <div>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Assets
                </a>
                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Asset
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Asset Information
                </h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Asset Code</dt>
                    <dd class="col-sm-8">{{ $asset->code }}</dd>

                    <dt class="col-sm-4">Asset Name</dt>
                    <dd class="col-sm-8">{{ $asset->name }}</dd>

                    <dt class="col-sm-4">Category</dt>
                    <dd class="col-sm-8">{{ $asset->category->name ?? '-' }}</dd>

                    <dt class="col-sm-4">Organization</dt>
                    <dd class="col-sm-8">
                        @if($asset->instances->count() > 0)
                            @foreach($asset->instances as $instance)
                                <span class="badge bg-info">{{ $instance->organization->name ?? '-' }}</span>
                                @if(!$loop->last)<br>@endif
                            @endforeach
                        @else
                            <span class="text-muted">No Organization</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Location (Infrastructure)</dt>
                    <dd class="col-sm-8">
                        @if($asset->instances->count() > 0)
                            @foreach($asset->instances as $instance)
                                <span class="badge bg-light text-dark">{{ $instance->infrastructure->name ?? '-' }}</span>
                                @if(!$loop->last)<br>@endif
                            @endforeach
                        @else
                            <span class="text-muted">No Location</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Created At</dt>
                    <dd class="col-sm-8">{{ $asset->created_at->format('Y-m-d H:i') }}</dd>

                    <dt class="col-sm-4">Last Updated</dt>
                    <dd class="col-sm-8">{{ $asset->updated_at->format('Y-m-d H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-collection"></i> Asset Instances
                </h5>
            </div>
            <div class="card-body">
                @if($asset->instances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Organization</th>
                                    <th>Location</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Installed At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asset->instances as $instance)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ $instance->organization->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $instance->infrastructure->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $instance->qty }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $instance->status == 'active' ? 'success' : ($instance->status == 'maintenance' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($instance->status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $instance->installed_at ? $instance->installed_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <h5 class="text-muted mt-2">No instances found</h5>
                        <p class="text-muted">This asset has no instances assigned to any organization or location.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 