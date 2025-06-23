@extends('layouts.app')

@section('title', 'Add New Asset')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle"></i> Add New Asset
            </h1>
            <div>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Assets
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-box"></i> Asset Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Asset Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="e.g., ASSET-001" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Dell XPS 13 Laptop" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <!-- Category Hierarchy -->
                        <div class="col-md-3 mb-3">
                            <label for="category_parent" class="form-label">Category</label>
                            <select class="form-select" id="category_parent">
                                <option value="">Select Category</option>
                                @foreach($categories->where('parent_id', null) as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="category_id" class="form-label">Sub Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Select Sub Category</option>
                                @foreach($categories->where('parent_id', '!=', null) as $cat)
                                    <option value="{{ $cat->id }}" data-parent="{{ $cat->parent_id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Organization Hierarchy -->
                        <div class="col-md-3 mb-3">
                            <label for="organization_parent" class="form-label">Division</label>
                            <select class="form-select" id="organization_parent">
                                <option value="">Select Division</option>
                                @foreach($organizations->where('parent_id', null) as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="organization_id" class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id" required>
                                <option value="">Select Unit</option>
                                @foreach($organizations->where('parent_id', '!=', null) as $org)
                                    <option value="{{ $org->id }}" data-parent="{{ $org->parent_id }}">{{ $org->name }}</option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <!-- Infrastructure Hierarchy -->
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_building" class="form-label">Building</label>
                            <select class="form-select" id="infrastructure_building">
                                <option value="">Select Building</option>
                                @foreach($infrastructures->where('parent_id', null) as $bld)
                                    <option value="{{ $bld->id }}">{{ $bld->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_floor" class="form-label">Floor</label>
                            <select class="form-select" id="infrastructure_floor">
                                <option value="">Select Floor</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $floor)
                                    <option value="{{ $floor->id }}" data-parent="{{ $floor->parent_id }}">{{ $floor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_room" class="form-label">Room</label>
                            <select class="form-select" id="infrastructure_room">
                                <option value="">Select Room</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $room)
                                    <option value="{{ $room->id }}" data-parent="{{ $room->parent_id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_id" class="form-label">Sub-Room</label>
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" id="infrastructure_id" name="infrastructure_id">
                                <option value="">Select Sub-Room</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $subroom)
                                    <option value="{{ $subroom->id }}" data-parent="{{ $subroom->parent_id }}">{{ $subroom->name }}</option>
                                @endforeach
                            </select>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create Asset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Quick Tips
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Asset Code:</strong> Use a unique code for each asset
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Category:</strong> Organize assets for easier management
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Organization:</strong> Assign responsibility for assets
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Location:</strong> Specify where the asset is located
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Hierarchical select logic
function filterChildren(parentSelect, childSelect) {
    const parentId = parentSelect.value;
    Array.from(childSelect.options).forEach(option => {
        if (!option.value) return option.hidden = false;
        option.hidden = option.getAttribute('data-parent') !== parentId;
    });
    childSelect.value = '';
}

document.addEventListener('DOMContentLoaded', function() {
    // Category
    const catParent = document.getElementById('category_parent');
    const catChild = document.getElementById('category_id');
    catParent.addEventListener('change', function() {
        filterChildren(catParent, catChild);
    });
    filterChildren(catParent, catChild);

    // Organization
    const orgParent = document.getElementById('organization_parent');
    const orgChild = document.getElementById('organization_id');
    orgParent.addEventListener('change', function() {
        filterChildren(orgParent, orgChild);
    });
    filterChildren(orgParent, orgChild);

    // Infrastructure: Building -> Floor
    const infraBuilding = document.getElementById('infrastructure_building');
    const infraFloor = document.getElementById('infrastructure_floor');
    const infraRoom = document.getElementById('infrastructure_room');
    const infraSubRoom = document.getElementById('infrastructure_id');

    infraBuilding.addEventListener('change', function() {
        filterChildren(infraBuilding, infraFloor);
        filterChildren(infraFloor, infraRoom);
        filterChildren(infraRoom, infraSubRoom);
    });
    infraFloor.addEventListener('change', function() {
        filterChildren(infraFloor, infraRoom);
        filterChildren(infraRoom, infraSubRoom);
    });
    infraRoom.addEventListener('change', function() {
        filterChildren(infraRoom, infraSubRoom);
    });
    filterChildren(infraBuilding, infraFloor);
    filterChildren(infraFloor, infraRoom);
    filterChildren(infraRoom, infraSubRoom);
});
</script>
@endpush
@endsection 