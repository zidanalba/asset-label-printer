@extends('layouts.app')

@section('title', 'Print Labels')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-printer"></i> Print Labels
            </h1>
            <div>
                <a href="{{ route('labels.index') }}" class="btn btn-secondary">
                    <i class="bi bi-gear"></i> Label Settings
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Print Options -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-printer text-primary fs-1 mb-3"></i>
                <h5 class="card-title">Single Label</h5>
                <p class="card-text">Print a label for a specific asset</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#singlePrintModal">
                    <i class="bi bi-plus-circle"></i> Select Asset
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-collection text-success fs-1 mb-3"></i>
                <h5 class="card-title">Bulk Print</h5>
                <p class="card-text">Print multiple labels at once</p>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkPrintModal">
                    <i class="bi bi-list-check"></i> Select Assets
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-qr-code text-info fs-1 mb-3"></i>
                <h5 class="card-title">QR Code Labels</h5>
                <p class="card-text">Generate QR code labels</p>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#qrPrintModal">
                    <i class="bi bi-qr-code"></i> Generate QR
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Settings -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-gear"></i> Print Settings
                </h5>
            </div>
            <div class="card-body">
                <form id="printSettingsForm">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="labelSize" class="form-label">Label Size</label>
                            <select class="form-select" id="labelSize" name="labelSize">
                                <option value="small">Small (1" x 2")</option>
                                <option value="medium" selected>Medium (2" x 3")</option>
                                <option value="large">Large (3" x 4")</option>
                                <option value="custom">Custom Size</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="labelType" class="form-label">Label Type</label>
                            <select class="form-select" id="labelType" name="labelType">
                                <option value="standard" selected>Standard</option>
                                <option value="barcode">Barcode</option>
                                <option value="qr">QR Code</option>
                                <option value="detailed">Detailed</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="copies" class="form-label">Copies</label>
                            <input type="number" class="form-control" id="copies" name="copies" value="1" min="1" max="10">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="orientation" class="form-label">Orientation</label>
                            <select class="form-select" id="orientation" name="orientation">
                                <option value="portrait" selected>Portrait</option>
                                <option value="landscape">Landscape</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="printer" class="form-label">Printer</label>
                            <select class="form-select" id="printer" name="printer">
                                <option value="default">Default Printer</option>
                                <option value="label-printer">Label Printer</option>
                                <option value="laser-printer">Laser Printer</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="paperType" class="form-label">Paper Type</label>
                            <select class="form-select" id="paperType" name="paperType">
                                <option value="standard" selected>Standard Paper</option>
                                <option value="label-sheet">Label Sheet</option>
                                <option value="thermal">Thermal Paper</option>
                                <option value="adhesive">Adhesive Labels</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Recent Prints -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Recent Prints
                </h5>
            </div>
            <div class="card-body">
                @if(isset($recentPrints) && count($recentPrints) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Asset</th>
                                    <th>Label Type</th>
                                    <th>Copies</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPrints as $print)
                                <tr>
                                    <td>{{ $print->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $print->asset->asset_id }}</strong>
                                        <br><small class="text-muted">{{ $print->asset->name }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $print->label_type }}</span>
                                    </td>
                                    <td>{{ $print->copies }}</td>
                                    <td>
                                        @if($print->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($print->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="reprint({{ $print->id }})">
                                            <i class="bi bi-printer"></i> Reprint
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-printer text-muted fs-1"></i>
                        <p class="text-muted mt-2">No recent prints. Start by printing your first label!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Single Print Modal -->
<div class="modal fade" id="singlePrintModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Asset for Single Print</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Search assets..." id="assetSearch">
                </div>
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-hover">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>Asset ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="assetTableBody">
                            <!-- Assets will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Print Modal -->
<div class="modal fade" id="bulkPrintModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Assets for Bulk Print</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Search assets..." id="bulkAssetSearch">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="bulkCategoryFilter">
                            <option value="">All Categories</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-hover">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>
                                    <input type="checkbox" class="form-check-input" id="bulkSelectAll">
                                </th>
                                <th>Asset ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bulkAssetTableBody">
                            <!-- Assets will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="proceedBulkPrint()">
                    <i class="bi bi-printer"></i> Print Selected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- QR Print Modal -->
<div class="modal fade" id="qrPrintModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate QR Code Labels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="qrPrintForm">
                    <div class="mb-3">
                        <label for="qrContent" class="form-label">QR Code Content</label>
                        <textarea class="form-control" id="qrContent" rows="3" placeholder="Enter text or URL for QR code"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="qrSize" class="form-label">QR Code Size</label>
                        <select class="form-select" id="qrSize">
                            <option value="small">Small</option>
                            <option value="medium" selected>Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qrCopies" class="form-label">Number of Copies</label>
                        <input type="number" class="form-control" id="qrCopies" value="1" min="1" max="100">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="generateQR()">
                    <i class="bi bi-qr-code"></i> Generate QR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Print functionality
function reprint(printId) {
    // Implement reprint functionality
    console.log('Reprinting:', printId);
}

function proceedBulkPrint() {
    const selectedAssets = getBulkSelectedAssets();
    if (selectedAssets.length > 0) {
        // Implement bulk print functionality
        console.log('Bulk printing assets:', selectedAssets);
        $('#bulkPrintModal').modal('hide');
    } else {
        alert('Please select at least one asset to print.');
    }
}

function generateQR() {
    const content = document.getElementById('qrContent').value;
    const size = document.getElementById('qrSize').value;
    const copies = document.getElementById('qrCopies').value;
    
    if (content.trim()) {
        // Implement QR generation functionality
        console.log('Generating QR:', { content, size, copies });
        $('#qrPrintModal').modal('hide');
    } else {
        alert('Please enter content for the QR code.');
    }
}

function getBulkSelectedAssets() {
    const checkboxes = document.querySelectorAll('#bulkAssetTableBody input[type="checkbox"]:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Load assets for modals
document.addEventListener('DOMContentLoaded', function() {
    // Load assets for single print modal
    loadAssetsForModal('assetTableBody');
    
    // Load assets for bulk print modal
    loadAssetsForModal('bulkAssetTableBody');
    
    // Bulk select all functionality
    const bulkSelectAll = document.getElementById('bulkSelectAll');
    if (bulkSelectAll) {
        bulkSelectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#bulkAssetTableBody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
});

function loadAssetsForModal(tableBodyId) {
    // This would typically load assets from the server
    // For now, we'll add some sample data
    const tableBody = document.getElementById(tableBodyId);
    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td>${tableBodyId === 'assetTableBody' ? '<input type="radio" name="selectedAsset" value="1">' : '<input type="checkbox" value="1">'}</td>
                <td>ASSET-001</td>
                <td>Sample Asset 1</td>
                <td>Electronics</td>
                <td>${tableBodyId === 'bulkAssetTableBody' ? '<span class="badge bg-success">Active</span>' : ''}</td>
            </tr>
            <tr>
                <td>${tableBodyId === 'assetTableBody' ? '<input type="radio" name="selectedAsset" value="2">' : '<input type="checkbox" value="2">'}</td>
                <td>ASSET-002</td>
                <td>Sample Asset 2</td>
                <td>Furniture</td>
                <td>${tableBodyId === 'bulkAssetTableBody' ? '<span class="badge bg-success">Active</span>' : ''}</td>
            </tr>
        `;
    }
}
</script>
@endsection 