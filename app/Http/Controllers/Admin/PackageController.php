<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.packages.index', ['packages' => Package::latest()->paginate(12)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);
        Package::create($validated);

        return to_route('admin.packages.index')->with('status', 'Package created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package): View
    {
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package): View
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);
        $package->update($validated);

        return to_route('admin.packages.index')->with('status', 'Package updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        if ($package->orders()->exists()) {
            return back()->with('error', 'Packages with orders cannot be deleted. Deactivate it instead.');
        }

        $package->delete();

        return to_route('admin.packages.index')->with('status', 'Package deleted.');
    }

    public function toggle(Package $package): RedirectResponse
    {
        $package->update(['status' => ! $package->status]);

        return back()->with('status', 'Package status updated.');
    }
}
