<div class="table-responsive">
    <table class="table table-hover" id="{{ $tableId }}">
        <thead class="table-light">
            <tr>
                <th><input type="checkbox" class="form-check-input" onclick="Array.from(document.querySelectorAll('#{{ $tableId }} .asset-checkbox')).forEach(cb => cb.checked = this.checked)"></th>
                <th>Code</th>
                <th>Name</th>
                <th>SN</th>
                <th>Category</th>
                <th>Organization</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $asset)
            <tr>
                <td><input type="checkbox" class="form-check-input asset-checkbox" value="{{ $asset->id }}"></td>
                <td><strong>{{ $asset->code }}</strong></td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->serial_number ?? 'unavailable' }}</td>
                <td>{{ $asset->category->name ?? 'unavailable' }}</td>
                <td>
                    @if($asset->instances->count() > 0)
                        @foreach($asset->instances as $instance)
                            <span class="badge bg-info">{{ $instance->organization->name ?? 'unavailable' }}</span>@if(!$loop->last)<br>@endif
                        @endforeach
                    @else
                        <span class="badge bg-warning">No Organization</span>
                    @endif
                </td>
                <td>
                    @if($asset->instances->count() > 0)
                        @foreach($asset->instances as $instance)
                            <span class="badge bg-light text-dark">{{ $instance->infrastructure->name ?? 'unavailable' }}</span>@if(!$loop->last)<br>@endif
                        @endforeach
                    @else
                        <span class="badge bg-warning">No Location</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No assets found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end mt-2">
    <button type="button" class="btn btn-primary" id="{{ $bulkBtnId }}">
        <i class="bi bi-printer"></i> {{ $bulkBtnLabel }}
    </button>
</div> 