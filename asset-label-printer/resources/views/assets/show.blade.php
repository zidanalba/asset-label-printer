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
                    <dd class="col-sm-8">{{ $asset->organization->name ?? '-' }}</dd>

                    <dt class="col-sm-4">Location (Infrastructure)</dt>
                    <dd class="col-sm-8">{{ $asset->infrastructure->name ?? '-' }}</dd>

                    <dt class="col-sm-4">Created At</dt>
                    <dd class="col-sm-8">{{ $asset->created_at->format('Y-m-d H:i') }}</dd>

                    <dt class="col-sm-4">Last Updated</dt>
                    <dd class="col-sm-8">{{ $asset->updated_at->format('Y-m-d H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection 