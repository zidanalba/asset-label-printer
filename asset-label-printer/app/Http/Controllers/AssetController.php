<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Organization;
use App\Models\Infrastructure;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::with(['category', 'instances.organization', 'instances.infrastructure'])->paginate(20);
        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Models\AssetCategory::all();
        $organizations = \App\Models\Organization::all();
        $infrastructures = \App\Models\Infrastructure::all();
        return view('assets.create', compact('categories', 'organizations', 'infrastructures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Debug: Let's see what's being submitted
        \Log::info('Asset creation request data:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:assets,code',
            'serial_number' => 'nullable|string|max:64',
            'category_id' => 'nullable|array',
            'category_id.*' => 'nullable|exists:asset_categories,id',
            'organization_id' => 'nullable|array',
            'organization_id.*' => 'nullable|exists:organizations,id',
            'infrastructure_id' => 'nullable|array',
            'infrastructure_id.*' => 'nullable|exists:infrastructures,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Take the last non-empty value from each array
        $categoryArray = !empty($validated['category_id']) ? array_filter($validated['category_id']) : [];
        $organizationArray = !empty($validated['organization_id']) ? array_filter($validated['organization_id']) : [];
        $infrastructureArray = !empty($validated['infrastructure_id']) ? array_filter($validated['infrastructure_id']) : [];
        
        $categoryId = !empty($categoryArray) ? end($categoryArray) : null;
        $organizationId = !empty($organizationArray) ? end($organizationArray) : null;
        $infrastructureId = !empty($infrastructureArray) ? end($infrastructureArray) : null;

        // Debug: Let's see the final values
        \Log::info('Final values:', [
            'category_id' => $categoryId,
            'organization_id' => $organizationId,
            'infrastructure_id' => $infrastructureId
        ]);

        // Validate that at least one organization is selected
        if (!$organizationId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['organization_id' => 'Please select either a Division or Unit.']);
        }

        try {
            \DB::beginTransaction();
            
            $assetData = [
                'id' => (string) Str::uuid(),
                'name' => $validated['name'],
                'code' => $validated['code'],
                'serial_number' => $validated['serial_number'] ?? null,
                'category_id' => $categoryId,
            ];
            
            $asset = Asset::create($assetData);
            
            $instanceData = [
                'id' => (string) Str::uuid(),
                'asset_id' => $asset->id,
                'organization_id' => $organizationId,
                'infrastructure_id' => $infrastructureId,
                'qty' => $validated['qty'],
                'status' => 'active', // Set default status
            ];
            
            \App\Models\AssetInstance::create($instanceData);
            
            \DB::commit();
            
            return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
            
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create asset: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::with(['category', 'instances.organization', 'instances.infrastructure'])->findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $categories = AssetCategory::all();
        $organizations = Organization::all();
        $infrastructures = Infrastructure::all();
        return view('assets.edit', compact('asset', 'categories', 'organizations', 'infrastructures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:assets,code,' . $id . ',id',
            'serial_number' => 'nullable|string|max:64',
            'category_id' => 'nullable|array',
            'category_id.*' => 'nullable|exists:asset_categories,id',
            'organization_id' => 'nullable|array',
            'organization_id.*' => 'nullable|exists:organizations,id',
            'infrastructure_id' => 'nullable|array',
            'infrastructure_id.*' => 'nullable|exists:infrastructures,id',
            'qty' => 'required|integer|min:1',
        ]);

        $categoryArray = !empty($validated['category_id']) ? array_filter($validated['category_id']) : [];
        $organizationArray = !empty($validated['organization_id']) ? array_filter($validated['organization_id']) : [];
        $infrastructureArray = !empty($validated['infrastructure_id']) ? array_filter($validated['infrastructure_id']) : [];

        $categoryId = !empty($categoryArray) ? end($categoryArray) : null;
        $organizationId = !empty($organizationArray) ? end($organizationArray) : null;
        $infrastructureId = !empty($infrastructureArray) ? end($infrastructureArray) : null;

        if (!$organizationId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['organization_id' => 'Please select either a Division or Unit.']);
        }

        try {
            \DB::beginTransaction();

            $asset = Asset::findOrFail($id);
            $asset->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'serial_number' => $validated['serial_number'] ?? null,
                'category_id' => $categoryId,
            ]);

            // Update the first instance (or create if not exists)
            $instance = $asset->instances()->first();
            if ($instance) {
                $instance->update([
                    'organization_id' => $organizationId,
                    'infrastructure_id' => $infrastructureId,
                    'qty' => $validated['qty'],
                ]);
            } else {
                \App\Models\AssetInstance::create([
                    'id' => (string) Str::uuid(),
                    'asset_id' => $asset->id,
                    'organization_id' => $organizationId,
                    'infrastructure_id' => $infrastructureId,
                    'qty' => $validated['qty'],
                    'status' => 'active',
                ]);
            }

            \DB::commit();
            return redirect()->route('assets.index')->with('success', 'Asset updated successfully!');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update asset: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            \DB::beginTransaction();
            
            $asset = Asset::findOrFail($id);
            // Delete all related asset instances
            $asset->instances()->delete();
            // Delete the asset
            $asset->delete();
            
            \DB::commit();
            
            return redirect()->route('assets.index')->with('success', 'Asset and its instances deleted successfully!');
            
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to delete asset: ' . $e->getMessage()]);
        }
    }
}
