@extends('layouts.app')

@section('title', 'Assets')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-box"></i> Assets Management
            </h1>
            <div>
                <a href="{{ route('assets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Asset
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <form method="GET" action="{{ route('assets.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name, ID, or description...">
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Assets Table -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-list-ul"></i> Assets List
                </h6>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print List
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="exportToCSV()">
                        <i class="bi bi-download"></i> Export CSV
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($assets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" id="assetsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Organization</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $asset)
                                <tr>
                                    <td><strong class="text-primary">{{ $asset->code }}</strong></td>
                                    <td>{{ $asset->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $asset->category->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $asset->organization->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $asset->infrastructure->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this asset?')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $assets->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <h4 class="text-muted mt-3">No assets found</h4>
                        <p class="text-muted">Start by adding your first asset to the system.</p>
                        <a href="{{ route('assets.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add First Asset
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions -->
<div class="row mt-4" id="bulkActions" style="display: none;">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        <span id="selectedCount">0</span> assets selected
                    </span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary" onclick="bulkPrint()">
                            <i class="bi bi-printer"></i> Print Labels
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="bulkExport()">
                            <i class="bi bi-download"></i> Export Selected
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="bulkDelete()">
                            <i class="bi bi-trash"></i> Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Bulk selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    // Select all functionality
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            assetCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }

    // Individual checkbox functionality
    assetCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActions();
            updateSelectAll();
        });
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.asset-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    function updateSelectAll() {
        const checkedBoxes = document.querySelectorAll('.asset-checkbox:checked');
        const totalBoxes = assetCheckboxes.length;
        
        if (selectAll) {
            if (checkedBoxes.length === 0) {
                selectAll.indeterminate = false;
                selectAll.checked = false;
            } else if (checkedBoxes.length === totalBoxes) {
                selectAll.indeterminate = false;
                selectAll.checked = true;
            } else {
                selectAll.indeterminate = true;
            }
        }
    }
});

// Bulk action functions
function bulkPrint() {
    const selectedAssets = getSelectedAssets();
    if (selectedAssets.length > 0) {
        // Redirect to bulk print page with selected assets
        window.location.href = `{{ route('print.bulk') }}?assets=${selectedAssets.join(',')}`;
    }
}

function bulkExport() {
    const selectedAssets = getSelectedAssets();
    if (selectedAssets.length > 0) {
        // Implement CSV export for selected assets
        console.log('Exporting assets:', selectedAssets);
    }
}

function bulkDelete() {
    const selectedAssets = getSelectedAssets();
    if (selectedAssets.length > 0) {
        if (confirm(`Are you sure you want to delete ${selectedAssets.length} selected assets?`)) {
            // Implement bulk delete functionality
            console.log('Deleting assets:', selectedAssets);
        }
    }
}

function getSelectedAssets() {
    const checkedBoxes = document.querySelectorAll('.asset-checkbox:checked');
    return Array.from(checkedBoxes).map(checkbox => checkbox.value);
}

// Individual action functions
function printLabel(assetId) {
    window.open(`{{ route('print.label', '') }}/${assetId}`, '_blank');
}

function deleteAsset(assetId) {
    if (confirm('Are you sure you want to delete this asset?')) {
        // Implement delete functionality
        console.log('Deleting asset:', assetId);
    }
}

function exportToCSV() {
    // Implement CSV export functionality
    console.log('Exporting to CSV');
}
</script>
@endsection 