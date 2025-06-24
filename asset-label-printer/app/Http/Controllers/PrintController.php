<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    /**
     * Display the print index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Filters
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $organizationId = $request->input('organization_id');
        $infrastructureId = $request->input('infrastructure_id');

        $assetsQuery = \App\Models\Asset::query();
        
        if ($search) {
            $assetsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%") ;
            });
        }
        
        if ($categoryId) {
            // Check if this is a parent category - if so, include all child categories
            $category = \App\Models\AssetCategory::find($categoryId);
            if ($category && $category->parent_id === null) {
                // Parent category selected - get all child category IDs
                $childCategoryIds = \App\Models\AssetCategory::where('parent_id', $categoryId)->pluck('id');
                $assetsQuery->whereIn('category_id', $childCategoryIds);
            } else {
                // Specific category selected
                $assetsQuery->where('category_id', $categoryId);
            }
        }
        
        // For organization/infrastructure, filter by instance
        if ($organizationId) {
            // Check if this is a parent organization - if so, include all child organizations
            $organization = \App\Models\Organization::find($organizationId);
            if ($organization && $organization->parent_id === null) {
                // Parent organization selected - get all child organization IDs
                $childOrganizationIds = \App\Models\Organization::where('parent_id', $organizationId)->pluck('id');
                $assetsQuery->whereHas('instances', function($q) use ($childOrganizationIds) {
                    $q->whereIn('organization_id', $childOrganizationIds);
                });
            } else {
                // Specific organization selected
                $assetsQuery->whereHas('instances', function($q) use ($organizationId) {
                    $q->where('organization_id', $organizationId);
                });
            }
        }
        
        if ($infrastructureId) {
            // Check if this is a parent infrastructure - if so, include all child infrastructures
            $infrastructure = \App\Models\Infrastructure::find($infrastructureId);
            if ($infrastructure && $infrastructure->parent_id === null) {
                // Parent infrastructure selected - get all child infrastructure IDs
                $childInfrastructureIds = \App\Models\Infrastructure::where('parent_id', $infrastructureId)->pluck('id');
                $assetsQuery->whereHas('instances', function($q) use ($childInfrastructureIds) {
                    $q->whereIn('infrastructure_id', $childInfrastructureIds);
                });
            } else {
                // Specific infrastructure selected
                $assetsQuery->whereHas('instances', function($q) use ($infrastructureId) {
                    $q->where('infrastructure_id', $infrastructureId);
                });
            }
        }

        $assetsToPrint = (clone $assetsQuery)->whereNull('printed_at')->with(['category', 'instances.organization', 'instances.infrastructure'])->get();
        $assetsToReprint = (clone $assetsQuery)->whereNotNull('printed_at')->with(['category', 'instances.organization', 'instances.infrastructure'])->get();

        $categories = \App\Models\AssetCategory::all();
        $organizations = \App\Models\Organization::all();
        $infrastructures = \App\Models\Infrastructure::all();

        return view('print.index', compact('assetsToPrint', 'assetsToReprint', 'categories', 'organizations', 'infrastructures', 'search', 'categoryId', 'organizationId', 'infrastructureId'));
    }

    /**
     * Get asset table HTML for AJAX requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function assetsTable(Request $request)
    {
        // Filters
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $organizationId = $request->input('organization_id');
        $infrastructureId = $request->input('infrastructure_id');

        $assetsQuery = \App\Models\Asset::query();
        
        if ($search) {
            $assetsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%") ;
            });
        }
        
        if ($categoryId) {
            // Check if this is a parent category - if so, include all child categories
            $category = \App\Models\AssetCategory::find($categoryId);
            if ($category && $category->parent_id === null) {
                // Parent category selected - get all child category IDs
                $childCategoryIds = \App\Models\AssetCategory::where('parent_id', $categoryId)->pluck('id');
                $assetsQuery->whereIn('category_id', $childCategoryIds);
            } else {
                // Specific category selected
                $assetsQuery->where('category_id', $categoryId);
            }
        }
        
        // For organization/infrastructure, filter by instance
        if ($organizationId) {
            // Check if this is a parent organization - if so, include all child organizations
            $organization = \App\Models\Organization::find($organizationId);
            if ($organization && $organization->parent_id === null) {
                // Parent organization selected - get all child organization IDs
                $childOrganizationIds = \App\Models\Organization::where('parent_id', $organizationId)->pluck('id');
                $assetsQuery->whereHas('instances', function($q) use ($childOrganizationIds) {
                    $q->whereIn('organization_id', $childOrganizationIds);
                });
            } else {
                // Specific organization selected
                $assetsQuery->whereHas('instances', function($q) use ($organizationId) {
                    $q->where('organization_id', $organizationId);
                });
            }
        }
        
        if ($infrastructureId) {
            // Check if this is a parent infrastructure - if so, include all child infrastructures
            $infrastructure = \App\Models\Infrastructure::find($infrastructureId);
            if ($infrastructure && $infrastructure->parent_id === null) {
                // Parent infrastructure selected - get all child infrastructure IDs
                $childInfrastructureIds = \App\Models\Infrastructure::where('parent_id', $infrastructureId)->pluck('id');
                $assetsQuery->whereHas('instances', function($q) use ($childInfrastructureIds) {
                    $q->whereIn('infrastructure_id', $childInfrastructureIds);
                });
            } else {
                // Specific infrastructure selected
                $assetsQuery->whereHas('instances', function($q) use ($infrastructureId) {
                    $q->where('infrastructure_id', $infrastructureId);
                });
            }
        }

        $assetsToPrint = (clone $assetsQuery)->whereNull('printed_at')->with(['category', 'instances.organization', 'instances.infrastructure'])->get();
        $assetsToReprint = (clone $assetsQuery)->whereNotNull('printed_at')->with(['category', 'instances.organization', 'instances.infrastructure'])->get();

        return view('print.partials.asset-tables', compact('assetsToPrint', 'assetsToReprint'));
    }

    /**
     * Print a single asset label.
     *
     * @param  int  $asset
     * @return \Illuminate\Http\Response
     */
    public function single($asset)
    {
        // For now, return a simple view
        // Later this will generate and print the label
        return view('print.single', compact('asset'));
    }

    /**
     * Print multiple asset labels.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulk()
    {
        // For now, return a simple view
        // Later this will handle bulk printing
        return view('print.bulk');
    }

    /**
     * Generate QR code labels.
     *
     * @return \Illuminate\Http\Response
     */
    public function qr()
    {
        // For now, return a simple view
        // Later this will generate QR codes
        return view('print.qr');
    }

    /**
     * Reprint a label.
     *
     * @param  int  $print
     * @return \Illuminate\Http\Response
     */
    public function reprint($print)
    {
        // For now, return a simple view
        // Later this will reprint the label
        return view('print.reprint', compact('print'));
    }

    /**
     * Preview a label before printing.
     *
     * @param  int  $asset
     * @return \Illuminate\Http\Response
     */
    public function preview($asset)
    {
        // For now, return a simple view
        // Later this will show label preview
        return view('print.preview', compact('asset'));
    }

    /**
     * Generate and print a label for an asset.
     *
     * @param  int  $asset
     * @return \Illuminate\Http\Response
     */
    public function label($asset)
    {
        // For now, return a simple view
        // Later this will generate and print the label
        return view('print.label', compact('asset'));
    }
}
