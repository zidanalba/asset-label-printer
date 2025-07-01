@extends('layouts.app')

@section('title', 'Edit Asset')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i> Edit Asset
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
                <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Asset Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $asset->code) }}" placeholder="e.g., ASSET-001" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $asset->name) }}" placeholder="e.g., Dell XPS 13 Laptop" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="serial_number" class="form-label">Serial Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" maxlength="64" placeholder="e.g., 20250624-Z3M7Q8LC">
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
                                <option value="">Not Selected</option>
                                @php
                                    $selectedCategory = $asset->category;
                                    $selectedCategoryParentId = $selectedCategory?->parent?->id ?? null;
                                @endphp
                                @foreach($categories->where('parent_id', null) as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $selectedCategoryParentId ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="category_id" class="form-label">Sub Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id[]">
                                <option value="">Not Selected</option>
                                @foreach($categories->where('parent_id', '!=', null) as $cat)
                                    <option value="{{ $cat->id }}" data-parent="{{ $cat->parent_id }}" {{ old('category_id', $asset->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
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
                                <option value="">Not Selected</option>
                                    @php
                                        $instance = $assetInstance;
                                        $selectedOrg = $instance?->organization;

                                        // Check if it's a unit (has parent), then take parent ID
                                        // Otherwise, assume it's a division
                                        $selectedDivisionId = $selectedOrg
                                            ? ($selectedOrg->parent_id ?? $selectedOrg->id)
                                            : null;
                                    @endphp

                                    @foreach($organizations->where('parent_id', null) as $org)
                                        <option value="{{ $org->id }}" {{ $org->id == $selectedDivisionId ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach

                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="organization_id" class="form-label">Unit</label>
                            <select class="form-select @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id[]">
                                <option value="">Not Selected</option>
                                @foreach($organizations->where('parent_id', '!=', null) as $org)
                                    @php
                                        $instance = $asset->instances->first();
                                        $orgSelected = $instance && $instance->organization_id == $org->id;
                                    @endphp
                                    <option value="{{ $org->id }}" data-parent="{{ $org->parent_id }}" {{ old('organization_id', $orgSelected ? $org->id : '') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <!-- Infrastructure Hierarchy -->
                        @php
                            $instance = $asset->instances->first();
                            $selectedInfra = $instance?->infrastructure;

                            $building = $floor = $room = $subRoom = null;

                            if ($selectedInfra) {
                                $current = $selectedInfra;
                                $parents = [];

                                // Traverse upward and store each parent
                                while ($current) {
                                    $parents[] = $current;
                                    $current = $current->parent;
                                }

                                // Now reverse to go from top (building) to bottom
                                $parents = array_reverse($parents);

                                // Assign levels based on depth
                                $building  = $parents[0] ?? null;
                                $floor     = $parents[1] ?? null;
                                $room      = $parents[2] ?? null;
                                $subRoom   = $parents[3] ?? null;
                            }
                        @endphp


                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_building" class="form-label">Building</label>
                            <select class="form-select" id="infrastructure_building">
                                <option value="">Not Selected</option>
                                @foreach($infrastructures->where('parent_id', null) as $bld)
                                    <option value="{{ $bld->id }}" {{ $bld->id == $building?->id ? 'selected' : '' }}>
                                        {{ $bld->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_floor" class="form-label">Floor</label>
                            <select class="form-select" id="infrastructure_floor">
                                <option value="">Not Selected</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $floorItem)
                                    <option value="{{ $floorItem->id }}" data-parent="{{ $floorItem->parent_id }}"
                                        {{ $floorItem->id == $floor?->id ? 'selected' : '' }}>
                                        {{ $floorItem->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_room" class="form-label">Room</label>
                            <select class="form-select" id="infrastructure_room">
                                <option value="">Not Selected</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $roomItem)
                                    <option value="{{ $roomItem->id }}" data-parent="{{ $roomItem->parent_id }}"
                                        {{ $roomItem->id == $room?->id ? 'selected' : '' }}>
                                        {{ $roomItem->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="infrastructure_id" class="form-label">Sub-Room</label>
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" id="infrastructure_id" name="infrastructure_id[]">
                                <option value="">Not Selected</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $subroomItem)
                                    <option value="{{ $subroomItem->id }}" data-parent="{{ $subroomItem->parent_id }}"
                                        {{ $subroomItem->id == $subRoom?->id ? 'selected' : '' }}>
                                        {{ $subroomItem->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 text-center">
                            <label for="assetPhoto" class="form-label">Asset's Photo</label>
                            <input class="form-control" type="file" id="assetPhoto" name="asset_photo">
                            @if ($assetInstance->asset_photo)
                                <div class="preview-wrapper position-relative d-inline-block mt-3">
                                    <img src="{{ asset('storage/' . $assetInstance->asset_photo) }}"
                                        id="assetPhotoPreview" class="img-fluid" style="max-height: 200px;" />
                                    <input type="hidden" name="remove_asset_photo" id="remove_asset_photo" value="0">
                                    
                                    <button type="button"
                                        id="assetPhotoCloseBtn"
                                        class="btn-close position-absolute top-0 end-0"
                                        aria-label="Close"
                                        onclick="clearPreview('assetPhoto', 'assetPhotoPreview', 'assetPhotoCloseBtn', 'remove_asset_photo')">
                                    </button>

                                </div>
                            @else
                                <div class="preview-wrapper position-relative d-inline-block mt-3">
                                    <img id="assetPhotoPreview" class="img-fluid" style="max-height: 200px;" />
                                    <button type="button"
                                        id="assetPhotoCloseBtn"
                                        class="btn-close position-absolute top-0 end-0"
                                        aria-label="Close"
                                        style="display: none;"
                                        onclick="clearPreview('assetPhoto', 'assetPhotoPreview', 'assetPhotoCloseBtn', 'remove_asset_photo')">
                                    </button>

                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3 text-center">
                            <label for="serialNumberPhoto" class="form-label">Asset's Serial Number Photo</label>
                            <input class="form-control" type="file" id="serialNumberPhoto" name="asset_serial_number_photo">
                            @if ($assetInstance->asset_serial_number_photo)
                                <div class="preview-wrapper position-relative d-inline-block mt-3">
                                    <img src="{{ asset('storage/' . $assetInstance->asset_serial_number_photo) }}"
                                        id="serialNumberPhotoPreview" class="img-fluid" style="max-height: 200px;" />
                                        <input type="hidden" name="remove_asset_serial_number_photo" id="remove_asset_serial_number_photo" value="0">            
                                        <button type="button"
                                            id="serialNumberCloseBtn"
                                            class="btn-close position-absolute top-0 end-0"
                                            aria-label="Close"
                                            onclick="clearPreview('serialNumberPhoto', 'serialNumberPhotoPreview', 'serialNumberCloseBtn', 'remove_asset_serial_number_photo')">
                                        </button>
                                </div>
                            @else
                                <div class="preview-wrapper position-relative d-inline-block mt-3">
                                    <img id="serialNumberPhotoPreview" class="img-fluid" style="max-height: 200px;" />
                                    <button type="button"
                                        id="serialNumberCloseBtn"
                                        class="btn-close position-absolute top-0 end-0"
                                        aria-label="Close"
                                        style="display: none;"
                                        onclick="clearPreview('serialNumberPhoto', 'serialNumberPhotoPreview', 'serialNumberCloseBtn', 'remove_asset_serial_number_photo')">
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Asset
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

function clearPreview(inputId, previewId, closeBtnId, removeFlagId) {
        const fileInput = document.getElementById(inputId);
        const previewImg = document.getElementById(previewId);
        const closeBtn = document.getElementById(closeBtnId);
        const removeInput = document.getElementById(removeFlagId);

        if (fileInput) fileInput.value = '';
        if (previewImg) previewImg.src = '';
        if (closeBtn) closeBtn.style.display = 'none';
        if (removeInput) removeInput.value = '1';
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

    infraBuilding.dispatchEvent(new Event('change'));
    infraFloor.dispatchEvent(new Event('change'));
    infraRoom.dispatchEvent(new Event('change'));

    document.getElementById('assetPhoto').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('assetPhotoPreview').src = URL.createObjectURL(file);
            document.getElementById('assetPhotoCloseBtn').style.display = 'block';
        }
    });

    document.getElementById('serialNumberPhoto').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('serialNumberPhotoPreview').src = URL.createObjectURL(file);
            document.getElementById('serialNumberCloseBtn').style.display = 'block';
        }
    });
});
</script>
@endpush
@endsection 