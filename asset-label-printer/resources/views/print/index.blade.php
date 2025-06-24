@extends('layouts.app')

@section('title', 'Print Labels')

@section('content')
<style>
    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
    }
    
    .filter-section h5 {
        color: #2c3e50;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .form-select, .form-control {
        border-radius: 6px;
        border: 1px solid #ced4da;
        transition: all 0.15s ease-in-out;
        font-size: 0.9rem;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        transform: translateY(-1px);
    }
    
    .form-select:hover, .form-control:hover {
        border-color: #adb5bd;
    }
    
    .btn {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.15s ease-in-out;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #ced4da;
    }
    
    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
    }
    
    .btn-outline-secondary:active {
        transform: translateY(0);
    }
    
    .tab-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 6px 6px 0 0;
        transition: all 0.15s ease-in-out;
    }
    
    .nav-tabs .nav-link:hover {
        color: #3498db;
        background: rgba(52, 152, 219, 0.1);
    }
    
    .nav-tabs .nav-link.active {
        color: #3498db;
        background: white;
        border-bottom: 3px solid #3498db;
        font-weight: 600;
    }
    
    .table th {
        background: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    
    .btn-primary {
        background: #3498db;
        border-color: #3498db;
    }
    
    .btn-primary:hover {
        background: #2980b9;
        border-color: #2980b9;
    }
    
    /* Loading state styles */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .loading-spinner {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        z-index: 10;
    }
    
    /* Filter row styling */
    .filter-row {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .filter-section {
            padding: 1rem;
        }
        
        .col-md-2, .col-md-3, .col-md-4 {
            margin-bottom: 1rem;
        }
        
        .btn-outline-secondary {
            width: 100%;
        }
    }
    
    /* Enhanced visual hierarchy */
    .filter-section .row:first-child {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    
    /* Select option styling */
    .form-select option {
        padding: 0.5rem;
    }
    
    /* Search input enhancement */
    .form-control::placeholder {
        color: #adb5bd;
        font-style: italic;
    }
    
    /* Hierarchical select styling */
    .hierarchy-group {
        display: flex;
        gap: 0.5rem;
        align-items: end;
    }
    
    .hierarchy-group .form-select {
        flex: 1;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hierarchy-group {
            flex-direction: column;
        }
        
        .col-md-2 {
            margin-bottom: 1rem;
        }
    }
    
    .tab-pane:not(.active) {
        display: none !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Print Labels</h2>
            </div>
            
            <!-- Search and Filter Section -->
            <div class="filter-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Search & Filter</h5>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="refreshBtn" title="Clear all filters">
                        <i class="bi bi-arrow-clockwise"></i> Clear All
                    </button>
                </div>
                
                <form method="GET" action="{{ route('print.index') }}" id="searchForm">
                    <!-- Row 1: Search, Category, Sub-Category -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Assets</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ $search ?? '' }}" placeholder="Search by name or code...">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="category_parent" class="form-label">Category</label>
                            <select class="form-select" id="category_parent">
                                <option value="">All Categories</option>
                                @foreach($categories->where('parent_id', null) as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">Sub Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">All Sub Categories</option>
                                @foreach($categories->where('parent_id', '!=', null) as $cat)
                                    <option value="{{ $cat->id }}" data-parent="{{ $cat->parent_id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Row 2: Division, Unit, Building, Floor, Room, Sub-Room -->
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="organization_parent" class="form-label">Division</label>
                            <select class="form-select" id="organization_parent">
                                <option value="">All Divisions</option>
                                @foreach($organizations->where('parent_id', null) as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="organization_id" class="form-label">Unit</label>
                            <select class="form-select" id="organization_id" name="organization_id">
                                <option value="">All Units</option>
                                @foreach($organizations->where('parent_id', '!=', null) as $org)
                                    <option value="{{ $org->id }}" data-parent="{{ $org->parent_id }}" {{ ($organizationId ?? '') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="infrastructure_building" class="form-label">Building</label>
                            <select class="form-select" id="infrastructure_building">
                                <option value="">All Buildings</option>
                                @foreach($infrastructures->where('parent_id', null) as $infra)
                                    <option value="{{ $infra->id }}">{{ $infra->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="infrastructure_floor" class="form-label">Floor</label>
                            <select class="form-select" id="infrastructure_floor">
                                <option value="">All Floors</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $infra)
                                    <option value="{{ $infra->id }}" data-parent="{{ $infra->parent_id }}">{{ $infra->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="infrastructure_room" class="form-label">Room</label>
                            <select class="form-select" id="infrastructure_room">
                                <option value="">All Rooms</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $infra)
                                    <option value="{{ $infra->id }}" data-parent="{{ $infra->parent_id }}">{{ $infra->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="infrastructure_id" class="form-label">Sub-Room</label>
                            <select class="form-select" id="infrastructure_id" name="infrastructure_id">
                                <option value="">All Sub-Rooms</option>
                                @foreach($infrastructures->where('parent_id', '!=', null) as $infra)
                                    <option value="{{ $infra->id }}" data-parent="{{ $infra->parent_id }}" {{ ($infrastructureId ?? '') == $infra->id ? 'selected' : '' }}>{{ $infra->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs card-header-tabs" id="printTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="print-tab" data-bs-toggle="tab" data-bs-target="#print" type="button" role="tab" aria-controls="print" aria-selected="true">Print</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reprint-tab" data-bs-toggle="tab" data-bs-target="#reprint" type="button" role="tab" aria-controls="reprint" aria-selected="false">Reprint</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="printTabsContent">
                        <div id="assetTablesContainer">
                            <!-- Print Tab -->
                            <div class="tab-pane fade show active" id="print" role="tabpanel" aria-labelledby="print-tab">
                                @include('print.partials.asset-table', [
                                    'assets' => $assetsToPrint,
                                    'tableId' => 'printAssetsTable',
                                    'bulkBtnId' => 'printSelectedBtn',
                                    'bulkBtnLabel' => 'Print Selected Labels',
                                    'tabType' => 'print',
                                ])
                            </div>
                            <!-- Reprint Tab -->
                            <div class="tab-pane fade" id="reprint" role="tabpanel" aria-labelledby="reprint-tab">
                                @include('print.partials.asset-table', [
                                    'assets' => $assetsToReprint,
                                    'tableId' => 'reprintAssetsTable',
                                    'bulkBtnId' => 'reprintSelectedBtn',
                                    'bulkBtnLabel' => 'Reprint Selected Labels',
                                    'tabType' => 'reprint',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Print Labels</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Review and select the label size for each asset:</p>
                    <div id="selectedAssetsList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPrintBtn">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Debounced search functionality
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const searchForm = document.getElementById('searchForm');
    const assetTablesContainer = document.getElementById('assetTablesContainer');
    
    // Function to update tables via AJAX
    function updateTables() {
        // Show loading state in the table area
        const activeTab = document.querySelector('.tab-pane.active');
        if (activeTab) {
            activeTab.innerHTML = `<div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading assets...</p>
            </div>`;
        }
        // Get form data
        const formData = new FormData(searchForm);
        const params = new URLSearchParams(formData);
        // Make AJAX request
        fetch(`{{ route('print.assetsTable') }}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the returned HTML and inject only the correct table
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            // Find which tab is active
            const activeTabId = document.querySelector('.tab-pane.active').id;
            let tableHtml = '';
            if (activeTabId === 'print') {
                const printTable = tempDiv.querySelector('#printAssetsTable');
                if (printTable) tableHtml = printTable.parentElement.outerHTML;
            } else if (activeTabId === 'reprint') {
                const reprintTable = tempDiv.querySelector('#reprintAssetsTable');
                if (reprintTable) tableHtml = reprintTable.parentElement.outerHTML;
            }
            document.getElementById(activeTabId).innerHTML = tableHtml;
            // Re-initialize any necessary JavaScript for the new content
            updatePrintButton();
            // Re-attach event listeners to checkboxes
            const checkboxes = document.querySelectorAll('input[name="selected_assets[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updatePrintButton);
            });
        })
        .catch(error => {
            if (activeTab) {
                activeTab.innerHTML = `<div class="text-center py-5">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        Error loading assets. Please try again.
                    </div>
                </div>`;
            }
        });
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateTables();
        }, 500);
    });
    
    // Refresh button functionality
    const refreshBtn = document.getElementById('refreshBtn');
    
    function clearAllFilters() {
        // Clear search input
        searchInput.value = '';
        
        // Reset all select fields to default
        const selectFields = searchForm.querySelectorAll('select');
        selectFields.forEach(select => {
            select.selectedIndex = 0;
        });
        
        // Update tables
        updateTables();
    }
    
    refreshBtn.addEventListener('click', clearAllFilters);
    
    // Hierarchical filtering for Category
    const categoryParent = document.getElementById('category_parent');
    const categorySelect = document.getElementById('category_id');
    
    categoryParent.addEventListener('change', function() {
        const parentId = this.value;
        
        // Reset child select
        categorySelect.selectedIndex = 0;
        
        if (parentId !== '') {
            // Enable child select and show only relevant options
            categorySelect.disabled = false;
            
            // Hide all child options first
            const options = categorySelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
            
            // Show only options that belong to the selected parent
            options.forEach(option => {
                if (option.getAttribute('data-parent') === parentId) {
                    option.style.display = '';
                }
            });
            
            // Auto-select first available child if only one exists
            const visibleOptions = Array.from(options).filter(opt => 
                opt.getAttribute('data-parent') === parentId
            );
            if (visibleOptions.length === 1) {
                categorySelect.value = visibleOptions[0].value;
            }
        } else {
            // If no parent selected, disable child select and hide all options
            categorySelect.disabled = true;
            const options = categorySelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
        }
        
        // Update tables via AJAX
        updateTables();
    });
    
    // Hierarchical filtering for Organization
    const organizationParent = document.getElementById('organization_parent');
    const organizationSelect = document.getElementById('organization_id');
    
    organizationParent.addEventListener('change', function() {
        const parentId = this.value;
        
        // Reset child select
        organizationSelect.selectedIndex = 0;
        
        if (parentId !== '') {
            // Enable child select and show only relevant options
            organizationSelect.disabled = false;
            
            // Hide all child options first
            const options = organizationSelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
            
            // Show only options that belong to the selected parent
            options.forEach(option => {
                if (option.getAttribute('data-parent') === parentId) {
                    option.style.display = '';
                }
            });
            
            // Auto-select first available child if only one exists
            const visibleOptions = Array.from(options).filter(opt => 
                opt.getAttribute('data-parent') === parentId
            );
            if (visibleOptions.length === 1) {
                organizationSelect.value = visibleOptions[0].value;
            }
        } else {
            // If no parent selected, disable child select and hide all options
            organizationSelect.disabled = true;
            const options = organizationSelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
        }
        
        // Update tables via AJAX
        updateTables();
    });
    
    // Hierarchical filtering for Infrastructure (3-level hierarchy)
    const infrastructureBuilding = document.getElementById('infrastructure_building');
    const infrastructureFloor = document.getElementById('infrastructure_floor');
    const infrastructureRoom = document.getElementById('infrastructure_room');
    const infrastructureSelect = document.getElementById('infrastructure_id');
    
    // Building change handler
    infrastructureBuilding.addEventListener('change', function() {
        const buildingId = this.value;
        
        // Reset all child selects
        infrastructureFloor.selectedIndex = 0;
        infrastructureRoom.selectedIndex = 0;
        infrastructureSelect.selectedIndex = 0;
        
        if (buildingId !== '') {
            // Enable floor select and show only relevant options
            infrastructureFloor.disabled = false;
            infrastructureRoom.disabled = true;
            infrastructureSelect.disabled = true;
            
            // Filter floors based on building
            const floorOptions = infrastructureFloor.querySelectorAll('option[data-parent]');
            floorOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            floorOptions.forEach(option => {
                if (option.getAttribute('data-parent') === buildingId) {
                    option.style.display = '';
                }
            });
            
            // Auto-select if only one floor exists
            const visibleFloors = Array.from(floorOptions).filter(opt => 
                opt.getAttribute('data-parent') === buildingId
            );
            if (visibleFloors.length === 1) {
                infrastructureFloor.value = visibleFloors[0].value;
                // Trigger floor change event
                infrastructureFloor.dispatchEvent(new Event('change'));
            } else {
                // Update tables via AJAX
                updateTables();
            }
        } else {
            // Disable all child selects and hide options
            infrastructureFloor.disabled = true;
            infrastructureRoom.disabled = true;
            infrastructureSelect.disabled = true;
            
            const floorOptions = infrastructureFloor.querySelectorAll('option[data-parent]');
            floorOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            updateTables();
        }
    });
    
    // Floor change handler
    infrastructureFloor.addEventListener('change', function() {
        const floorId = this.value;
        
        // Reset child selects
        infrastructureRoom.selectedIndex = 0;
        infrastructureSelect.selectedIndex = 0;
        
        if (floorId !== '') {
            // Enable room select and show only relevant options
            infrastructureRoom.disabled = false;
            infrastructureSelect.disabled = true;
            
            // Filter rooms based on floor
            const roomOptions = infrastructureRoom.querySelectorAll('option[data-parent]');
            roomOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            roomOptions.forEach(option => {
                if (option.getAttribute('data-parent') === floorId) {
                    option.style.display = '';
                }
            });
            
            // Auto-select if only one room exists
            const visibleRooms = Array.from(roomOptions).filter(opt => 
                opt.getAttribute('data-parent') === floorId
            );
            if (visibleRooms.length === 1) {
                infrastructureRoom.value = visibleRooms[0].value;
                // Trigger room change event
                infrastructureRoom.dispatchEvent(new Event('change'));
            } else {
                // Update tables via AJAX
                updateTables();
            }
        } else {
            // Disable child selects and hide options
            infrastructureRoom.disabled = true;
            infrastructureSelect.disabled = true;
            
            const roomOptions = infrastructureRoom.querySelectorAll('option[data-parent]');
            roomOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            updateTables();
        }
    });
    
    // Room change handler
    infrastructureRoom.addEventListener('change', function() {
        const roomId = this.value;
        
        // Reset child select
        infrastructureSelect.selectedIndex = 0;
        
        if (roomId !== '') {
            // Enable sub-room select and show only relevant options
            infrastructureSelect.disabled = false;
            
            // Filter sub-rooms based on room
            const subRoomOptions = infrastructureSelect.querySelectorAll('option[data-parent]');
            subRoomOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            subRoomOptions.forEach(option => {
                if (option.getAttribute('data-parent') === roomId) {
                    option.style.display = '';
                }
            });
            
            // Auto-select if only one sub-room exists
            const visibleSubRooms = Array.from(subRoomOptions).filter(opt => 
                opt.getAttribute('data-parent') === roomId
            );
            if (visibleSubRooms.length === 1) {
                infrastructureSelect.value = visibleSubRooms[0].value;
            } else {
                // Update tables via AJAX
                updateTables();
            }
        } else {
            // Disable child select and hide options
            infrastructureSelect.disabled = true;
            
            const subRoomOptions = infrastructureSelect.querySelectorAll('option[data-parent]');
            subRoomOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            updateTables();
        }
    });
    
    // Direct filter change handlers for immediate submission
    categorySelect.addEventListener('change', updateTables);
    organizationSelect.addEventListener('change', updateTables);
    infrastructureSelect.addEventListener('change', updateTables);
    
    // Initialize hierarchical displays based on current selections
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize category hierarchy
        if (categoryParent.value) {
            categoryParent.dispatchEvent(new Event('change'));
        } else {
            categorySelect.disabled = true;
            const options = categorySelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
        }
        
        // Initialize organization hierarchy
        if (organizationParent.value) {
            organizationParent.dispatchEvent(new Event('change'));
        } else {
            organizationSelect.disabled = true;
            const options = organizationSelect.querySelectorAll('option[data-parent]');
            options.forEach(option => {
                option.style.display = 'none';
            });
        }
        
        // Initialize infrastructure hierarchy
        if (infrastructureBuilding.value) {
            infrastructureBuilding.dispatchEvent(new Event('change'));
        } else {
            infrastructureFloor.disabled = true;
            infrastructureRoom.disabled = true;
            infrastructureSelect.disabled = true;
            
            const floorOptions = infrastructureFloor.querySelectorAll('option[data-parent]');
            const roomOptions = infrastructureRoom.querySelectorAll('option[data-parent]');
            const subRoomOptions = infrastructureSelect.querySelectorAll('option[data-parent]');
            
            floorOptions.forEach(option => {
                option.style.display = 'none';
            });
            roomOptions.forEach(option => {
                option.style.display = 'none';
            });
            subRoomOptions.forEach(option => {
                option.style.display = 'none';
            });
        }
        
        // Attach modal open to Print Selected Labels and Reprint Selected Labels buttons
        const printSelectedBtn = document.getElementById('printSelectedBtn');
        if (printSelectedBtn) printSelectedBtn.onclick = confirmBulkPrint;
        const reprintSelectedBtn = document.getElementById('reprintSelectedBtn');
        if (reprintSelectedBtn) reprintSelectedBtn.onclick = confirmBulkPrint;
    });
    
    // Bulk print functionality
    function selectAll(checked) {
        const checkboxes = document.querySelectorAll('input[name="selected_assets[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        updatePrintButton();
    }
    
    function updatePrintButton() {
        const checkboxes = document.querySelectorAll('input[name="selected_assets[]"]:checked');
        const printBtn = document.getElementById('bulkPrintBtn');
        if (printBtn) {
            printBtn.disabled = checkboxes.length === 0;
        }
    }
    
    // Add event listeners to checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_assets[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrintButton);
        });
        updatePrintButton();
    });
    
    function confirmBulkPrint() {
        const checkboxes = document.querySelectorAll('input.asset-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one asset to print.');
            return;
        }
        // Gather selected asset info from the table rows
        let tableHtml = `<div class='table-responsive'><table class='table table-bordered'><thead><tr><th>Code</th><th>Name</th><th>Category</th><th>
            Size <select id='setAllSize' class='form-select form-select-sm d-inline-block' style='width:auto; margin-left:8px;'>
                <option value=''>Set All</option>
                <option value='Small'>Small</option>
                <option value='Medium'>Medium</option>
                <option value='Large'>Large</option>
            </select>
        </th></tr></thead><tbody>`;
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            const code = row.querySelector('td:nth-child(2)').innerText;
            const name = row.querySelector('td:nth-child(3)').innerText;
            const category = row.querySelector('td:nth-child(4)').innerText;
            tableHtml += `<tr><td>${code}</td><td>${name}</td><td>${category}</td><td><select class='form-select form-select-sm label-size-select'><option value='Small'>Small</option><option value='Medium'>Medium</option><option value='Large'>Large</option></select></td></tr>`;
        });
        tableHtml += '</tbody></table></div>';
        document.getElementById('selectedAssetsList').innerHTML = tableHtml;
        // Set All event
        const setAllSize = document.getElementById('setAllSize');
        if (setAllSize) {
            setAllSize.addEventListener('change', function() {
                if (this.value) {
                    document.querySelectorAll('.label-size-select').forEach(sel => sel.value = this.value);
                }
            });
        }
        const modal = new bootstrap.Modal(document.getElementById('printModal'));
        modal.show();
    }
</script>
@endpush
@endsection 