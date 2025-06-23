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
        $assets = Asset::with(['category', 'organization', 'infrastructure'])->paginate(20);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:assets,code',
            'category_id' => 'nullable|exists:asset_categories,id',
            'organization_id' => 'required|exists:organizations,id',
            'infrastructure_id' => 'nullable|exists:infrastructures,id',
        ]);
        $validated['id'] = (string) Str::uuid();
        $asset = Asset::create($validated);
        return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::with(['category', 'organization', 'infrastructure', 'instances'])->findOrFail($id);
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
        $asset = Asset::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:assets,code,' . $asset->id . ',id',
            'category_id' => 'nullable|exists:asset_categories,id',
            'organization_id' => 'required|exists:organizations,id',
            'infrastructure_id' => 'nullable|exists:infrastructures,id',
        ]);
        $asset->update($validated);
        return redirect()->route('assets.index')->with('success', 'Asset updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully!');
    }
}
