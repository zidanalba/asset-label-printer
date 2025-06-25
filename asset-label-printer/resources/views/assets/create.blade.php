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
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-box"></i> Asset Information
                </h5>
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> 
                    You can select any level in the hierarchy. The most specific (last selected) value will be used.
                </small>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                        <div class="col-md-6 mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" maxlength="64" placeholder="Optional">
                            @error('serial_number')
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
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id[]">
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
                            <label for="organization_id" class="form-label">Unit</label>
                            <select class="form-select @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id[]">
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
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" id="infrastructure_id" name="infrastructure_id[]">
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
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty', 1) }}" min="1" required>
                            @error('qty')
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
</div>

@push('scripts')
<script>
// Hierarchical select logic - populate arrays with [parent, child] structure
function updateArrayField(parentSelect, childSelect) {
    const parentValue = parentSelect.value;
    const childValue = childSelect.value;
    
    // Create array with parent and child values, filter out empty values
    const values = [parentValue, childValue].filter(val => val !== '');
    
    // Update the child select's name to include the array values
    const fieldName = childSelect.name.replace('[]', '');
    
    // Remove existing hidden inputs for this field
    document.querySelectorAll(`input[name="${fieldName}[]"]`).forEach(input => input.remove());
    
    // Add new hidden inputs for each value (only if values exist)
    if (values.length > 0) {
        values.forEach(value => {
            if (value && value.trim() !== '') {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `${fieldName}[]`;
                hiddenInput.value = value;
                childSelect.parentNode.appendChild(hiddenInput);
            }
        });
    }
}

function filterChildren(parentSelect, childSelect) {
    const parentId = parentSelect.value;
    Array.from(childSelect.options).forEach(option => {
        if (!option.value) return option.hidden = false;
        option.hidden = parentId ? option.getAttribute('data-parent') !== parentId : false;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Category
    const catParent = document.getElementById('category_parent');
    const catChild = document.getElementById('category_id');
    catParent.addEventListener('change', function() {
        filterChildren(catParent, catChild);
        updateArrayField(catParent, catChild);
    });
    catChild.addEventListener('change', function() {
        updateArrayField(catParent, catChild);
    });
    filterChildren(catParent, catChild);

    // Organization
    const orgParent = document.getElementById('organization_parent');
    const orgChild = document.getElementById('organization_id');
    orgParent.addEventListener('change', function() {
        filterChildren(orgParent, orgChild);
        updateArrayField(orgParent, orgChild);
    });
    orgChild.addEventListener('change', function() {
        updateArrayField(orgParent, orgChild);
    });
    filterChildren(orgParent, orgChild);

    // Infrastructure: Building -> Floor -> Room -> Sub-Room
    const infraBuilding = document.getElementById('infrastructure_building');
    const infraFloor = document.getElementById('infrastructure_floor');
    const infraRoom = document.getElementById('infrastructure_room');
    const infraSubRoom = document.getElementById('infrastructure_id');

    // For infrastructure, we need to handle the full hierarchy
    function updateInfrastructureArray() {
        const values = [
            infraBuilding.value,
            infraFloor.value,
            infraRoom.value,
            infraSubRoom.value
        ].filter(val => val !== '' && val !== null);
        
        const fieldName = 'infrastructure_id';
        
        // Remove existing hidden inputs
        document.querySelectorAll(`input[name="${fieldName}[]"]`).forEach(input => input.remove());
        
        // Add new hidden inputs for each value (only if values exist)
        if (values.length > 0) {
            values.forEach(value => {
                if (value && value.trim() !== '') {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `${fieldName}[]`;
                    hiddenInput.value = value;
                    infraSubRoom.parentNode.appendChild(hiddenInput);
                }
            });
        }
    }

    infraBuilding.addEventListener('change', function() {
        filterChildren(infraBuilding, infraFloor);
        filterChildren(infraFloor, infraRoom);
        filterChildren(infraRoom, infraSubRoom);
        updateInfrastructureArray();
    });
    infraFloor.addEventListener('change', function() {
        filterChildren(infraFloor, infraRoom);
        filterChildren(infraRoom, infraSubRoom);
        updateInfrastructureArray();
    });
    infraRoom.addEventListener('change', function() {
        filterChildren(infraRoom, infraSubRoom);
        updateInfrastructureArray();
    });
    infraSubRoom.addEventListener('change', function() {
        updateInfrastructureArray();
    });
    
    // Initial filtering
    filterChildren(infraBuilding, infraFloor);
    filterChildren(infraFloor, infraRoom);
    filterChildren(infraRoom, infraSubRoom);
});
</script>
@endpush
@endsection 